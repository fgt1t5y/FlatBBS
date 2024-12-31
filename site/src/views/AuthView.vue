<template>
  <MainContent disable-panels :title="$t('action.login')">
    <PageTitle :title="$t('action.login')" />
    <div class="p-3 my-0 mx-auto" style="max-width: 500px">
      <CommonForm
        :form="inputForm"
        :submit-label="$t('action.login')"
        :disabled="isDealing"
        @submit="actionLogin"
      >
        <FormInput
          v-model="inputForm.email"
          name="email"
          datatype="email"
          :label="$t('email')"
          required
        />
        <FormInput
          v-model="inputForm.password"
          name="password"
          type="password"
          :label="$t('password')"
          :min="8"
          required
        />
      </CommonForm>
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import { login } from '@/services'
import { useUserStore } from '@/stores'
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import router from '@/router'
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import CommonForm from '@/components/CommonForm.vue'
import FormInput from '@/components/form/FormInput.vue'

const isDealing = ref<boolean>(false)
const inputForm = ref({
  email: '',
  password: '',
})
const user = useUserStore()
const route = useRoute()

const actionLogin = () => {
  isDealing.value = true
  login(inputForm.value.email, inputForm.value.password)
    .then(async () => {
      await user.fetch()
      router.replace({ path: (route.query.next as string) || '/' })
    })
    .finally(() => {
      isDealing.value = false
    })
}
</script>
