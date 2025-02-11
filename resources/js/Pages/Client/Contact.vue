<template>
    <DefaultLayout :seo="seo" :isLoading="isLoading">
        <div style="background-color: #f9f9f9;">
            <div class="container px-4 lg:max-w-screen-xl mx-auto ">
                <div class="bg-white shadow lg:p-8 p-4 py-10  mb-10">
                    <div>

                        <Breadcrumb :breadcrumbs="breadcrumbs" />
                    </div>


                    <section class="mt-10">
                        <div id="map" class="relative h-[300px] overflow-hidden bg-cover bg-[50%] bg-no-repeat">

                            <div id="google_map" class="relative" v-if="layout.footer.footer_map">
                                <div v-html="layout.footer.footer_map">
                                </div>
                            </div>
                        </div>
                        <div class="container px-6 md:px-12">
                            <div
                                class="block rounded-lg bg-[hsla(0,0%,100%,0.8)] px-6 py-12 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)]  md:py-16 md:px-12 -mt-[100px] backdrop-blur-[30px] border border-gray-300">

                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900">
                                    Liên hệ với chuyên gia Nguyễn Văn Thông</h2>
                                <p class="mb-8 lg:mb-16 font-light text-center text-gray-500  sm:text-xl">
                                    Tôi cam kết đồng hành cùng bạn trong hành trình chinh phục ước mơ, giúp bạn khám phá
                                    bản thân, đưa ra những lựa chọn đúng đắn và chuẩn bị sẵn sàng để bước vào một tương
                                    lai thành công!</p>
                                <div class="mb-5">

                                    <div class="w-full shrink-0 grow-0 basis-auto ">
                                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 text-gray-900">
                                            <div class="flex items-center justify-start gap-4">
                                                <div class="inline-block rounded-md bg-sky-200 p-4 text-primary">
                                                    <icon :icon="['fas', 'envelope']" class="h-6 w-6" />
                                                </div>
                                                <div>
                                                    <p class="mb-1 font-bold ">
                                                        Email
                                                    </p>
                                                    <p class="text-sm text-neutral-500">
                                                        thongnguyen.duhoc@gmail.com
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-start gap-4">
                                                <div class="inline-block rounded-md bg-sky-200 p-4 text-primary">
                                                    <icon :icon="['fas', 'phone']" class="h-6 w-6" />
                                                </div>
                                                <div>
                                                    <p class="mb-1 font-bold ">
                                                        Hotline/Zalo
                                                    </p>
                                                    <p class="text-sm text-neutral-500">
                                                        0984.734.754
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex items-center justify-start gap-4">
                                                <div class="inline-block rounded-md bg-sky-200 p-4 text-primary">
                                                    <icon :icon="['fas', 'map']" class="h-6 w-6" />
                                                </div>
                                                <div>
                                                    <p class="mb-1 font-bold ">
                                                        Địa chỉ
                                                    </p>
                                                    <p class="text-sm text-neutral-500">
                                                        Số 28, Đường Hoàng Đức Trạch, Tổ dân phố 3, Thị trấn Phú Lộc,
                                                        Phú Lộc, Thừa Thiên Huế.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="h-full w-full flex items-center justify-center">
                                    <div>
                                        <h3 class="text-xl mb-5">Connect with us
                                        </h3>
                                        <ul class="grid grid-cols-4 gap-1">
                                            <li v-for="(item, index) in layout.profile.social" :key="index"
                                                class="col-span-1">
                                                <a target="_blank" :href="item.link">
                                                    <div
                                                        class="w-20 h-20 border border-white/50 flex items-center justify-center bg-sky-200 ">
                                                        <icon :icon="item.icon" v-if="item.icon.length > 0"
                                                            class="w-10 h-10 text-blue-500" />
                                                        <img :src="item.icon_image" v-else width="50" height="50"
                                                            alt="vinawebapp.com">
                                                    </div>
                                                </a>

                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

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
const page = usePage();
const layout = page.props.layout

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
