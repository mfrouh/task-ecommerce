<template>
    <div
        :class="sidebarOpen ? 'block' : 'hidden'"
        @click="sidebarOpen = false"
        class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"
    ></div>

    <div
        :class="
            sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'
        "
        class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0"
    >
        <div class="flex items-center justify-left px-6 py-4">
            <div class="flex items-center">
                <span class="text-white text-2xl mx-2 font-semibold">
                    E-commerce
                </span>
            </div>
        </div>

        <nav class="sidebar mt-10">
            <Link
                class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                :href="route('backend.dashboard')"
                :active="route().current('backend.dashboard')"
                :class="isActive"
            >
                <span class="mx-3">Dashboard</span>
            </Link>
            <Link
                class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                :href="route('backend.category.index')"
                :active="route().current('backend.category.index')"
                :class="isActive"
            >
                <span class="mx-3">Categories</span>
            </Link>
            <Link
                class="flex items-center mt-4 py-2 px-6 text-gray-500 hover:bg-gray-700 hover:bg-opacity-25 hover:text-gray-100"
                :href="route('backend.product.index')"
                :active="route().current('backend.product.index')"
                :class="isActive"
            >
                <span class="mx-3">Products</span>
            </Link>
        </nav>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },

    data() {
        return {
            showingNavigationDropdown: false,
        };
    },
    methods: {
        isActive() {
            return "bg-gray-700 bg-opacity-25 text-gray-100";
        },
    },
};
</script>
