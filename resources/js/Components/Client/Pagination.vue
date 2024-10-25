<template>
    <div>
        <div class="pagination">
            <div v-for="(link, index) in links" :key="index" class="page-item" @click="link.url && goToPage(link.url)" :class="{ 'active': link.active }">
                <a class="page-link" v-if="link.url">
                    <span > <div v-html="link.label"></div></span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        links: Array,
    },
    methods: {
        goToPage(url) {
            this.$inertia.visit(url); // Sử dụng Inertia để điều hướng đến trang mới
        },
    },
}
</script>

<style>
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 20px 0;
    flex-wrap: wrap; /* Cho phép các phần tử quấn lại */
}

.page-item {
    margin: 5px; /* Giảm khoảng cách cho kích thước nhỏ hơn */
    cursor: pointer; /* Thêm con trỏ chuột khi hover */
}

.page-link {
    display: flex;
    align-items: center;
    padding: 10px 15px;
    background-color: #c5c5c5; /* Màu nền */
    color: white; /* Màu chữ */
    border-radius: 5px; /* Bo góc */
    text-decoration: none;
    transition: background-color 0.3s;
    font-size: 1rem; /* Kích thước chữ mặc định */
}

.page-link:hover {
    background-color: #2f78ad; /* Màu khi hover */
}

.active .page-link {
    background-color: #2f78ad; /* Màu cho trang hiện tại */
    font-weight: bold;
}

/* Responsive Styles */
@media (max-width: 600px) {
    .page-link {
        padding: 8px 12px; /* Điều chỉnh padding cho màn hình nhỏ */
        font-size: 0.9rem; /* Giảm kích thước chữ */
    }

    .page-item {
        margin: 3px; /* Giảm khoảng cách cho kích thước nhỏ hơn */
    }
}


</style>
