<template>
  <div class="auth-page">
    <SiteLogo />
    <div class="auth-page-header">
      <NButton circle quaternary @click="page.back()">
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
          登录
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
import SiteLogo from '@/components/SiteLogo.vue'
import { useRoute } from 'vue-router'
import router from '@/router'

const isDealing = ref<boolean>(false)
const inputForm = reactive({
  email: '',
  password: '',
})
const formRef = ref<FormInst>()
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
const route = useRoute()
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
      if (res.data.code === window.$code.OK) {
        user.fetch()
        router.replace({ path: (route.query.next as string) ?? '/' })
      }
    })
    .finally(() => {
      isDealing.value = false
    })
}
</script>
