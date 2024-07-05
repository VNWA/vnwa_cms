<template>
    <div>
        <AppLayout title="Categories Blog" :isLoading="isLoading">
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Categories Blog
                </h2>
            </template>

            <div class="p-5">
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-4">
                        <div class="bg-white">
                            <Draggable class="mtl-tree" v-model="list" treeLine >
                                <template #default="{ node, stat }" >

                                    <div class=" mx-3 flex cursor-pointer items-center gap-4 " :class="{'font-bold':id_active ===node.id }" @click="changeIdActive(node.id)">{{ node.text }} (1)
                                         <button v-if="id_active ===node.id" class="bg-red-500 hover:bg-red-600 px-2 py-1 text-white rounded-md"><icon :icon="['fas', 'trash']" /> </button>
                                        </div>
                                    <OpenIcon v-if="stat.children.length" :open="stat.open" class="float-end" @click.native="stat.open = !stat.open" />

                                </template>
                            </Draggable>
                        </div>
                    </div>
                </div>

            </div>

        </AppLayout>
    </div>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref } from 'vue';

import { BaseTree, Draggable, pro, OpenIcon } from '@he-tree/vue'
import '@he-tree/vue/style/default.css'

const isLoading = ref(false)
const list = ref([
    {
        id: 1,
        text: 'Projects',
        children: [
            {
                 id: 2,
                   text: 'Frontend',
                children: [
                    {
        id: 3,
        text: 'Vue',
                        children: [
                            {
        id: 4,
        text: 'Nuxt',
                            },
                        ],
                    },
                    {
        id: 5,
        text: 'React',
                        children: [
                            {
        id: 6,
        text: 'Next',
                            },
                        ],
                    },
                    {
        id: 7,
                        text: 'Angular',
                    },
                ],
            },
            {
        id: 8,
                text: 'Backend',
            },
        ],
    },
    {id: 9, text: 'Photos' },
    {id: 10, text: 'Videos' },
]);
const id_active = ref(null);

const changeIdActive = (id) =>{
    id_active.value = id;
    console.log(id)
};

</script>

<style>
.tree-node--with-tree-line {
    position: relative
}

.tree-line {
    position: absolute;
    background-color: #bbb
}

.tree-vline {
    width: 1px;
    top: 0;
    bottom: 0
}

.tree-hline {
    height: 1px;
    top: 50%;
    width: 10px
}

.he-tree--rtl {
    direction: rtl
}

.he-tree-drag-placeholder {
    background: #ddf2f9;
    border: 1px dashed #00d9ff;
    height: 22px;
    width: 100%
}

.he-tree__open-icon {
    cursor: pointer;
    user-select: none;
    display: inline-block
}

.he-tree__open-icon.open {
    transform: rotate(90deg)
}

.he-tree__open-icon svg {
    width: 1em
}
.tree-node-inner{
    cursor: grab;
    background: #dedede;
    border: 1px solid #19293c;
    border-radius: 3px;
    box-sizing: border-box;
    color: inherit;
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 4;
    font-weight: 400;
    height: 40px;
    margin: 5px 0;
    padding: 5px 10px 5px 20px;
    text-decoration: none;
}

</style>
