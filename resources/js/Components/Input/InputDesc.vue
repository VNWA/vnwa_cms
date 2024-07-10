<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
    class: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative">
        <div :class="{ 'text-red-500': modelValue.length >= 400 }" class="absolute right-0 -top-1 bg-white px-1 text-xs " >  {{
            modelValue.length }} /400</div>
        <textarea ref="input"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm  min-h-32"
            :class="class" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
    </textarea>
    </div>

</template>
