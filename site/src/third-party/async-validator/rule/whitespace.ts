import type { ExecuteRule } from '../interface';

/**
 *  Rule for validating whitespace.
 *
 *  @param rule The validation rule.
 *  @param value The value of the field on the source object.
 *  @param source The source object being validated.
 *  @param errors An array of errors that this rule may add
 *  validation errors to.
 *  @param options The validation options.
 *  @param options.messages The validation messages.
 */
const whitespace: ExecuteRule = (rule, value, source, errors, options) => {
  if (/^\s+$/.test(value) || value === '') {
    errors.push(options.t('form.whitespace', [rule.label! || rule.fullField!]));
  }
};

export default whitespace;
