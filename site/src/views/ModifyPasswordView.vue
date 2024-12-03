<template>
  <MainContent disable-panels>
    <PageTitle title="修改密码" />
    <div class="p-3 my-0 mx-auto" style="max-width: 500px">
      <FormKit
        v-model="modifyForm"
        type="form"
        submit-label="提交"
        action="false"
        @submit="actionSubmit"
      >
        <FormKit
          type="password"
          name="old_password"
          autocomplete="current-password"
          label="旧密码"
          validation="required|length:8"
        />
        <FormKit
          type="password"
          name="new_password"
          autocomplete="new-password"
          label="新密码"
          validation="required|length:8"
        />
        <FormKit
          type="password"
          name="new_password_confirm"
          autocomplete="new-password"
          label="确认新密码"
          validation="required|confirm"
        />
        <p class="text-red-600">修改密码将会退出所有设备上的登录。</p>
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
