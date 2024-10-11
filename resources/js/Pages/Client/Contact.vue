<template>
    <DefaultLayout :seo="seo" :isLoading="isLoading">
        <div style="background-color: #f9f9f9;">
            <div class="container px-4 lg:max-w-screen-xl mx-auto ">
                <div class="bg-white shadow lg:p-8 p-4 py-10  mb-10">
                    <div>

                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>
                    <div>
                        <section class="bg-white dark:bg-gray-900">
                            <div class="py-8 lg:py-16 px-4  mx-auto max-w-screen-md">
                                <h2
                                    class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                                    Contact Us</h2>
                                <p
                                    class="mb-8 lg:mb-16 font-light text-center text-gray-500 dark:text-gray-400 sm:text-xl">
                                    Got a technical issue? Want to send feedback about a beta feature? Need details
                                    about our Business plan? Let us know.</p>
                                <form @submit.prevent="submitForm" class="space-y-8">
                                    <div>
                                        <label for="name"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Họ Và Tên <span class="text-red-500">*</span> </label>
                                        <input type="text" id="name" v-model="form.name"
                                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                            required>
                                        <InputError class="mt-2" :message="errors.name" />

                                    </div>
                                    <div>
                                        <label for="phone"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Số
                                            Điện Thoại<span class="text-red-500">*</span> </label>
                                        <input type="text" id="phone" v-model="form.phone"
                                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                            required>
                                        <InputError class="mt-2" :message="errors.phone" />

                                    </div>
                                    <div>
                                        <label for="email"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            Email <span class="text-red-500">*</span> </label>
                                        <input type="email" id="email" v-model="form.email"
                                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                            required>
                                        <InputError class="mt-2" :message="errors.email" />

                                    </div>

                                    <div class="sm:col-span-2">
                                        <label for="message"
                                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">
                                            Tin Nhắn</label>
                                        <textarea id="message" rows="6" v-model="form.message"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Leave a comment..."></textarea>
                                    </div>
                                    <button type="submit"
                                        class="bg-primary py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-primary-700 sm:w-fit hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Send
                                        message</button>
                                </form>
                            </div>
                        </section>
                    </div>



                </div>

            </div>
        </div>
    </DefaultLayout>
</template>

<script setup>
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import { Link, usePage, router } from '@inertiajs/vue3';
import Breadcrumb from "@/Components/Client/Breadcrumb.vue";
import EditorRenderHtml from "@/Components/Client/EditorRenderHtml.vue";
import { ref } from "vue";
import InputError from "@/Components/InputError.vue";
defineProps({
    seo: {
        type: Object,
        default: {},
    },
    breadcrumbs: {
        type: Array,
        default: [],
    },

});
const form = ref({
    name: '',
    phone: '',
    email: '',
    message: ''
})
const errors = ref({
    name: '',
    phone: '',
    email: '',
})
const clearError = () => {
    errors.value = {
        name: '',
        phone: '',
        email: '',
    }
}
const isLoading = ref(false);
const submitForm = () => {
    isLoading.value = true;
    clearError()
    axios.post('/contact', form.value).then(response => {
        toast.success(response.data.message);
        form.value = {
            name: '',
            phone: '',
            email: '',
            message: ''
        }
    }).catch(error => {
        toast.error(error.message, {
            autoClose: 1500,
        });
        if (error.response.data.errors) {
            const errorKeys = Object.keys(error.response.data.errors);
            errorKeys.forEach(key => {
                if (key in errors.value) {
                    errors.value[key] = error.response.data.errors[key][0]; // Lấy giá trị lỗi đầu tiên (nếu có)
                }
            });
        }
    })
    isLoading.value = false;

}
</script>

<style></style>
