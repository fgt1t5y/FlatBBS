<template>
  <div ref="wrapper" class="editor"></div>
</template>

<script setup lang="ts">
import { Editor, type EditorProps } from "bytemd";
import zh_Hans from "bytemd/locales/zh_Hans.json";
import { ref, onMounted, watch } from "vue";

defineOptions({
  name: "TopicEditor",
});

const wrapper = ref<HTMLElement>();
const editor = ref<Editor | undefined>(undefined);
const emits = defineEmits<{
  (e: "update:value", v: string): void;
}>();
const props = withDefaults(defineProps<EditorProps>(), {
  value: "",
  sanitize: undefined,
  plugins: () => [],
  mode: "split",
  locale: () => zh_Hans,
  placeholder: "输入话题内容...",
  editorConfig: () => {
    return {
      autofocus: true,
    };
  },
});

onMounted(() => {
  // @ts-expect-error
  editor.value = new Editor({
    target: wrapper.value,
    props,
  });

  // @ts-expect-error
  editor.value.$on("change", (ev: CustomEvent<{ value: string }>) => {
    emits("update:value", ev.detail.value);
  });
});

watch(
  () => props,
  (newValue) => {
    // @ts-expect-error
    editor.value?.$set(newValue);
  },
  { deep: true }
);

defineExpose([wrapper.value]);
</script>

<style></style>
