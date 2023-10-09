<template>
  <section direction="vertical" fill>
    <TypographyText>{{ label }}</TypographyText>
    <Input
      style="max-width: 240px"
      :max-length="maxLength"
      v-model="valueNow"
      @focus="onFocus"
    />
    <div class="input-field-opt" v-if="showOptions">
      <Button @click="onConfirm" type="primary">保存</Button>
      <Button @click="onCancle">取消</Button>
    </div>
  </section>
</template>

<script setup lang="ts">
import { Input, Button, TypographyText, Space } from '@arco-design/web-vue'
import { ref, watch } from 'vue'

defineOptions({
  name: 'InputField',
})

interface InputFieldProps {
  label: string
  inputValue: string
  maxLength?: number
}

const props = withDefaults(defineProps<InputFieldProps>(), {
  label: '',
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
