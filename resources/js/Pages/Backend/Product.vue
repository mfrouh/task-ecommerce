<template>
    <Head title="Products" />

    <AuthAdmin>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                                                Image
                                            </th>
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
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                                            >
                                                Price
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                                            >
                                                Quantity
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3 px-6 text-xs font-medium tracking-wider text-gray-700 uppercase dark:text-gray-400"
                                            >
                                                Category
                                            </th>
                                            <th
                                                scope="col"
                                                class="relative py-3 px-6"
                                            ></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="product in MYproducts"
                                            :key="product.id"
                                            class="border-b odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700 dark:border-gray-600"
                                        >
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                                style="
                                                    text-align: -webkit-center;
                                                "
                                            >
                                                <img
                                                    :src="product.image"
                                                    class="object-cover h-12 w-12 rounded-xl"
                                                />
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                {{ product.name }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm text-gray-500 whitespace-nowrap dark:text-gray-400"
                                            >
                                                <input
                                                    type="checkbox"
                                                    disabled
                                                    :checked="product.status"
                                                />
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                {{ product.price }} EGP
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                {{ product.quantity }}
                                            </td>
                                            <td
                                                class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            >
                                                {{ product.category.name }}
                                            </td>

                                            <td
                                                class="py-4 px-6 text-sm font-medium text-right whitespace-nowrap"
                                            >
                                                <div
                                                    class="flex justify-center space-x-2"
                                                >
                                                    <button>
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
                                                            deleteProduct(
                                                                product.id
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
        </div>
    </AuthAdmin>
</template>

<script>
import AuthAdmin from "@/Layouts/AuthAdmin.vue";
import { Head } from "@inertiajs/inertia-vue3";
import VueTailwindPagination from "@ocrv/vue-tailwind-pagination";

export default {
    name: "Pagination",
    components: {
        AuthAdmin,
        Head,
        VueTailwindPagination,
    },
    props: {
        products: Object,
    },
    data() {
        return {
            currentPage: this.products.meta.current_page,
            perPage: this.products.meta.per_page,
            total: this.products.meta.total,
            MYproducts: this.products.data,
        };
    },
    methods: {
        getData() {
            axios
                .get(this.route("backend.product.getData"), {
                    params: {
                        page: this.currentPage,
                    },
                })
                .then((response) => {
                    this.MYproducts = response.data.data;
                    this.perPage = response.data.meta.per_page;
                    this.total = response.data.meta.total;
                })
                .catch((e) => {});
        },
        changePage(numberPage) {
            this.currentPage = numberPage;
            this.getData();
        },
        deleteProduct(productId) {
            axios
                .delete(this.route("backend.product.destroy", productId))
                .then((response) => {
                    this.getData();
                    this.$toast.error(response.data.message);
                })
                .catch((e) => {});
        },
    },
};
</script>
