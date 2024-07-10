// src/store/admin.js
import { defineStore } from 'pinia';

export const useAdminStore = defineStore('admin', {
  state: () => ({
    isSidebarShow: false,
    isMediaDetailShow: true,
  }),
  actions: {
    toggleMediaDetail() {
        this.isMediaDetailShow = !this.isMediaDetailShow;
      },
    toggleSidebar() {
      this.isSidebarShow = !this.isSidebarShow;
    },
  },
  persist: true, // Sử dụng pinia-plugin-persistedstate để lưu trạng thái
});
