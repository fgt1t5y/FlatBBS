<template>
  <MainContent disable-panels :title="$t('login')">
    <PageTitle :title="$t('login')" />
    <div class="p-3 my-0 mx-auto" style="max-width: 500px">
      <FormKit
        v-model="inputForm"
        type="form"
        :submit-label="$t('login')"
        :disabled="isDealing"
        @submit="actionLogin"
      >
        <FormKit
          type="email"
          name="email"
          :label="$t('email')"
          validation="required|length:5|*email"
        />
        <FormKit
          type="password"
          name="password"
          :label="$t('password')"
          validation="required|length:8"
        />
      </FormKit>
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import { login } from '@/services'
import { useMessage, useUserStore } from '@/stores'
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import router from '@/router'
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import { FormKit } from '@formkit/vue'

const isDealing = ref<boolean>(false)
const inputForm = ref({
  email: '',
  password: '',
})
const user = useUserStore()
const route = useRoute()
const ms = useMessage()

const actionLogin = () => {
  isDealing.value = true
  login(inputForm.value.email, inputForm.value.password)
    .then(() => {
      user.fetch()
      router.replace({ path: (route.query.next as string) || '/' })
    })
    .catch((error: Error) => {
      ms.error(error.message)
    })
    .finally(() => {
      isDealing.value = false
    })
}
</script>
