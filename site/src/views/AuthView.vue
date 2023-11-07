<template>
  <div class="auth-page">
    <div class="auth-page-header">
      <NButton circle secondary @click="page.back">
        <ArrowLeftIcon size="18px" />
      </NButton>
      <NH3>
        <NText type="primary">登录</NText>
      </NH3>
    </div>
    <NForm
      ref="formRef"
      :model="inputForm"
      :rules="loginRule"
      :disabled="isDealing"
    >
      <NFormItem path="email" label="电子邮箱地址">
        <NInput v-model:value="inputForm.email" />
      </NFormItem>
      <NFormItem path="password" label="密码">
        <NInput v-model:value="inputForm.password" type="password" />
      </NFormItem>
      <NFormItem>
        <NButton attr-type="button" type="primary" block @click="validateForf">
          提交
        </NButton>
      </NFormItem>
    </NForm>
  </div>
</template>

<script setup lang="ts">
import { login } from '@/services'
import { useUserStore } from '@/stores'
import {
  NForm,
  NFormItem,
  NInput,
  type FormRules,
  NButton,
  NH3,
  NText,
  type FormInst,
} from 'naive-ui'
import { ref, reactive } from 'vue'
import '@/style/AuthView.css'
import { ArrowLeftIcon } from 'tdesign-icons-vue-next'
import { usePage } from '@/utils/usePage'

const isDealing = ref<boolean>(false)
const inputForm = reactive({
  email: '',
  password: '',
})
const formRef = ref<FormInst | null>(null)
const page = usePage()
const loginRule: FormRules = {
  email: [
    {
      required: true,
      type: 'email',
      message: '请输入正确的电子邮箱地址',
      trigger: ['blur'],
    },
  ],
  password: [
    {
      required: true,
      message: '请输入密码',
      trigger: ['blur'],
    },
  ],
}
const user = useUserStore()
const validateForf = (ev: MouseEvent) => {
  ev.preventDefault()
  formRef.value!.validate((errors) => {
    if (!errors) {
      actionLogin()
    }
  })
}
const actionLogin = () => {
  isDealing.value = true
  login(inputForm.email, inputForm.password)
    .then((res) => {
      isDealing.value = false
      if (res.data.code === 0) {
        user.fetch()
        page.goHome(true)
      }
    })
    .finally(() => {
      isDealing.value = false
    })
}
</script>
