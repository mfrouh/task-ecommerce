<template>
    <Head title="Home" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ MyCategory.name }}
            </h2>
        </template>

        <div class="py-6">
            <div class="max-w-9xl flex mx-auto sm:px-6 lg:px-8">
                <div
                    class="w-72 flex-shrink-0 overflow-hidden shadow-sm sm:rounded-lg"
                    style="position: sticky; top: 50px"
                >
                    <div class="p-3 ">
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
                            class="bg-white overflow-hidden shadow-sm sm:rounded-lg  w-full"
                        >
                            <div class="p-6 bg-white border-b border-gray-200 text-center">
                                Not Found Products
                            </div>
                        </div>
                    </div>
                    <div
                        class="relative m-3 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-1 gap-4 mx-auto justify-center"
                        v-if="MyProducts.length != 0"
                    >
                        <product-card
                            v-for="product in MyProducts"
                            :key="product.id"
                            :product="product"
                        ></product-card>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import ProductCard from "../../Components/ProductCard.vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        ProductCard,
    },
    props: {
        products: Object,
        category: Object,
    },
    data() {
        return {
            MyProducts: this.products,
            MyCategory: this.category,
            min_price: null,
            max_price: null,
        };
    },
    methods: {
        filProducts() {
            axios
                .get(this.route("filter"), {
                    params: {
                        min_price: this.min_price,
                        max_price: this.max_price,
                    },
                })
                .then((response) => {
                    this.MyProducts = response.data.products;
                })
                .catch((e) => {});
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
