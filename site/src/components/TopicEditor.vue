<template>
  <Editor :value="modelValue" @change="onValueChange" :locale="zh_Hans" />
</template>

<script setup lang="ts">
// @ts-expect-error
import { Editor } from "@bytemd/vue-next";
import zh_Hans from "bytemd/locales/zh_Hans.json";

defineOptions({
  name: "TopicEditor",
});
const emits = defineEmits<{
  (e: "update:modelValue", v: string): void;
}>();

interface TopicEditorProps {
  modelValue: string;
}

const props = withDefaults(defineProps<TopicEditorProps>(), {
  modelValue: "",
});

const onValueChange = (value: string) => {
  emits("update:modelValue", value);
};
</script>

<style></style>
