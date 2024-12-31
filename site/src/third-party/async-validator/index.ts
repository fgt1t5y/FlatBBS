import type {
  InternalRuleItem,
  Rule,
  RuleItem,
  RuleType,
  RuleValuePackage,
  Rules,
  SyncErrorType,
  ValidateCallback,
  ValidateError,
  ValidateFieldsError,
  ValidateOption,
  ValidateResult,
  Values,
} from './interface';
import { asyncMap, complementError, convertFieldsError } from './util';
import validators from './validator/index';

export * from './interface';

/**
 *  Encapsulates a validation schema.
 *
 *  @param descriptor An object declaring validation rules
 *  for this schema.
 */
export class Schema {
  // ========================= Static =========================
  static validators = validators;

  // ======================== Instance ========================
  rules: Record<string, RuleItem[]> = null;

  constructor(descriptor: Rules) {
    this.define(descriptor);
  }

  define(rules: Rules) {
    if (!rules) {
      throw new Error('Cannot configure a schema with no rules');
    }
    if (typeof rules !== 'object' || Array.isArray(rules)) {
      throw new Error('Rules must be an object');
    }
    this.rules = {};

    Object.keys(rules).forEach((name) => {
      const item: Rule = rules[name];
      this.rules[name] = Array.isArray(item) ? item : [item];
    });
  }

  validate(
    source: Values,
    option?: ValidateOption,
    callback?: ValidateCallback,
  ): Promise<Values>;
  validate(source: Values, callback: ValidateCallback): Promise<Values>;
  validate(source: Values): Promise<Values>;
  validate(source_: Values, o: any = {}, oc: any = () => {}): Promise<Values> {
    let source: Values = source_;
    const options: ValidateOption = o;
    const callback: ValidateCallback = oc;
    if (!this.rules || Object.keys(this.rules).length === 0) {
      if (callback) {
        callback(null, source);
      }
      return Promise.resolve(source);
    }

    function complete(results: (ValidateError | ValidateError[])[]) {
      let errors: ValidateError[] = [];
      let fields: ValidateFieldsError = {};

      function add(e: ValidateError | ValidateError[]) {
        if (Array.isArray(e)) {
          errors = errors.concat(...e);
        } else {
          errors.push(e);
        }
      }

      for (let i = 0; i < results.length; i++) {
        add(results[i]);
      }
      if (!errors.length) {
        callback(null, source);
      } else {
        fields = convertFieldsError(errors);
        (
          callback as (
            errors: ValidateError[],
            fields: ValidateFieldsError,
          ) => void
        )(errors, fields);
      }
    }

    const series: Record<string, RuleValuePackage[]> = {};
    const keys = options.keys || Object.keys(this.rules);
    keys.forEach((z) => {
      const arr = this.rules[z];
      let value = source[z];
      arr.forEach((r) => {
        let rule: InternalRuleItem = r;
        if (typeof rule.transform === 'function') {
          if (source === source_) {
            source = { ...source };
          }
          value = source[z] = rule.transform(value);
          if (value !== undefined && value !== null) {
            rule.type =
              rule.type ||
              ((Array.isArray(value) ? 'array' : typeof value) as RuleType);
          }
        }
        if (typeof rule === 'function') {
          rule = {
            validator: rule,
          };
        } else {
          rule = { ...rule };
        }

        // Fill validator. Skip if nothing need to validate
        rule.validator = this.getValidationMethod(rule);
        if (!rule.validator) {
          return;
        }

        rule.field = z;
        rule.fullField = rule.fullField || z;
        rule.type = this.getType(rule);
        series[z] = series[z] || [];
        series[z].push({
          rule,
          value,
          source,
          field: z,
        });
      });
    });
    const errorFields = {};
    return asyncMap(
      series,
      options,
      (data, doIt) => {
        const rule = data.rule;
        let deep =
          (rule.type === 'object' || rule.type === 'array') &&
          (typeof rule.fields === 'object' ||
            typeof rule.defaultField === 'object');
        deep = deep && (rule.required || (!rule.required && data.value));
        rule.field = data.field;

        function addFullField(key: string, schema: RuleItem) {
          return {
            ...schema,
            fullField: `${rule.fullField}.${key}`,
            fullFields: rule.fullFields ? [...rule.fullFields, key] : [key],
          };
        }

        function cb(e: SyncErrorType | SyncErrorType[] = []) {
          let errorList = Array.isArray(e) ? e : [e];
          if (errorList.length && rule.message !== undefined) {
            errorList = [].concat(rule.message);
          }

          // Fill error info
          let filledErrors = errorList.map(complementError(rule, source));

          if (options.first && filledErrors.length) {
            errorFields[rule.field] = 1;
            return doIt(filledErrors);
          }
          if (!deep) {
            doIt(filledErrors);
          } else {
            // if rule is required but the target object
            // does not exist fail at the rule level and don't
            // go deeper
            if (rule.required && !data.value) {
              if (rule.message !== undefined) {
                filledErrors = []
                  // @ts-expect-error ignore
                  .concat(rule.message)
                  .map(complementError(rule, source));
              } else if (options.error) {
                filledErrors = [
                  options.error(
                    rule,
                    options.t('form.required', [rule.field!]),
                  ),
                ];
              }
              return doIt(filledErrors);
            }

            let fieldsSchema: Record<string, Rule> = {};
            if (rule.defaultField) {
              Object.keys(data.value).map((key) => {
                fieldsSchema[key] = rule.defaultField!;
              });
            }
            fieldsSchema = {
              ...fieldsSchema,
              ...data.rule.fields,
            };

            const paredFieldsSchema: Record<string, RuleItem[]> = {};

            Object.keys(fieldsSchema).forEach((field) => {
              const fieldSchema = fieldsSchema[field];
              const fieldSchemaList = Array.isArray(fieldSchema)
                ? fieldSchema
                : [fieldSchema];
              paredFieldsSchema[field] = fieldSchemaList.map(
                addFullField.bind(null, field),
              );
            });
            const schema = new Schema(paredFieldsSchema);
            if (data.rule.options) {
              data.rule.options.error = options.error;
            }
            schema.validate(
              data.value,
              data.rule.options || options,
              (errs) => {
                const finalErrors: ValidateError[] = [];
                if (filledErrors && filledErrors.length) {
                  finalErrors.push(...filledErrors);
                }
                if (errs && errs.length) {
                  finalErrors.push(...errs);
                }
                doIt(finalErrors.length ? finalErrors : null);
              },
            );
          }
        }

        let res: ValidateResult = undefined;
        if (rule.asyncValidator) {
          res = rule.asyncValidator(rule, data.value, cb, data.source, options);
        } else if (rule.validator) {
          try {
            res = rule.validator(rule, data.value, cb, data.source, options);
          } catch (error: any) {
            console.error?.(error);
            // rethrow to report error
            if (!options.suppressValidatorError) {
              setTimeout(() => {
                throw error;
              }, 0);
            }
            cb(error.message);
          }
          if (res === true) {
            cb();
          } else if (res === false) {
            cb(
              typeof rule.message === 'function'
                ? rule.message(rule.fullField || rule.field)
                : rule.message || `${rule.fullField || rule.field} fails`,
            );
          } else if (res instanceof Array) {
            cb(res);
          } else if (res instanceof Error) {
            cb(res.message);
          }
        }
        if (res && (res as Promise<void>).then) {
          (res as Promise<void>).then(
            () => cb(),
            (e) => cb(e),
          );
        }
      },
      (results) => {
        complete(results);
      },
      source,
    );
  }

  getType(rule: InternalRuleItem) {
    if (rule.type === undefined && rule.pattern instanceof RegExp) {
      rule.type = 'pattern';
    }
    if (
      typeof rule.validator !== 'function' &&
      rule.type &&
      // eslint-disable-next-line no-prototype-builtins
      !validators.hasOwnProperty(rule.type)
    ) {
      throw new Error(`'Unknown rule type ${rule.type}`);
    }
    return rule.type || 'string';
  }

  getValidationMethod(rule: InternalRuleItem) {
    if (typeof rule.validator === 'function') {
      return rule.validator;
    }
    const keys = Object.keys(rule);
    const messageIndex = keys.indexOf('message');
    if (messageIndex !== -1) {
      keys.splice(messageIndex, 1);
    }
    if (keys.length === 1 && keys[0] === 'required') {
      return validators.required;
    }
    return validators[this.getType(rule)] || undefined;
  }
}
