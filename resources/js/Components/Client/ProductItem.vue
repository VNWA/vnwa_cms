<template>
    <div>
        <div class="relative group">
            <!-- Container for the product item -->
            <div class="border shadow-lg shadow-black/50 relative overflow-hidden rounded-lg">
                <!-- Product image section -->
                <div class="p-3 relative">
                    <div class="flex justify-center items-center">
                        <Link :href="route('Client.Product.Detail', item.slug)">
                        <img class="w-full h-auto max-w-xs lg:max-w-none lg:w-full lg:h-auto object-cover"
                            :src="item.images[0]" alt="Product Image" />
                        </Link>
                    </div>

                    <!-- Buttons for mobile -->
                    <div class="lg:hidden block mt-2">
                        <button
                            class="w-full bg-primary text-white py-2 px-4 rounded-lg hover:bg-subPrimary transition-all">
                            Nhận Báo Giá
                        </button>
                        <Link :href="route('Client.Product.Detail', item.slug)">
                        <button
                            class="w-full mt-2 bg-subPrimary text-white py-2 px-4 rounded-lg hover:bg-primary transition-all">
                            Xem Chi Tiết
                        </button>
                        </Link>
                    </div>

                    <!-- Product details -->
                    <div class="pt-2">
                        <Link :href="route('Client.Product.Detail', item.slug)">
                        <h2 class="font-bold text-lg lg:text-base uppercase text-center lg:text-left">
                            {{ item.name }}
                        </h2>
                        </Link>
                    </div>

                    <div class="uppercase pt-2 text-gray-500 text-sm lg:text-base font-bold text-center lg:text-left">
                        Mã SP: {{ item.sku }}
                    </div>
                </div>

                <!-- Overlay on hover for desktop -->
                <div
                    class="absolute inset-0 bg-white/80 opacity-0 transform -translate-y-full transition-transform duration-500 group-hover:translate-y-0 group-hover:opacity-100">
                </div>

                <div class="absolute inset-0 flex flex-col justify-center items-center">
                    <button @click="showForm = true"
                        class="mb-2 bg-primary text-white py-2 px-4 w-40 rounded-lg opacity-0 transform translate-y-full transition-all duration-500 delay-150 group-hover:translate-y-0 group-hover:opacity-100 hover:bg-subPrimary">
                        Nhận Báo Giá
                    </button>
                    <Link :href="route('Client.Product.Detail', item.slug)">
                    <button
                        class="py-2 px-4 border border-subPrimary text-subPrimary w-40 rounded-lg opacity-0 transform translate-y-full transition-all duration-500 delay-300 group-hover:translate-y-0 group-hover:opacity-100 hover:bg-subPrimary hover:text-white">
                        Xem Chi Tiết
                    </button>
                    </Link>
                </div>
            </div>
        </div>

        <!-- Modal form -->
        <div v-show="showForm" class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white p-6 w-full max-w-3xl relative rounded-lg">
                <h2 class="text-4xl text-center font-bold mb-6">BÁO GIÁ SẢN PHẨM</h2>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <label class="block text-xl font-light">Họ Tên</label>
                        <input type="text" v-model="formData.name"
                            class="w-full bg-gray-100 border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                        <InputError class="mt-2" :message="errors.name" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-xl font-light">Số điện thoại</label>
                        <input type="text" v-model="formData.phone"
                            class="w-full bg-gray-100 border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                        <InputError class="mt-2" :message="errors.phone" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-xl font-light">Email</label>
                        <input type="email" v-model="formData.email"
                            class="w-full bg-gray-100 border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary" />
                    </div>
                    <div class="mb-4">
                        <label class="block text-xl font-light">Tin nhắn</label>
                        <textarea v-model="formData.message"
                            class="w-full bg-gray-100 border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit"
                            class="bg-primary text-xl text-white py-3 px-6 rounded-lg hover:bg-subPrimary transition-all">Gửi</button>
                    </div>
                </form>
                <button @click="showForm = false" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900">
                    <icon class="text-4xl" :icon="['fas', 'xmark']" />
                </button>
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import InputError from '../InputError.vue';

const props = defineProps({
    item: {
        type: Object,
        default: () => ({})
    }
});

const showForm = ref(false);

const formData = ref({
    product_slug: props.item.slug,
    name: '',
    email: '',
    phone: '',
    message: ''
});
const errors = ref({
    name: '',
    phone: '',
})
const clearError = () => {
    errors.value = {
        name: '',
        phone: '',
    }
}
const isLoading = ref(false);
const submitForm = () => {
    clearError()
    isLoading.value = true;
    axios.post('/quote-product', formData.value).then(response => {
        toast.success(response.data.message);
        showForm.value = false;  // Ẩn form sau khi gửi

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
};

</script>

<style></style>
