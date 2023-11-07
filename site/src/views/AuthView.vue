<template>
  <NForm></NForm>
</template>

<script setup lang="ts">
import { login, logout } from '@/services'
import { useUserStore } from '@/stores'
import { type FieldRule } from '@arco-design/web-vue'
import { NForm } from 'naive-ui'
import { ref, reactive } from 'vue'
import '@/style/AuthView.css'

const isLoginMode = ref<boolean>(true)
const isDealing = ref<boolean>(false)

const form = reactive({
  email: '',
  username: '',
  password: '',
  password_again: '',
})

const loginRule: Record<string, FieldRule> = {
  email: {
    required: true,
    type: 'email',
    message: '请填写有效的电子邮箱地址。',
    maxLength: 64,
  },
  password: {
    required: true,
    message: '请填写你的密码。',
    maxLength: 64,
    minLength: 8,
  },
}

const registerRule: Record<string, FieldRule> = {
  email: {
    required: true,
    type: 'email',
    message: '请填写有效的电子邮箱地址。',
    maxLength: 64,
  },
  username: {
    required: true,
    maxLength: 32,
    message: '请填写你的用户名。',
  },
  password: {
    required: true,
    message: '请填写你的密码。',
    maxLength: 64,
    minLength: 8,
  },
  password_again: {
    required: true,
    maxLength: 64,
    minLength: 8,
    validator: (v: string, cb) => {
      if (v !== form.password) {
        cb('确认密码必须与密码一致。')
        return
      }
    },
  },
}

const user = useUserStore()

const actionLogin = () => {
  isDealing.value = true
  login(form.email, form.password)
    .then((res) => {
      isDealing.value = false
      if (res.data.code === 0) {
        user.fetch()
      }
    })
    .finally(() => {
      isDealing.value = false
    })
}
</script>
