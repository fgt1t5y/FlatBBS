<template>
  <NSpace v-if="!isEditing" align="center">
    <NText>{{ valueNow || '未填写' }}</NText>
    <NButton secondary circle title="更改此栏" @click="startEdit">
      <NIcon :size="18">
        <EditRound />
      </NIcon>
    </NButton>
  </NSpace>
  <NSpace v-else vertical>
    <NInput ref="inputRef" v-model:value="valueNow" :maxlength="maxLength" />
    <div class="input-field-opt">
      <NButton type="primary" @click="onConfirm">保存</NButton>
      <NButton @click="onCancle">取消</NButton>
    </div>
  </NSpace>
</template>

<script setup lang="ts">
import { NInput, NSpace, NButton, NText, useMessage, NIcon } from 'naive-ui'
import { EditRound } from '@vicons/material'
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
const message = useMessage()
const valueNow = ref<string>(props.inputValue)
const isEditing = ref<boolean>(false)
const inputRef = ref<InstanceType<typeof NInput>>()
const onConfirm = () => {
  if (valueNow.value.trim() === '' || valueNow.value === props.inputValue) {
    valueNow.value = props.inputValue
    isEditing.value = false
    return
  }
  modifyUserInfo(props.field, valueNow.value).then((res) => {
    if (res.data.code === 0) {
      message.success('信息已更新。')
      isEditing.value = false
    }
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
