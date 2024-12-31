<template>
  <div class="form-item">
    <label v-if="label" class="form-label" :for="inputId">{{ label }}</label>
    <div class="input">
      <input
        :id="inputId"
        v-model="inputValue"
        class="input-widget"
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
import type { RuleType } from '@/third-party/async-validator'

defineOptions({
  name: 'FormInput',
})

interface FormInputProps {
  name: string
  type?: 'text' | 'password'
  datatype?: RuleType
  label?: string
  readonly?: boolean
  required?: boolean
  placeholder?: string
  min?: number
  max?: number
  len?: number
}

const props = withDefaults(defineProps<FormInputProps>(), {
  datatype: 'string',
  type: 'text',
  label: undefined,
  readonly: false,
  required: false,
  placeholder: undefined,
  min: undefined,
  max: undefined,
  len: undefined,
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
  }
})
</script>
