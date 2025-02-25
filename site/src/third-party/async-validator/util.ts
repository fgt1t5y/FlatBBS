import type {
  InternalRuleItem,
  RuleValuePackage,
  ValidateError,
  ValidateOption,
  Value,
  Values,
} from './interface';

export function convertFieldsError(
  errors: ValidateError[],
): Record<string, ValidateError[]> | null {
  if (!errors || !errors.length) {
    return null;
  }
  const fields = {};
  errors.forEach((error) => {
    const field = error.field;
    //@ts-expect-error ignore
    fields[field] = fields[field] || [];
    //@ts-expect-error ignore
    fields[field].push(error);
  });
  return fields;
}

function isNativeStringType(type: string) {
  return (
    type === 'string' ||
    type === 'url' ||
    type === 'hex' ||
    type === 'email' ||
    type === 'date' ||
    type === 'pattern'
  );
}

export function isEmptyValue(value: Value, type?: string) {
  if (value === undefined || value === null) {
    return true;
  }
  if (type === 'array' && Array.isArray(value) && !value.length) {
    return true;
  }
  //@ts-expect-error ignore
  if (isNativeStringType(type) && typeof value === 'string' && !value) {
    return true;
  }
  return false;
}

function asyncParallelArray(
  arr: RuleValuePackage[],
  func: ValidateFunc,
  callback: (errors: ValidateError[]) => void,
) {
  const results: ValidateError[] = [];
  let total = 0;
  const arrLength = arr.length;

  function count(errors: ValidateError[]) {
    results.push(...(errors || []));
    total++;
    if (total === arrLength) {
      callback(results);
    }
  }

  arr.forEach((a) => {
    func(a, count);
  });
}

function asyncSerialArray(
  arr: RuleValuePackage[],
  func: ValidateFunc,
  callback: (errors: ValidateError[]) => void,
) {
  let index = 0;
  const arrLength = arr.length;

  function next(errors: ValidateError[]) {
    if (errors && errors.length) {
      callback(errors);
      return;
    }
    const original = index;
    index = index + 1;
    if (original < arrLength) {
      func(arr[original], next);
    } else {
      callback([]);
    }
  }

  next([]);
}

function flattenObjArr(objArr: Record<string, RuleValuePackage[]>) {
  const ret: RuleValuePackage[] = [];
  Object.keys(objArr).forEach((k) => {
    ret.push(...(objArr[k] || []));
  });
  return ret;
}

export class AsyncValidationError extends Error {
  errors: ValidateError[];
  fields: Record<string, ValidateError[]>;

  constructor(
    errors: ValidateError[],
    fields: Record<string, ValidateError[]> | null,
  ) {
    super('Async Validation Error');
    this.errors = errors;
    this.fields = fields || {};
  }
}

type ValidateFunc = (
  data: RuleValuePackage,
  doIt: (errors: ValidateError[]) => void,
) => void;

export function asyncMap(
  objArr: Record<string, RuleValuePackage[]>,
  option: ValidateOption,
  func: ValidateFunc,
  callback: (errors: ValidateError[]) => void,
  source: Values,
): Promise<Values> {
  if (option.first) {
    const pending = new Promise<Values>((resolve, reject) => {
      const next = (errors: ValidateError[]) => {
        callback(errors);
        return errors.length
          ? reject(new AsyncValidationError(errors, convertFieldsError(errors)))
          : resolve(source);
      };
      const flattenArr = flattenObjArr(objArr);
      asyncSerialArray(flattenArr, func, next);
    });
    pending.catch((e) => e);
    return pending;
  }
  const firstFields =
    option.firstFields === true
      ? Object.keys(objArr)
      : option.firstFields || [];

  const objArrKeys = Object.keys(objArr);
  const objArrLength = objArrKeys.length;
  let total = 0;
  const results: ValidateError[] = [];
  const pending = new Promise<Values>((resolve, reject) => {
    const next = (errors: ValidateError[]) => {
      // eslint-disable-next-line prefer-spread
      results.push.apply(results, errors);
      total++;
      if (total === objArrLength) {
        callback(results);
        return results.length
          ? reject(
              new AsyncValidationError(results, convertFieldsError(results)),
            )
          : resolve(source);
      }
    };
    if (!objArrKeys.length) {
      callback(results);
      resolve(source);
    }
    objArrKeys.forEach((key) => {
      const arr = objArr[key];
      if (firstFields.indexOf(key) !== -1) {
        asyncSerialArray(arr, func, next);
      } else {
        asyncParallelArray(arr, func, next);
      }
    });
  });
  pending.catch((e) => e);
  return pending;
}

function isErrorObj(
  obj: ValidateError | string | (() => string),
): obj is ValidateError {
  return !!(obj && (obj as ValidateError).message !== undefined);
}

function getValue(value: Values, path: string[]) {
  let v = value;
  for (let i = 0; i < path.length; i++) {
    if (v == undefined) {
      return v;
    }
    v = v[path[i]];
  }
  return v;
}

export function complementError(rule: InternalRuleItem, source: Values) {
  return (oe: ValidateError | (() => string) | string): ValidateError => {
    let fieldValue;
    if (rule.fullFields) {
      fieldValue = getValue(source, rule.fullFields);
    } else {
      fieldValue = source[(oe as any).field || rule.fullField];
    }
    if (isErrorObj(oe)) {
      oe.field = oe.field || rule.fullField;
      oe.fieldValue = fieldValue;
      return oe;
    }
    return {
      message: typeof oe === 'function' ? oe() : oe,
      fieldValue,
      field: (oe as unknown as ValidateError).field || rule.fullField,
    };
  };
}
