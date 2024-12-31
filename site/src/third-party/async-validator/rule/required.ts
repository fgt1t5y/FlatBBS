import type { ExecuteRule } from '../interface';
import { isEmptyValue } from '../util';

const required: ExecuteRule = (rule, value, source, errors, options, type) => {
  if (
    rule.required &&
    (!source.hasOwnProperty(rule.field) ||
      isEmptyValue(value, type || rule.type))
  ) {
    errors.push(options.t('form.required', [rule.label! || rule.fullField!]));
  }
};

export default required;
