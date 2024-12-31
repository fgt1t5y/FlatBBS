import type { ExecuteValidator } from '../interface';
import rules from '../rule';
import { isEmptyValue } from '../util';

const type: ExecuteValidator = (rule, value, callback, source, options) => {
  const ruleType = rule.type;
  const errors: string[] = [];
  const validate =
    rule.required ||
    (!rule.required &&
      Object.prototype.hasOwnProperty.call(source, rule.field!));
  if (validate) {
    if (isEmptyValue(value, ruleType) && !rule.required) {
      return callback();
    }
    rules.required(rule, value, source, errors, options, ruleType);
    if (!isEmptyValue(value, ruleType)) {
      rules.type(rule, value, source, errors, options);
    }
  }
  callback(errors);
};

export default type;
