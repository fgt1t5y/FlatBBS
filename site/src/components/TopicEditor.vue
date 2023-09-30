<template>
  <Editor :value="modelValue" @change="onValueChange" />
</template>

<script setup lang="ts">
// @ts-expect-error
import { Editor } from "@bytemd/vue-next";

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
