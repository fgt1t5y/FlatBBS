<template>
  <div v-if="readonly">
    <span>{{ valueNow }}</span>
  </div>
  <div v-else class="flex gap-2">
    <FormKit ref="inputRef" v-model="valueNow" class="max-w-56" type="text" />
    <button
      class="btn btn-primary btn-md"
      :disabled="!isChanged"
      @click="onConfirm"
    >
      保存
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { modifyUserInfo } from '@/services'
import { FormKit } from '@formkit/vue'
import { useMessage } from '@/stores'

defineOptions({
  name: 'InputField',
})

interface InputFieldProps {
  inputValue?: string
  maxLength?: number
  readonly?: boolean
  field?: string
}

const props = withDefaults(defineProps<InputFieldProps>(), {
  inputValue: '',
  maxLength: 32,
  readonly: false,
  field: '',
})
const valueNow = ref<string>(props.inputValue)
const isChanged = ref<boolean>(false)
const inputRef = ref<any>()
const ms = useMessage()

const onConfirm = () => {
  if (valueNow.value.trim() === '' || valueNow.value === props.inputValue) {
    valueNow.value = props.inputValue
    isChanged.value = false
    return
  }
  modifyUserInfo(props.field, valueNow.value)
    .then(() => {
      ms.success('信息已更新。')
      isChanged.value = false
    })
    .catch(() => {
      ms.error('信息更新失败。')
    })
}

watch(
  () => valueNow.value,
  (v) => {
    isChanged.value = props.inputValue !== v
  },
)

watch(
  () => props.inputValue,
  (v) => {
    isChanged.value = valueNow.value === v
  },
)
</script>
