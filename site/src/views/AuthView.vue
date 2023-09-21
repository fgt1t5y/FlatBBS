<template>
  <Card title="注册或登录" :bordered="false">
    <div style="display: flex; justify-content: center">
      <RadioGroup type="button" v-model="isLoginMode" size="large">
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
      >
        <FormItem label="电子邮箱地址" field="email">
          <Input v-model="form.email" />
        </FormItem>
        <FormItem label="密码" field="password">
          <Input type="password" v-model="form.password" />
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
          <Input type="password" v-model="form.password" />
        </FormItem>
        <FormItem v-if="!isLoginMode" label="确认密码" field="password_again">
          <Input type="password" v-model="form.password_again" />
        </FormItem>
        <FormItem>
          <Button long :loading="isDealing" html-type="submit" type="primary">
            下一步
          </Button>
        </FormItem>
      </Form>
    </div>
  </Card>
</template>

<script setup lang="ts">
import {
  Card,
  Form,
  FormItem,
  Input,
  Button,
  Radio,
  RadioGroup,
  type FieldRule,
} from "@arco-design/web-vue";
import { ref } from "vue";
import { reactive } from "vue";

const isLoginMode = ref<boolean>(true);
const isDealing = ref<boolean>(false);

const form = reactive({
  email: "",
  username: "",
  password: "",
  password_again: "",
});

const loginRule: Record<string, FieldRule> = {
  email: {
    required: true,
    type: "email",
    message: "请填写有效的电子邮箱地址。",
    maxLength: 64,
  },
  password: {
    required: true,
    message: "请填写你的密码。",
    maxLength: 64,
    minLength: 8,
  },
};

const registerRule: Record<string, FieldRule> = {
  email: {
    required: true,
    type: "email",
    message: "请填写有效的电子邮箱地址。",
    maxLength: 64,
  },
  username: {
    required: true,
    maxLength: 32,
    message: "请填写你的用户名。",
  },
  password: {
    required: true,
    message: "请填写你的密码。",
    maxLength: 64,
    minLength: 8,
  },
  password_again: {
    required: true,
    message: "请再次填写你的密码。",
    maxLength: 64,
    minLength: 8,
    validator: (v: string, cb) => {
      if (v !== form.password) {
        cb("确认密码必须与密码一致。");
        return;
      }
    },
  },
};
</script>

<style>
.auth-form {
  max-width: 450px;
  margin: 0px auto;
}
</style>
