<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    breadcrumbs: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <div>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <!-- Home Link -->
                <li class="inline-flex items-center">
                    <Link :href="route('dashboard')"
                        class="inline-flex cursor-pointer items-center text-sm font-medium text-gray-700 hover:text-black">
                    <icon :icon="['fas', 'house']" class="me-1" />

                    </Link>
                </li>
                <li v-for="(item, index) in breadcrumbs" :key="index" class="flex items-center">
                    <icon :icon="['fas', 'chevron-right']" class="me-2" />
                    <template v-if="index === breadcrumbs.length - 1">
                        <span class="text-subPrimary capitalize font-semibold">{{ item[0] }}</span>
                    </template>
                    <template v-else>
                        <Link :href="item[1]"
                            class="flex cursor-pointer items-center text-sm font-medium text-gray-700 hover:text-black capitalize">
                        {{ item[0] }}
                        </Link>
                    </template>
                </li>
            </ol>
        </nav>
    </div>
</template>
