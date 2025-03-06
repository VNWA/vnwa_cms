<template>
    <div>
        <DefaultLayout :seo="seo">

            <div class="">
                <div class="container px-4 lg: lg:max-w-screen-xl mx-auto">

                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                            <li class="inline-flex items-center">
                                <Link :href="route('dashboard')"
                                    class="inline-flex cursor-pointer items-center text-sm font-medium text-gray-700   hover:text-black">
                                <icon :icon="['fas', 'house']" class="me-1" />
                                Home
                                </Link>

                            </li>
                            <li class="">
                                <Link :href="'/ve-chung-toi'"
                                    :class="{ 'text-purple-600  capitalize  hover:text-purple-600 font-semibold': 1 == 1 }"
                                    class="flex cursor-pointer items-center text-sm font-medium text-gray-700  hover:text-black">
                                <icon :icon="['fas', 'chevron-right']" class="me-2" />
                              Về Nguyễn Văn Thông
                                </Link>
                            </li>

                        </ol>
                    </nav>
                    <div class=" mt-5">
                        <div>
                            <div class="container   text-black/80">
                                <div class="bg-white shadow p-8">
                                    <EditorRenderHtml :content="about" />
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </DefaultLayout>
    </div>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { Link, usePage, router } from '@inertiajs/vue3';
import EditorRenderHtml from "@/Components/Client/EditorRenderHtml.vue";
defineProps({
    seo: {
        type: Object,
        default: {},
    },
    breadcrumbs: {
        type: Array,
        default: [],
    },
    about: {
        type: String,
        default: '',
    },
});

</script>
