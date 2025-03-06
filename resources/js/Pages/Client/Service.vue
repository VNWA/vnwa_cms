<template>
    <div>
        <DefaultLayout :seo="seo">

            <div class="">
                <div class="container px-4 lg: lg:max-w-screen-xl mx-auto">
                    <Breadcrumb :breadcrumbs="breadcrumbs" />
                    <div class=" mt-5">
                        <div >
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
import Breadcrumb from "@/Components/Client/BreadCrumb.vue";
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

<style></style>
