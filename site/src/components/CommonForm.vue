<template>
  <form class="form" @submit="onFormSubmit">
    <slot />
    <div v-if="submitLabel" class="form-default-submit">
      <button
        class="btn-primary btn-md"
        :disabled="disabled"
        @click="onFormSubmit"
      >
        {{ submitLabel }}
      </button>
    </div>
  </form>
</template>

<script setup lang="ts">
import { computed, provide, ref, toValue } from 'vue'
import { formContextKey } from '@/utils'
import { Schema } from '@/third-party/async-validator'
import { useI18n } from 'vue-i18n'

import type { FormContext } from '@/types'
import type {
  Rules,
  Values,
  ValidateErrorMap,
} from '@/third-party/async-validator'

defineOptions({
  name: 'CommonForm',
})

interface CommonFormProps {
  form: Values
  disabled?: boolean
  submitLabel?: string
}

const props = defineProps<CommonFormProps>()
const emits = defineEmits<{
  (e: 'submit'): void
}>()

const rules = ref<Rules>({})
const errorMessages = ref<ValidateErrorMap>({})

const { t } = useI18n()

const validator = computed(() => new Schema(toValue(rules)))

const validate = async () => {
  try {
    await validator.value.validate(props.form, { t })
    errorMessages.value = {}
    return true
  } catch (error: any) {
    const fields = error.fields
    Object.assign(errorMessages.value, fields)
    Object.keys(errorMessages.value).forEach((key) => {
      if (!fields[key]) {
        delete errorMessages.value[key]
      }
    })
    return false
  }
}

const validateByName = async (name: string) => {
  try {
    await validator.value.validate(props.form, { t, keys: [name] })
    delete errorMessages.value[name]
    return true
  } catch (error: any) {
    Object.assign(errorMessages.value, error.fields)
    console.log(errorMessages.value, error.fields)

    return false
  }
}

const onFormSubmit = async (ev: Event) => {
  ev.preventDefault()

  if (await validate()) {
    emits('submit')
  }
}

const onFormItemBlur = (ev: FocusEvent) => {
  const inputEl = ev?.target as HTMLInputElement

  if (!inputEl || inputEl.nodeName !== 'INPUT') {
    return
  }

  validateByName(inputEl.name)
}

provide<FormContext>(formContextKey, {
  rules,
  disabled: props.disabled,
  errorMessages,
  onFormItemBlur,
})

defineExpose({
  validate,
  validateByName,
})
</script>
