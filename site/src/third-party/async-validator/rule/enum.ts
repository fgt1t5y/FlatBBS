import type { ExecuteRule } from '../interface';

const ENUM = 'enum' as const;

const enumerable: ExecuteRule = (rule, value, source, errors, options) => {
  rule[ENUM] = Array.isArray(rule[ENUM]) ? rule[ENUM] : [];
  if (rule[ENUM].indexOf(value) === -1) {
    errors.push(options.translator('form.enum', [rule.fullField!, rule[ENUM].join(', ')]));
  }
};

export default enumerable;
