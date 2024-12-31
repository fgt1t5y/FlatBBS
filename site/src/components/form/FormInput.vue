<template>
  <div class="form-item">
    <label v-if="label" class="form-label" :for="inputId">{{ label }}</label>
    <div class="input">
      <input
        :id="inputId"
        v-model="inputValue"
        class="input-widget"
        :autocomplete="autocomplete"
        :name="name"
        :type="type"
        :readonly="readonly"
        :placeholder="placeholder"
        @blur="context?.onFormItemBlur"
      />
    </div>
    <div v-if="errorMessage" class="form-item-error">
      {{ errorMessage }}
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

onMounted(() => {
  context!.rules.value[props.name] = {
    type: props.datatype,
    required: props.required,
    min: props.min,
    max: props.max,
    len: props.len,
    validator: props.validator,
  }
})
</script>
