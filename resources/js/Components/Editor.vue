<template>
    <div class="w-full h-full mb-3">
        <div v-if="isModal"
            class="fixed w-full h-full top-0 left-0 bg-black/10 backdrop-blur-sm flex items-center justify-center z-50 p-10">
            <div class="min-w-52 min-h-52 max-h-full max-w-full w-full h-full">
                <div class="flex items-center justify-between px-3 pt-2 bg-white rounded-t-lg">
                    <h3 class="font-bold text-xl">Media Gallery</h3>
                    <button type="button" class="text-3xl font-bold me-5 hover:text-red-500" @click="isModal = false">
                        <icon :icon="['fas', 'x']" />
                    </button>
                </div>
                <MediaPopup @return-data="handleDataFromChild" />
            </div>
        </div>
        <div class="w-full h-full py-2 px-1 flex gap-4 items-center">
            <button @click="isModal = true"
                class="flex gap-4 items-center px-4 py-2 border border-black hover:bg-purple-500/90 hover:text-white uppercase font-bold">
                <icon :icon="['fas', 'image']" /> Insert Image
            </button>
            <!-- <button @click="insertUiBlock" class="flex gap-4 items-center px-4 py-2 border border-black hover:bg-purple-500/90 hover:text-white uppercase font-bold">
                <icon :icon="['fas', 'image']" /> UI Block
            </button> -->
        </div>
        <ckeditor v-model="editer_data" :config="editorConfig" :editor="Editor" @ready="onReady"></ckeditor>
    </div>
</template>
<script setup>
import { ref, watch, computed } from 'vue';
import Editor from 'ckeditor5-custom-build';
import MediaPopup from './MediaPopup.vue';

const isModal = ref(false);
const props = defineProps({
    modelValue: {
        type: String,
        default: ''
    },
});
const emit = defineEmits(['update:modelValue']);

// Use a computed property to watch changes to modelValue
const computedModelValue = computed(() => props.modelValue);
const editer_data = ref(props.modelValue);

watch(computedModelValue, (newData) => {
    editer_data.value = newData;
});

watch(editer_data, (newData) => {
    emit('update:modelValue', newData);
});

const editorConfig = {
    htmlEmbed: {
        showPreviews: true,
        allowedProviders: ['*'],
    },
    toolbar: {
        items: [
            'sourceEditing', 'codeBlock', 'code', '|',
            'heading', '|', 'style', 'textPartLanguage', 'fontSize', 'fontFamily', '|',
            'fontColor', 'fontBackgroundColor', '|', 'bold', 'italic', 'underline', 'strikethrough', '|',
            'alignment', '|', 'numberedList', 'bulletedList', '|', 'outdent', 'indent', '|',
            'todoList', 'link', 'blockQuote', 'imageUpload', 'insertTable', 'mediaEmbed', '|',
            'findAndReplace', 'highlight', 'horizontalLine', 'pageBreak', 'selectAll'
        ]
    },
    language: 'en',
    image: {
        toolbar: [
            'imageTextAlternative', 'toggleImageCaption', 'imageStyle:inline',
            'imageStyle:block', 'imageStyle:side', 'linkImage'
        ]
    },
    table: {
        contentToolbar: [
            'tableColumn', 'tableRow', 'mergeTableCells', 'tableCellProperties', 'tableProperties'
        ]
    }
};


const editorInstance = ref(null);

const onReady = (editor) => {
    editorInstance.value = editor;
    editor.ui.getEditableElement().parentElement.insertBefore(
        editor.ui.view.toolbar.element,
        editor.ui.getEditableElement()
    );
};

const handleDataFromChild = (data) => {
    if (data.length > 0) {
        if (editorInstance.value) {
            editorInstance.value.model.change(writer => {
                data.forEach(file => {
                    const imageElement = writer.createElement('imageBlock', {
                        src: file.path,
                        alt: 'vinawebapp.com'
                    });

                    const selection = editorInstance.value.model.document.selection;

                    if (selection.isCollapsed) {
                        editorInstance.value.model.insertContent(imageElement, selection);
                    } else {
                        const endPosition = editorInstance.value.model.createPositionAt(editorInstance.value.model.document.getRoot(), 'end');
                        writer.setSelection(endPosition);
                        editorInstance.value.model.insertContent(imageElement, endPosition);
                    }
                });
            });
        } else {
            console.log('Editor instance is not ready');
        }
        isModal.value = false;
    } else {
        console.warn("Received data is empty.");
    }
};

</script>


<style src="@/../css/editor.css"></style>
