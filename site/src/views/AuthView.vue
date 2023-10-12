<template>
  <Card title="注册或登录" :bordered="false">
    <div style="display: flex; justify-content: center">
      <RadioGroup v-model="isLoginMode" type="button" size="large">
        <Radio :value="true">登录</Radio>
        <Radio :value="false">注册</Radio>
      </RadioGroup>
    </div>
    <div class="auth-form">
      <Form
        v-if="isLoginMode"
        :rules="loginRule"
        :model="form"
        layout="vertical"
        :disabled="isDealing"
        @submit-success="actionLogin"
      >
        <FormItem label="电子邮箱地址" field="email">
          <Input v-model="form.email" autofocus />
        </FormItem>
        <FormItem label="密码" field="password">
          <Input v-model="form.password" type="password" />
        </FormItem>
        <FormItem>
          <Button long :loading="isDealing" html-type="submit" type="primary">
            下一步
          </Button>
        </FormItem>
      </Form>
      <Form
        v-else
        :rules="registerRule"
        :model="form"
        layout="vertical"
        :disabled="isDealing"
      >
        <FormItem label="电子邮箱地址" field="email">
          <Input v-model="form.email" />
        </FormItem>
        <FormItem v-if="!isLoginMode" label="用户名" field="username">
          <Input v-model="form.username" />
        </FormItem>
        <FormItem label="密码" field="password">
          <Input v-model="form.password" type="password" />
        </FormItem>
        <FormItem v-if="!isLoginMode" label="确认密码" field="password_again">
          <Input v-model="form.password_again" type="password" />
        </FormItem>
        <FormItem>
          <Button long :loading="isDealing" html-type="submit" type="primary">
            下一步
          </Button>
        </FormItem>
      </Form>
    </div>
    <Button @click="actionLogout">Logout</Button>
  </Card>
</template>

<script setup lang="ts">
import { login, logout } from '@/services'
import { useUserStore } from '@/stores'
import {
  Card,
  Form,
  FormItem,
  Input,
  Button,
  Radio,
  RadioGroup,
  type FieldRule,
} from '@arco-design/web-vue'
import { ref, reactive } from 'vue'
import './AuthView.css'

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

const actionLogout = () => {
  logout()
}
</script>
