<template>
  <div ref="editor" class="editor"></div>
</template>

<script setup lang="ts">
import { Editor } from "bytemd";
import zh_Hans from "bytemd/locales/zh_Hans.json";
import { ref } from "vue";

defineOptions({
  name: "TopicEditor",
});

interface TopicEditorProps {
  modelValue: string;
}

const emits = defineEmits<{
  (e: "update:modelValue", v: string): void;
}>();
const props = withDefaults(defineProps<TopicEditorProps>(), {
  modelValue: "",
});
const onValueChange = (value: string) => {
  emits("update:modelValue", value);
};
</script>

<style></style>
