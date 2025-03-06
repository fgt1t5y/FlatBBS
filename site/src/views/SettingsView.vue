<template>
  <MainContent disable-panels :title="$t('page.settings')">
    <PageTitle :title="$t('page.settings')" />
    <SettingGroup :title="$t('settings.user_profile')">
      <SettingItem :title="$t('settings.my_avatar')">
        <div class="flex justify-between">
          <Avatar class="size-16" :src="user.info?.avatar_uri" rounded />
          <RouterLink
            class="btn btn-primary btn-md"
            :to="{ name: 'modify_avatar' }"
          >
            {{ $t('action.modify') }}
          </RouterLink>
        </div>
      </SettingItem>
      <SettingItem :title="$t('settings.email_address')">
        <SettingInputField :input-value="user.info?.email" readonly />
      </SettingItem>
      <SettingItem :title="$t('settings.username')">
        <SettingInputField
          field="username"
          :input-value="user.info?.username"
          readonly
        />
      </SettingItem>
      <SettingItem :title="$t('settings.display_name')">
        <SettingInputField
          field="display_name"
          :input-value="user.info?.display_name"
        />
      </SettingItem>
      <SettingItem :title="$t('settings.introduction')">
        <SettingInputField
          field="introduction"
          :input-value="user.info?.introduction"
        />
      </SettingItem>
    </SettingGroup>
    <SettingGroup :title="$t('settings.security_and_privacy')">
      <SettingItem :title="$t('password')">
        <div>
          <RouterLink
            class="btn btn-primary btn-md"
            :to="{ name: 'modify_password' }"
          >
            {{ $t('action.modify') }}
          </RouterLink>
        </div>
      </SettingItem>
    </SettingGroup>
    <SettingGroup :title="$t('settings.display')">
      <SettingItem :title="$t('settings.language')">
        <select v-model="locale" class="input">
          <option v-for="local in availableLocales" :value="local">
            {{ local }}
          </option>
        </select>
      </SettingItem>
      <SettingItem :title="$t('settings.theme_mode')">
        <select v-model="themeSwitcherValue" class="input">
          <option value="auto">{{ $t('settings.follow_system') }}</option>
          <option value="light">{{ $t('settings.light') }}</option>
          <option value="dark">{{ $t('settings.dark') }}</option>
        </select>
      </SettingItem>
    </SettingGroup>
  </MainContent>
</template>

<script setup lang="ts">
import SettingInputField from '@/components/SettingInputField.vue'
import SettingItem from '@/components/SettingItem.vue'
import SettingGroup from '@/components/SettingGroup.vue'
import PageTitle from '@/components/PageTitle.vue'
import { useTheme, useUserStore } from '@/stores'
import { ref, watch } from 'vue'
import MainContent from '@/components/MainContent.vue'
import Avatar from '@/components/Avatar.vue'
import { useI18n } from 'vue-i18n'

const user = useUserStore()
const { locale, availableLocales } = useI18n()
const { switchTo, theme } = useTheme()

const themeSwitcherValue = ref(theme.value)

watch(() => themeSwitcherValue.value, switchTo)
</script>
