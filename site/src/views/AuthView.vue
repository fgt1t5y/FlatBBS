<template>
  <MainContent disable-panels>
    <PageTitle title="登录" />
    <div class="auth-page">
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
          <NButton
            type="primary"
            round
            block
            size="large"
            @click="validateForm"
          >
            登录
          </NButton>
        </NFormItem>
      </NForm>
    </div>
  </MainContent>
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
  type FormInst,
} from 'naive-ui'
import { ref, reactive } from 'vue'
import { useRoute } from 'vue-router'
import router from '@/router'
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'

const isDealing = ref<boolean>(false)
const inputForm = reactive({
  email: '',
  password: '',
})
const formRef = ref<FormInst>()
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
      min: 8,
    },
  ],
}
const user = useUserStore()
const route = useRoute()
const validateForm = (ev: MouseEvent) => {
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
    .then(() => {
      user.fetch()
      router.replace({ path: (route.query.next as string) || '/' })
    })
    .catch((error: Error) => {
      window.$message.error(error.message)
    })
    .finally(() => {
      isDealing.value = false
    })
}
</script>
