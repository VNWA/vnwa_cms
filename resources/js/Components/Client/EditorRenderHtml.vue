<template>
    <div id="vnwa_editor_render" class="ck-content">
        <div v-html="props.content"></div>
    </div>
</template>

<script lang="ts" setup>
const props = defineProps({
    content: {
        type: String,
        default: ''
    }

})
</script>

