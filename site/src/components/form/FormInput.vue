<template>
  <div class="form-item">
    <label v-if="label" :for="inputId">
      {{ label }}
      <span v-if="required" class="form-item-required">*</span>
    </label>
    <div :class="inputClass">
      <input
        :id="inputId"
        v-model="inputValue"
        class="input-widget"
        :autocomplete="autocomplete"
        :disabled="disabled || context!.disabled"
        :name="name"
        :type="type"
        :readonly="readonly"
        :placeholder="placeholder"
        :required="required"
        :aria-disabled="disabled || context!.disabled"
        :aria-required="required"
        :aria-invalid="!!errorMessage"
        :aria-errormessage="inputErrorMessageId"
        @blur="context?.onFormItemBlur"
      />
    </div>
    <div class="form-item-error">
      <span :id="inputErrorMessageId">
        {{ errorMessage || '&nbsp;' }}
      </span>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, inject, onMounted, useId } from 'vue'
import { formContextKey } from '@/utils'

import type { IFormContext } from '@/types'
import type {
  RuleType,
  SyncValidateFunction,
} from '@/third-party/async-validator'

defineOptions({
  name: 'FormInput',
})

interface FormInputProps {
  name: string
  autocomplete?: string
  type?: 'text' | 'password'
  disabled?: boolean
  datatype?: RuleType
  label?: string
  readonly?: boolean
  required?: boolean
  placeholder?: string
  min?: number
  max?: number
  len?: number
  validator?: SyncValidateFunction
}

const props = withDefaults(defineProps<FormInputProps>(), {
  autocomplete: undefined,
  datatype: 'string',
  type: 'text',
  label: undefined,
  readonly: false,
  required: false,
  placeholder: undefined,
  min: undefined,
  max: undefined,
  len: undefined,
  validator: undefined,
})

const inputValue = defineModel<string>('modelValue', { default: '' })

const inputId = useId()
const inputErrorMessageId = useId()

const context = inject<IFormContext>(formContextKey)

const errorMessage = computed(() => {
  if (
    !context?.errorMessages.value ||
    !context?.errorMessages.value[props.name]
  ) {
    return null
  }

  return context?.errorMessages.value[props.name][0].message
})

const inputClass = computed(() => ({
  input: true,
  'input-status-error': !!errorMessage.value,
}))

onMounted(() => {
  context!.rules.value[props.name] = {
    label: props.label,
    type: props.datatype,
    required: props.required,
    min: props.min,
    max: props.max,
    len: props.len,
    validator: props.validator,
  }
})
</script>
