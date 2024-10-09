<template>
    <ul class="space-y-2 text-black/80">
        <li v-for="(category, key) in propsCategories" :key="category.id" class="list-disc">
            <div class="flex items-center justify-between mt-1">
                <Link :href="route('Client.ProductCategory', category.slug)">
                    <h3 class="uppercase font-bold hover:text-red-500" :class="{'text-red-500': page.url == '/products/' + category.slug}"> {{ category.name }}</h3>
                </Link>
                <button v-if="category.children && Object.keys(category.children).length > 0" @click="toggle(category.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                        :class="{ 'rotate-90': isOpen(category.id) }" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <!-- Hiển thị menu con nếu có -->
            <ul v-if="isOpen(category.id)" class="ml-4 space-y-1">
                <TreeMenu :categories="category.children" />
            </ul>
        </li>
    </ul>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

// Nhận `categories` từ props (là object)
const props = defineProps({
    categories: {
        type: Object,
        required: true
    }
})

const propsCategories = props.categories; // Gán lại biến để dễ sử dụng

const openMenus = ref([]);

// Lấy page.url từ usePage()
const page = usePage();

// Hàm toggle để mở và đóng các menu item
const toggle = (id) => {
    if (isOpen(id)) {
        openMenus.value = openMenus.value.filter(menuId => menuId !== id);
    } else {
        openMenus.value.push(id);
    }
}

// Hàm kiểm tra nếu menu đang mở
const isOpen = (id) => {
    return openMenus.value.includes(id);
}

// Hàm để kiểm tra và mở các menu dựa trên URL hiện tại
const checkAndOpenMenus = (categories) => {
    const findAndOpenCategory = (categories, parentCategories = []) => {
        Object.values(categories).forEach(category => {
            const categoryUrl = '/products/' + category.slug;

            if (page.url === categoryUrl) {

                parentCategories.forEach(parent => {
                    if (!openMenus.value.includes(parent.id)) {
                        openMenus.value.push(parent.id);
                    }
                });

                // Mở mục hiện tại
                openMenus.value.push(category.id);
            }

            // Đệ quy để kiểm tra mục con, và truyền danh sách các mục cha
            if (category.children && Object.keys(category.children).length > 0) {
                findAndOpenCategory(category.children, [...parentCategories, category]);
            }
        });
    };

    findAndOpenCategory(categories);
};

// Kiểm tra và mở menu khi trang load
onMounted(() => {
    checkAndOpenMenus(propsCategories);
});
</script>

<style scoped>
.rotate-90 {
    transform: rotate(90deg);
}
</style>
