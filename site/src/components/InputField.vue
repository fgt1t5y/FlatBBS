<template>
  <NSpace v-if="!isEditing" align="center" justify="space-between">
    <NText>{{ valueNow || '未填写' }}</NText>
    <NButton
      v-if="!readonly"
      secondary
      circle
      title="更改此栏"
      @click="startEdit"
    >
      <Edit1Icon />
    </NButton>
  </NSpace>
  <NSpace v-else vertical>
    <NInput
      ref="inputRef"
      v-model:value="valueNow"
      :maxlength="maxLength"
      show-count
    />
    <div class="input-field-opt">
      <NButton type="primary" @click="onConfirm">保存</NButton>
      <NButton @click="onCancle">取消</NButton>
    </div>
  </NSpace>
</template>

<script setup lang="ts">
import { NInput, NSpace, NButton, NText } from 'naive-ui'
import { Edit1Icon } from 'tdesign-icons-vue-next'
import { ref, watch, nextTick } from 'vue'
import '@/style/InputField.css'
import { modifyUserInfo } from '@/services'

defineOptions({
  name: 'InputField',
})

interface InputFieldProps {
  inputValue: string
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
const isEditing = ref<boolean>(false)
const inputRef = ref<InstanceType<typeof NInput>>()
const onConfirm = () => {
  if (valueNow.value.trim() === '' || valueNow.value === props.inputValue) {
    valueNow.value = props.inputValue
    isEditing.value = false
    return
  }
  modifyUserInfo(props.field, valueNow.value)
    .then(() => {
      window.$message.success('信息已更新。')
    })
    .catch(() => {
      window.$message.error('信息更新失败。')
    })
    .finally(() => {
      isEditing.value = false
    })
}
const onCancle = () => {
  valueNow.value = props.inputValue
  isEditing.value = false
}
const startEdit = () => {
  isEditing.value = true

  nextTick(() => {
    inputRef.value!.focus()
  })
}

watch(
  () => props.inputValue,
  (v) => {
    valueNow.value = v
  },
)
</script>
