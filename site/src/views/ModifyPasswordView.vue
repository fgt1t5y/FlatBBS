<template>
  <MainContent disable-panels :title="$t('page.modify_password')">
    <PageTitle :title="$t('page.modify_password')" />
    <div class="p-3 my-0 mx-auto" style="max-width: 500px">
      <FormKit
        v-model="modifyForm"
        type="form"
        action="false"
        :submit-label="$t('action.submit')"
        @submit="actionSubmit"
      >
        <FormKit
          type="password"
          name="old_password"
          autocomplete="current-password"
          validation="required|length:8"
          :label="$t('old_password')"
        />
        <FormKit
          type="password"
          name="new_password"
          autocomplete="new-password"
          validation="required|length:8"
          :label="$t('new_password')"
        />
        <FormKit
          type="password"
          name="new_password_confirm"
          autocomplete="new-password"
          validation="required|confirm"
          :label="$t('new_password_confirm')"
        />
        <p class="text-red-600">
          {{ $t('message.logout_all_session_if_modify_password') }}
        </p>
      </FormKit>
    </div>
  </MainContent>
</template>

<script setup lang="ts">
import MainContent from '@/components/MainContent.vue'
import PageTitle from '@/components/PageTitle.vue'
import { modifyPassword } from '@/services'
import { useMessage } from '@/stores'
import { clearToken } from '@/utils'
import { FormKit } from '@formkit/vue'
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const ms = useMessage()
const isDealing = ref<boolean>(false)
const modifyForm = ref({
  old_password: '',
  new_password: '',
  new_password_confirm: '',
})

const actionSubmit = () => {
  isDealing.value = true

  modifyPassword(modifyForm.value.old_password, modifyForm.value.new_password)
    .then(() => {
      clearToken()
      router.replace({ name: 'home_page' }).then(() => {
        location.reload()
      })
    })
    .catch((error: Error) => {
      ms.error(error.message)
    })
    .finally(() => {
      isDealing.value = false
    })
}
</script>
