import type { ExecuteValidator } from '../interface';
import rules from '../rule';
import { isEmptyValue } from '../util';

const number: ExecuteValidator = (rule, value, callback, source, options) => {
  const errors: string[] = [];
  const validate =
    rule.required ||
    (!rule.required &&
      Object.prototype.hasOwnProperty.call(source, rule.field!));
  if (validate) {
    if (value === '') {
      // eslint-disable-next-line no-param-reassign
      value = undefined;
    }
    if (isEmptyValue(value) && !rule.required) {
      return callback();
    }
    rules.required(rule, value, source, errors, options);
    if (value !== undefined) {
      rules.type(rule, value, source, errors, options);
      rules.range(rule, value, source, errors, options);
    }
  }
  callback(errors);
};

export default number;
