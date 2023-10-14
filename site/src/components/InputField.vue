<template>
  <Space v-show="isEditing">
    <Input ref="inputRef" v-model="valueNow" :max-length="maxLength" />
    <div class="input-field-opt">
      <Button type="primary" @click="onConfirm">保存</Button>
      <Button @click="onCancle">取消</Button>
    </div>
  </Space>
  <Space v-show="!isEditing">
    <TypographyText>{{ valueNow }}</TypographyText>
    <button class="icon-link" title="更改此栏" @click="startEdit">
      <IconEdit :size="18" />
    </button>
  </Space>
</template>

<script setup lang="ts">
import { Input, Button, Space, TypographyText } from '@arco-design/web-vue'
import { ref, watch } from 'vue'
import './InputField.css'
import { IconEdit } from '@arco-design/web-vue/es/icon'

defineOptions({
  name: 'InputField',
})

interface InputFieldProps {
  inputValue: string
  maxLength?: number
}

const props = withDefaults(defineProps<InputFieldProps>(), {
  inputValue: '',
  maxLength: 32,
})
const valueNow = ref<string>(props.inputValue)
const isEditing = ref<boolean>(false)
const inputRef = ref<InstanceType<typeof Input>>()
const onConfirm = () => {
  if (valueNow.value.trim() === '' || valueNow.value === props.inputValue) {
    valueNow.value = props.inputValue
    isEditing.value = false
    return
  }
}
const onCancle = () => {
  valueNow.value = props.inputValue
  isEditing.value = false
}
const startEdit = () => {
  isEditing.value = true
  const timer = setTimeout(() => {
    inputRef.value!.inputRef!.focus()
    clearTimeout(timer)
  }, 0)
}

watch(
  () => props.inputValue,
  (v) => {
    valueNow.value = v
  },
)
</script>
