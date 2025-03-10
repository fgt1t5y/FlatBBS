import { acceptHMRUpdate, defineStore } from 'pinia';

export const useLocalSettings = defineStore('localSettings', {
  state: () => ({
    language: window.navigator.language,
    timezone: 'Etc/UTC',
  }),
  actions: {
    init() {
      const local = localStorage.getItem('LocalSettings');

      if (!local) {
        this.save();
        return;
      }

      try {
        const parsed = JSON.parse(local);
        this.$patch(parsed);
      } catch (e) {
        throw new Error('Failed to parse config json.');
      }
    },
    save() {
      localStorage.setItem('LocalSettings', JSON.stringify(this.$state));
    },
  },
});

if (import.meta.hot) {
  import.meta.hot.accept(acceptHMRUpdate(useLocalSettings, import.meta.hot));
}
