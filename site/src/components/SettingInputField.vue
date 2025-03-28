<template>
  <div v-if="readonly">
    <span>{{ valueNow }}</span>
  </div>
  <div v-else class="flex gap-2">
    <input v-model="valueNow" type="text" class="input grow" />
    <button
      class="btn-primary btn-md"
      :disabled="!isChanged"
      @click="onConfirm"
    >
      {{ $t('action.save') }}
    </button>
  </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue'
import { modifyUserInfo } from '@/services'
import { useMessage, useUserStore } from '@/stores'
import { useI18n } from 'vue-i18n'

defineOptions({
  name: 'SettingInputField',
})

interface SettingInputFieldProps {
  inputValue?: string
  maxLength?: number
  readonly?: boolean
  field?: string
}

const props = withDefaults(defineProps<SettingInputFieldProps>(), {
  inputValue: '',
  maxLength: 32,
  readonly: false,
  field: '',
})
const valueNow = ref<string>(props.inputValue)
const isChanged = ref<boolean>(false)
const user = useUserStore()
const ms = useMessage()
const { t } = useI18n()

const onConfirm = () => {
  if (valueNow.value.trim() === '' || valueNow.value === props.inputValue) {
    valueNow.value = props.inputValue
    isChanged.value = false
    return
  }
  modifyUserInfo(props.field, valueNow.value)
    .then(() => {
      ms.success(t('message.modify_profile_success'))
      user.fetch()
      isChanged.value = false
    })
    .catch(() => {
      ms.error(t('message.modify_profile_fail'))
    })
}

watch(
  () => valueNow.value,
  (v) => {
    isChanged.value = props.inputValue !== v
  },
)
</script>
