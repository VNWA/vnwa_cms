<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
    class: String,
    id: String,
    maxLength: {
        type: Number,
        default: 400
    }
});

const emit = defineEmits(['update:modelValue']);

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
        <div :class="{ 'text-red-500':   modelValue.length >= props.maxLength }"
            class="absolute right-0 -top-1 bg-white px-1 text-xs ">
            {{ modelValue.length }} / {{ props.maxLength }}
        </div>
        <textarea ref="input"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm min-h-32"
            :class="props.class" :id="props.id" :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)">
        </textarea>
    </div>
</template>
