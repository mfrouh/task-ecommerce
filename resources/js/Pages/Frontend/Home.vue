<template>
    <Head title="Home" />

    <BreezeAuthenticatedLayout>
        <div class="py-6">
            <div class="max-w-9xl flex mx-auto sm:px-6 lg:px-8">
                <div
                    class="w-72 flex-shrink-0 overflow-hidden shadow-sm sm:rounded-lg"
                    style="position: sticky; top: 50px"
                >
                    <div class="p-3">
                        <div class="block border-b border-gray-300 pb-7 mb-7">
                            <div
                                class="flex items-center justify-between mb-2.5"
                            >
                                <h2
                                    class="font-semibold text-heading text-xl md:text-2xl"
                                >
                                    Filters
                                </h2>
                            </div>
                            <div class="flex flex-wrap -m-1.5 pt-2"></div>
                        </div>
                        <h3
                            class="text-heading text-sm md:text-base font-semibold mb-7"
                        >
                            Category
                        </h3>
                        <div class="mt-2 mb-4 flex flex-col space-y-4">
                            <label
                                v-for="category in MYcategories"
                                :key="category.id"
                                class="group flex items-center text-heading text-sm cursor-pointer"
                                ><input
                                    type="checkbox"
                                    class="form-checkbox w-5 h-5 border border-gray-300 rounded cursor-pointer transition duration-500 ease-in-out focus:ring-offset-0 hover:border-heading focus:outline-none focus:ring-0 focus-visible:outline-none checked:bg-heading checked:hover:bg-heading checked:focus:bg-heading"
                                    v-model="filCategories"
                                    :value="category.id"
                                />
                                <span class="ms-4 -mt-0.5"> </span>
                                {{ category.name }}
                            </label>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-1">
                                <h3
                                    class="text-heading text-sm md:text-base font-semibold"
                                >
                                    Min Price
                                </h3>
                                <input
                                    type="number"
                                    v-model="min_price"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                                    min="0"
                                />
                            </div>
                            <div class="col-span-1">
                                <h3
                                    class="text-heading text-sm md:text-base font-semibold"
                                >
                                    Max Price
                                </h3>
                                <input
                                    type="number"
                                    v-model="max_price"
                                    class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm w-full"
                                    min="0"
                                />
                            </div>
                        </div>
                        <h3
                            class="text-heading text-sm md:text-base mt-3 font-semibold mb-7 text-center"
                        >
                            <button
                                class="text-[13px] md:text-sm leading-4 inline-flex items-center cursor-pointer transition ease-in-out duration-300 font-semibold font-body text-center justify-center border-0 border-transparent rounded-md placeholder-white focus-visible:outline-none focus:outline-none h-11 md:h-12 px-3 bg-heading text-white py-1 transform-none normal-case hover:text-white w-50 md:w-6/12 xl:w-50 hover:bg-gray-700 bg-gray-900"
                                v-on:click="filProducts"
                            >
                                <span class="py-1 3xl:px-4">Filter</span>
                            </button>
                        </h3>
                    </div>
                </div>
                <div class="overflow-hidden w-full">
                    <div
                        class="relative m-3 flex flex-wrap mx-auto justify-center"
                        v-if="MyProducts.length == 0"
                    >
                        <div
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg w-full"
                        >
                            <div
                                class="p-6 bg-white border-b border-gray-200 text-center"
                            >
                                Not Found Products
                            </div>
                        </div>
                    </div>
                    <div
                        class="relative m-3 grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 gap-4 mx-auto justify-center"
                        v-if="MyProducts.length != 0"
                    >
                        <product-card
                            v-for="product in MyProducts"
                            :key="product.id"
                            :product="product"
                        ></product-card>
                    </div>
                    <div
                        class="relative m-3 flex flex-wrap mx-auto justify-center"
                        v-if="MyProducts.length != 0"
                    >
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
    </BreezeAuthenticatedLayout>
</template>

<script>
import ProductCard from "../../Components/ProductCard.vue";
import VueTailwindPagination from "@ocrv/vue-tailwind-pagination";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        VueTailwindPagination,
        Link,
        BreezeAuthenticatedLayout,
        Head,
        ProductCard,
        BreezeNavLink,
    },
    props: {
        products: Object,
        categories: Object,
    },
    data() {
        return {
            MyProducts: this.products.data,
            MYcategories: this.categories,
            min_price: null,
            max_price: null,
            filCategories: [],
            currentPage: this.products.meta.current_page,
            perPage: this.products.meta.per_page,
            total: this.products.meta.total,
        };
    },
    methods: {
        filProducts() {
            axios
                .get(this.route("filter"), {
                    params: {
                        page: this.currentPage,
                        categories: this.filCategories,
                        min_price: this.min_price,
                        max_price: this.max_price,
                    },
                })
                .then((response) => {
                    this.MyProducts = response.data.data;
                    this.perPage = response.data.meta.per_page;
                    this.total = response.data.meta.total;
                })
                .catch((e) => {});
        },
        changePage(numberPage) {
            this.currentPage = numberPage;
            this.filProducts();
        },
    },
    mounted() {},
};
</script>
<style>
.-mt-0\.5 {
    margin-top: -0.125rem;
    margin-left: 11px;
}
</style>
