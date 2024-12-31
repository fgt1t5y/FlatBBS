import type { ExecuteRule } from '../interface';

const pattern: ExecuteRule = (rule, value, source, errors, options) => {
  if (rule.pattern) {
    if (rule.pattern instanceof RegExp) {
      // if a RegExp instance is passed, reset `lastIndex` in case its `global`
      // flag is accidentally set to `true`, which in a validation scenario
      // is not necessary and the result might be misleading
      rule.pattern.lastIndex = 0;
      if (!rule.pattern.test(value)) {
        errors.push(
          options.t('form.pattern', [
            rule.label! || rule.fullField!,
            value,
            rule.pattern,
          ]),
        );
      }
    } else if (typeof rule.pattern === 'string') {
      const _pattern = new RegExp(rule.pattern);
      if (!_pattern.test(value)) {
        errors.push(
          options.t('form.pattern', [
            rule.label! || rule.fullField!,
            value,
            rule.pattern,
          ]),
        );
      }
    }
  }
};

export default pattern;
