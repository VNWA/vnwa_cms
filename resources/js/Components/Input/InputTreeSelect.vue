<template>
    <TreeSelect v-model="value" :options="transformedOptions" placeholder="Select Item"
                class="md:w-80 w-full capitalize" />
  </template>

  <script setup>
  import { watch, computed } from 'vue';
  import { defineProps, defineEmits, ref } from 'vue';
  import TreeSelect from 'primevue/treeselect';

  const props = defineProps({
    modelValue: Object, // Đảm bảo rằng đây là Object nếu bạn muốn giữ một giá trị đơn lẻ cho TreeSelect
    options: Array, // Đảm bảo options là một mảng các đối tượng
  });

  const value = ref(props.modelValue);
  const emit = defineEmits();

  // Tính toán transformedOptions từ props.options
  const transformedOptions = computed(() => {
    let options = [];

    // Thêm lựa chọn null nếu cần thiết
      options.push({ label: 'None', value: null, key: 'null' });

    if (props.options && props.options.length > 0) {
      options = options.concat(props.options.map(node => ({
        label: node.name, // Tên hiển thị trong dropdown
        value: node.id, // Giá trị được chọn
        key: node.id, // Khóa duy nhất của lựa chọn, có thể là id hoặc một trường khác tương tự
        children: node.children ? transformChildren(node.children) : null, // Nếu có children, tiến hành đệ quy biến đổi
      })));
    }

    return options;
  });

  // Hàm đệ quy để biến đổi các children
  function transformChildren(children) {
    return children.map(child => ({
      label: child.name,
      value: child.id,
      key: child.id,
      children: child.children ? transformChildren(child.children) : null,
    }));
  }

  // Watcher để theo dõi thay đổi của value và emit event
  watch(value, (newValue) => {
    emit('update:modelValue', newValue);
  });
  </script>

  <style></style>
