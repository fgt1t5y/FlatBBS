<template>
  <Space v-show="isEditing" direction="vertical">
    <Input ref="inputRef" v-model="valueNow" :max-length="maxLength" />
    <div class="input-field-opt">
      <Button type="primary" @click="onConfirm">保存</Button>
      <Button @click="onCancle">取消</Button>
    </div>
  </Space>
  <Space v-show="!isEditing">
    <TypographyText>{{ valueNow || '未填写' }}</TypographyText>
    <button
      v-if="!readonly"
      class="icon-link"
      title="更改此栏"
      @click="startEdit"
    >
      <IconEdit :size="18" />
    </button>
  </Space>
</template>

<script setup lang="ts">
import {
  Input,
  Button,
  Space,
  TypographyText,
  Message,
} from '@arco-design/web-vue'
import { ref, watch, nextTick } from 'vue'
import './InputField.css'
import { IconEdit } from '@arco-design/web-vue/es/icon'
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
const inputRef = ref<InstanceType<typeof Input>>()
const onConfirm = () => {
  if (valueNow.value.trim() === '' || valueNow.value === props.inputValue) {
    valueNow.value = props.inputValue
    isEditing.value = false
    return
  }
  modifyUserInfo(props.field, valueNow.value).then((res) => {
    if (res.data.code === 0) {
      Message.success('信息已更新。')
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
