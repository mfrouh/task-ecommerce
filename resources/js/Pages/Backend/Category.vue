<template>
    <Head title="Categories" />
    <AuthAdmin>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <button
                    @click="createCategory = true"
                    class="bg-transparent bg-blue-500 text-gray-100 font-bold py-2 px-4 rounded-md"
                >
                    Create
                </button>
                <div class="flex flex-col">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div
                            class="inline-block py-2 min-w-full sm:px-6 lg:px-8"
                        >
                            <div
                                class="overflow-hidden shadow-md sm:rounded-lg"
                            >
                                <table class="min-w-full text-center">
                                    <thead class="bg-gray-100 dark:bg-gray-700">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                                            >
                                                Name
                                            </th>

                                            <th
                                                scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                                            >
                                                Status
                                            </th>
                                            <th
                                                scope="col"
                                                class="relative py-3 px-6"
                                            ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="category in MYcategories"
                                            :key="category.id"
                                            class="border-b odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700 dark:border-gray-600"
                                        >
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                {{ category.name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400"
                                            >
                                                <input
                                                    type="checkbox"
                                                    disabled
                                                    :checked="category.status"
                                                />
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-center whitespace-nowrap"
                                            >
                                                <div
                                                    class="flex justify-center space-x-2"
                                                >
                                                    <button
                                                        v-on:click="
                                                            edit(category)
                                                        "
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-6 w-6 text-indigo-600 cursor-pointer"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                                            ></path>
                                                        </svg>
                                                    </button>
                                                    <button
                                                        v-on:click="
                                                            deleteCategory(
                                                                category.id
                                                            )
                                                        "
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            class="h-6 w-6 text-red-500 cursor-pointer"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor"
                                                        >
                                                            <path
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                            ></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <VueTailwindPagination
                                    :current="currentPage"
                                    :total="total"
                                    :per-page="perPage"
                                    @page-changed="changePage($event)"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <CreateCategory
                :show="createCategory"
                @close="createCategory = false"
                @ok="getData"
            />
            <EditCategory
                v-if="editCategory"
                :category="category"
                :show="editCategory"
                @close="editCategory = false"
                @ok="getData"
            />
        </div>
    </AuthAdmin>
</template>

<script>
import AuthAdmin from "@/Layouts/AuthAdmin.vue";
import CreateCategory from "@/Pages/Modals/CreateCategory.vue";
import EditCategory from "@/Pages/Modals/EditCategory.vue";
import { Head } from "@inertiajs/inertia-vue3";
import VueTailwindPagination from "@ocrv/vue-tailwind-pagination";

export default {
    components: {
        AuthAdmin,
        EditCategory,
        CreateCategory,
        Head,
        VueTailwindPagination,
    },
    props: {
        categories: Object,
    },
    data() {
        return {
            currentPage: this.categories.meta.current_page,
            perPage: this.categories.meta.per_page,
            total: this.categories.meta.total,
            MYcategories: this.categories.data,
            showModal: false,
            createCategory: false,
            editCategory: false,
            category: null,
        };
    },
    methods: {
        getData() {
            axios
                .get(this.route("backend.category.getData"), {
                    params: {
                        page: this.currentPage,
                    },
                })
                .then((response) => {
                    this.MYcategories = response.data.data;
                    this.perPage = response.data.meta.per_page;
                    this.total = response.data.meta.total;
                })
                .catch((e) => {});
        },
        changePage(numberPage) {
            this.currentPage = numberPage;
            this.getData();
        },
        deleteCategory(categoryId) {
            axios
                .delete(this.route("backend.category.destroy", categoryId))
                .then((response) => {
                    this.getData();
                    this.$toast.error(response.data.message);
                })
                .catch((e) => {});
        },
        edit(category) {
            this.editCategory = true;
            this.category = category;
        },
    },
};
</script>
