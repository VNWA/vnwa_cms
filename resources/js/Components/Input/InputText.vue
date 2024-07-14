<script setup>
import { onMounted, ref } from 'vue';

const props = defineProps({
    modelValue: String,
    class: String,
    id: String,
    type: String,
    maxLength: {
        type: Number,
        default: 400
    }
});

const emit = defineEmits(['update:modelValue', 'change']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

const handleChange = (event) => {
    emit('change', event.target.value);
};

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <div class="relative">
        <div :class="{ 'text-red-500': modelValue.length >= props.maxLength }"
            class="absolute right-0 -top-1 bg-white px-1 text-xs ">
            {{ modelValue.length }} / {{ props.maxLength }}
        </div>
        <input ref="input"
            :class="props.class, { 'border-red-500 focus:ring-red-500': modelValue.length >= props.maxLength }"
            :id="props.id" :type="props.type"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm pe-10 "
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            @change="handleChange">
        <div class="absolute top-2 right-5">
            <icon v-if="modelValue.length > 0 && modelValue.length >= props.maxLength"
                class="text-red-500 font-bold text-lg" :icon="['fas', 'x']" />
            <icon v-else-if="modelValue.length > 0 && modelValue.length < props.maxLength"
                class="text-green-500 font-bold text-lg" :icon="['fas', 'check']" />
        </div>
    </div>
</template>
