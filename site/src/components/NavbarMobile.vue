<template>
  <div class="mobile-navbar">
    <RouterLink class="text-lg route" to="/">{{ $t('page.home') }}</RouterLink>
    <RouterLink class="text-lg route" to="/boards">
      {{ $t('page.boards') }}
    </RouterLink>
    <RouterLink class="text-lg route" to="/search">
      {{ $t('page.search') }}
    </RouterLink>
    <RouterLink class="text-lg route" to="/people">
      {{ $t('page.me') }}
    </RouterLink>
  </div>
</template>

<script setup lang="ts">
defineOptions({
  name: 'MobileNavbar',
})
</script>
