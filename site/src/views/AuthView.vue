<template>
  <MainContent disable-panels>
    <PageTitle title="登录" />
    <div class="p-3 my-0 mx-auto" style="max-width: 500px">
      <FormKit
        v-model="inputForm"
        type="form"
        submit-label="登录"
        :disabled="isDealing"
        @submit="actionLogin"
      >
        <FormKit
          type="email"
          name="email"
          label="电子邮箱"
          validation="required|length:5|*email"
        />
        <FormKit
          type="password"
          name="password"
          label="密码"
          validation="required|length:8"
        />
      </FormKit>
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import { login } from '@/services'
import { useUserStore } from '@/stores'
import { ref, reactive } from 'vue'
import { useRoute } from 'vue-router'
import router from '@/router'
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import { FormKit } from '@formkit/vue'

const isDealing = ref<boolean>(false)
const inputForm = reactive({
  email: '',
  password: '',
})
const user = useUserStore()
const route = useRoute()

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
