<template>
  <Space direction="vertical" fill>
    <Input v-model="valueNow" :max-length="maxLength" @focus="onFocus" />
    <div v-if="showOptions" class="input-field-opt">
      <Button type="primary" @click="onConfirm">保存</Button>
      <Button @click="onCancle">取消</Button>
    </div>
  </Space>
</template>

<script setup lang="ts">
import { Input, Button, Space } from '@arco-design/web-vue'
import { ref, watch } from 'vue'
import './InputField.css'

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
const showOptions = ref<boolean>(false)
const onConfirm = () => {
  if (valueNow.value.trim() === '' || valueNow.value === props.inputValue) {
    valueNow.value = props.inputValue
    showOptions.value = false
    return
  }
}
const onCancle = () => {
  valueNow.value = props.inputValue
  showOptions.value = false
}
const onFocus = () => {
  showOptions.value = true
}

watch(
  () => props.inputValue,
  (v) => {
    valueNow.value = v
  },
)
</script>
