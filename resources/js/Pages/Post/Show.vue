<template>
    <div>
        <AppLayout title="Post" :isLoading="isPageLoading">
            <template #header>
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Posts</h2>
                    </div>
                    <div>
                        <HeaderBreadcrumbs :breadcrumbs="[['Post', 'Blog.Post']]" />
                    </div>
                </div>
            </template>
            <div class="p-2 ">
                <div class="grid grid-cols-12 gap-4">
                    <div class="lg:col-span-12 col-span-12">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg pt-8 pb-12 px-2">
                            <div class="float-left">
                                <button v-if="itemsSelected.length > 0"
                                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs"
                                    @click="showisModalDeleteMutipleItem">
                                    <icon :icon="['fas', 'x']" class="mr-1" /> Xóa dữ liệu chọn
                                </button>
                            </div>
                            <div class="float-right text-xs uppercase">
                                <Link :href="route('Blog.Post.Create')"
                                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-2 rounded ">
                                <icon :icon="['fas', 'plus']" /> Thêm dữ liệu
                                </Link>
                            </div>

                            <div class="my-2 py-10">
                                <DataTable :headers="headers" :items="dataTable" buttons-pagination show-index
                                    v-model:items-selected="itemsSelected">



                                    <template #item-operation="item">
                                        <div class="flex items-center justify-center gap-5">
                                            <button class=" text-xl text-yellow-600" @click="showFormEdit(item)">
                                                <icon :icon="['fas', 'edit']" />
                                            </button>
                                            <button class=" text-xl text-red-500"
                                                @click="showisModalDeleteItem(item.id, item.name)">
                                                <icon :icon="['fas', 'trash']" />
                                            </button>
                                        </div>
                                    </template>

                                </DataTable>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


            <DialogModal :show="isModalDelete" @close="isModalDelete = false">
                <template #title>
                    Xóa dữ liệu
                </template>

                <template #content>
                    Chắc chắn xóa các dữ liệu này!
                    <div class="mt-4">
                    </div>
                    <div v-if="itemsDelete.length > 0">
                        <div class="flex items-center" v-for="item in itemsDelete">
                            <icon :icon="['fas', 'x']" class="text-red-600 mr-1" /> <span>{{ item.name }}</span>
                        </div>
                    </div>

                    <div class="mt-3 mb-1">
                        <div class="text-xs text-gray-600">Lưu ý :
                            <ul class="pl-4">
                                <li class=" font-bold list-disc" style="font-family: Arial, Helvetica, sans-serif;">Các
                                    dữ liệu được xóa sẽ tự động đưa vào thùng rác </li>
                                <li class=" font-bold list-disc" style="font-family: Arial, Helvetica, sans-serif;">Các
                                    dữ liệu trong thùng rác được tự động xóa sau 30 </li>
                                <li class=" font-bold list-disc" style="font-family: Arial, Helvetica, sans-serif;">Muốn
                                    xóa trực tiếp hãy bỏ chọn checkbox bên dưới</li>
                            </ul>
                        </div>

                    </div>
                </template>

                <template #footer>


                    <button class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs"
                        @click="deleteItems">
                        Xóa dữ liệu
                    </button>
                    <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-2 rounded mr-4 text-xs"
                        @click="isModalDelete = false">
                        Hủy lệnh
                    </button>
                </template>
            </DialogModal>

        </AppLayout>

    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import HeaderBreadcrumbs from '@/Components/HeaderBreadcrumbs.vue';
import { onMounted, ref } from 'vue';
import DialogModal from '@/Components/DialogModal.vue';
import { Link } from '@inertiajs/vue3';

const dataTable = ref([]);

const loadDataTable = () => {
    isPageLoading.value = true;
    axios.get('/vnwa/blog/posts/load-data-table').then(response => {
        dataTable.value = response.data
    }).catch(error => {
        console.error(error);
    });
    isPageLoading.value = false;
}
onMounted(() => {
    loadDataTable();
})


const isPageLoading = ref(false);
const itemsDelete = ref([])
const isModalDelete = ref(false)
const itemsSelected = ref([]);
const headers = [
    { text: "Name", value: "name" },
    { text: "Qnt Post", value: "qnt_post" },
    { text: "Action", value: "operation" },
];









const deleteItems = async () => {
    isPageLoading.value = true;
    try {
        const dataDelete = [];
        itemsDelete.value.forEach(element => {
            dataDelete.push(element.id)

        });
        axios.post('/vnwa/blog/tags/delete', { dataId: dataDelete }).then(response => {

            toast.success(response.data.message);
            isModalDelete.value = false;
            loadDataTable();

        }).catch(error => {
            toast.success(error.message);

        })
    } catch (error) {
        console.error('Error while changing status:', error);
    }
    isPageLoading.value = false;

};



const showisModalDeleteMutipleItem = () => {

    itemsDelete.value = [];
    itemsSelected.value.forEach(element => {
        // itemsDelete.value['id'] = element.id;
        // itemsDelete.value[id] = element.name;
        itemsDelete.value.push({ id: element.id, name: element.name })

    });
    console.log(itemsDelete.value)
    isModalDelete.value = true;

};
const showisModalDeleteItem = async (deleteId, deleteName) => {
    itemsDelete.value = [];
    itemsDelete.value.push({ id: deleteId, name: deleteName })
    isModalDelete.value = true;

};



</script>

<style></style>
