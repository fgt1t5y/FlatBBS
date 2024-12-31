// >>>>> Rule
// Modified from https://github.com/yiminghe/async-validator/blob/0d51d60086a127b21db76f44dff28ae18c165c47/src/index.d.ts
export type RuleType =
  | 'string'
  | 'number'
  | 'boolean'
  | 'method'
  | 'regexp'
  | 'integer'
  | 'float'
  | 'array'
  | 'object'
  | 'enum'
  | 'date'
  | 'url'
  | 'hex'
  | 'email'
  | 'pattern'
  | 'any';

export interface ValidateOption {
  // whether to suppress internal warning
  suppressWarning?: boolean;

  // whether to suppress validator error
  suppressValidatorError?: boolean;

  // when the first validation rule generates an error stop processed
  first?: boolean;

  // when the first validation rule of the specified field generates an error stop the field processed, 'true' means all fields.
  firstFields?: boolean | string[];

  /** The name of rules need to be trigger. Will validate all rules if leave empty */
  keys?: string[];

  error?: (rule: InternalRuleItem, message: string) => ValidateError;

  // translator function
  t: (key: string, slot: string[]) => string;
}

export type SyncErrorType = Error | string;
export type SyncValidateResult = boolean | SyncErrorType | SyncErrorType[];
export type ValidateResult = void | Promise<void> | SyncValidateResult;

export type SyncValidateFunction = (
  rule: InternalRuleItem,
  value: Value,
  callback: (error?: string | Error) => void,
  source: Values,
  options: ValidateOption,
) => SyncValidateResult | void;

export interface RuleItem {
  label?: string;
  type?: RuleType; // default type is 'string'
  required?: boolean;
  pattern?: RegExp | string;
  min?: number; // Range of type 'string' and 'array'
  max?: number; // Range of type 'string' and 'array'
  len?: number; // Length of type 'string' and 'array'
  enum?: (string | number | boolean | null | undefined)[]; // possible values of type 'enum'
  whitespace?: boolean;
  fields?: Record<string, Rule>; // ignore when without required
  options?: ValidateOption;
  defaultField?: Rule; // 'object' or 'array' containing validation rules
  transform?: (value: Value) => Value;
  message?: string | ((a?: string) => string);
  asyncValidator?: (
    rule: InternalRuleItem,
    value: Value,
    callback: (error?: string | Error) => void,
    source: Values,
    options: ValidateOption,
  ) => void | Promise<void>;
  validator?: SyncValidateFunction;
}

export type Rule = RuleItem | RuleItem[];

export type Rules = Record<string, Rule>;

/**
 *  Rule for validating a value exists in an enumerable list.
 *
 *  @param rule The validation rule.
 *  @param value The value of the field on the source object.
 *  @param source The source object being validated.
 *  @param errors An array of errors that this rule may add
 *  validation errors to.
 *  @param options The validation options.
 *  @param options.messages The validation messages.
 *  @param type Rule type
 */
export type ExecuteRule = (
  rule: InternalRuleItem,
  value: Value,
  source: Values,
  errors: string[],
  options: ValidateOption,
  type?: string,
) => void;

/**
 *  Performs validation for any type.
 *
 *  @param rule The validation rule.
 *  @param value The value of the field on the source object.
 *  @param callback The callback function.
 *  @param source The source object being validated.
 *  @param options The validation options.
 *  @param options.messages The validation messages.
 */
export type ExecuteValidator = (
  rule: InternalRuleItem,
  value: Value,
  callback: (error?: string[]) => void,
  source: Values,
  options: ValidateOption,
) => void;

// >>>>> Values
export type Value = any;
export type Values = Record<string, Value>;

// >>>>> Validate
export interface ValidateError {
  message?: string;
  fieldValue?: Value;
  field?: string;
}

export interface ValidateErrorMap {
  [name: string]: ValidateError[];
}

export type ValidateFieldsError = Record<string, ValidateError[]>;

export type ValidateCallback = (
  errors: ValidateError[] | null,
  fields: ValidateFieldsError | Values,
) => void;

export interface RuleValuePackage {
  rule: InternalRuleItem;
  value: Value;
  source: Values;
  field: string;
}

export interface InternalRuleItem extends Omit<RuleItem, 'validator'> {
  field?: string;
  fullField?: string;
  fullFields?: string[];
  validator?: RuleItem['validator'] | ExecuteValidator;
}
