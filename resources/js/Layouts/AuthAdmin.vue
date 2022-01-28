<template>
    <div
        :class="sidebarOpen ? 'block' : 'hidden'"
        @click="sidebarOpen = false"
        class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"
    ></div>

    <div class="flex bg-gray-100 font-roboto h-screen">
        <div
            class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-blue-700 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0"
            :class="[
                sidebarOpen
                    ? 'translate-x-0 ease-out'
                    : '-translate-x-full ease-in',
                sidebarOpen ? 'block' : 'hidden',
            ]"
        >
            <div class="flex items-center justify-left px-6 py-4">
                <div class="flex items-center">
                    <Link :href="route('home')">
                        <BreezeApplicationLogo class="block h-9 w-auto" />
                    </Link>
                    <Link
                        :href="route('home')"
                        class="px-3 text-white text-lg font-bold"
                    >
                        E-commerce</Link
                    >
                </div>
            </div>

            <nav class="sidebar mt-10">
                <Link
                    class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-opacity-25 hover:bg-gray-700"
                    :href="route('backend.dashboard')"
                    :class="isActive(route().current('backend.dashboard'))"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                        />
                    </svg>
                    <span class="mx-3">Dashboard</span>
                </Link>
                <Link
                    class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-opacity-25 hover:bg-gray-700"
                    :href="route('backend.category.index')"
                    :class="isActive(route().current('backend.category.index'))"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"
                        />
                    </svg>
                    <span class="mx-3">Categories</span>
                </Link>
                <Link
                    class="flex items-center mt-4 py-2 px-6 text-gray-100 hover:bg-opacity-25 hover:bg-gray-700"
                    :href="route('backend.product.index')"
                    :class="isActive(route().current('backend.product.index'))"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                        />
                    </svg>
                    <span class="mx-3">Products</span>
                </Link>
            </nav>
        </div>
        <div class="flex-1 flex flex-col overflow-scroll">
            <header
                class="flex justify-between items-center py-4 px-6 bg-white shadow-md"
            >
                <div class="flex items-center">
                    <button
                        v-on:click="sidebarOpen = !sidebarOpen"
                        class="text-gray-500 focus:outline-none"
                    >
                        <svg
                            class="h-6 w-6"
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M4 6H20M4 12H20M4 18H11"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </button>
                </div>

                <div class="flex items-center">
                    <div class="ml-3 relative" v-if="$page.props.auth.user">
                        <BreezeDropdown align="right" width="48">
                            <template #trigger>
                                <span class="inline-flex rounded-md">
                                    <button
                                        type="button"
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                    >
                                        {{ $page.props.auth.user.name }}

                                        <svg
                                            class="ml-2 -mr-0.5 h-4 w-4"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <BreezeDropdownLink
                                    :href="route('backend.dashboard')"
                                    as="button"
                                >
                                    Dashboard
                                </BreezeDropdownLink>
                                <BreezeDropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </BreezeDropdownLink>
                            </template>
                        </BreezeDropdown>
                    </div>
                </div>
            </header>
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
import BreezeDropdown from "@/Components/Dropdown.vue";
import BreezeDropdownLink from "@/Components/DropdownLink.vue";
import { Link } from "@inertiajs/inertia-vue3";
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue";

export default {
    components: {
        BreezeDropdownLink,
        BreezeDropdown,
        BreezeApplicationLogo,
        Link,
    },

    data() {
        return {
            sidebarOpen: true,
            showingNavigationDropdown: false,
        };
    },
    methods: {
        isActive(check) {
            return check ? "bg-gray-700 bg-opacity-25 text-gray-100" : "";
        },
    },
};
</script>
