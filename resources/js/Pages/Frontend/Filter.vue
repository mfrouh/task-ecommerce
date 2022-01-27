<template>
    <div class="">
        <div>
            <div
                class="fixed inset-0 flex z-40 lg:hidden"
                role="dialog"
                aria-modal="true"
                v-if="show"
            >
                <div
                    class="fixed inset-0 bg-black bg-opacity-25"
                    aria-hidden="true"
                    v-on:click="(show = false), this.$emit('close')"
                ></div>
                <div
                    class="ml-auto relative max-w-xs w-full h-full bg-white shadow-xl py-4 pb-12 flex flex-col overflow-y-auto"
                >
                    <div class="px-4 flex items-center justify-between">
                        <h2 class="text-lg font-medium text-gray-900">
                            Filters
                        </h2>
                        <button
                            v-on:click="(show = false), this.$emit('close')"
                            type="button"
                            class="-mr-2 w-10 h-10 bg-white p-2 rounded-md flex items-center justify-center text-gray-400"
                        >
                            <span class="sr-only">Close menu</span>
                            <!-- Heroicon name: outline/x -->
                            <svg
                                class="h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>

                    <!-- Filters -->
                    <div class="mt-4 border-t border-gray-200">
                        <div
                            class="border-t border-gray-200 px-4 py-6"
                            v-if="MYcategories"
                        >
                            <h3
                                class="py-3 -my-3 w-full flex font-bold items-center justify-between"
                            >
                                Category
                            </h3>

                            <div class="pt-6" id="filter-section-mobile-0">
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
                            </div>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-6">
                            <h3
                                class="py-3 -my-3 w-full flex font-bold items-center justify-between"
                            >
                                Price
                            </h3>
                            <div class="pt-2" id="filter-section-2">
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
                            </div>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-6">
                            <div class="pt-2" id="filter-section-2">
                                <h3
                                    class="text-heading text-sm md:text-base mt-3 font-semibold mb-7 text-center"
                                >
                                    <button
                                        class="text-[13px] md:text-sm leading-4 inline-flex items-center cursor-pointer transition ease-in-out duration-300 font-semibold font-body text-center justify-center border-0 border-transparent rounded-md placeholder-white focus-visible:outline-none focus:outline-none h-11 md:h-12 px-3 bg-heading text-white py-1 transform-none normal-case hover:text-white w-50 md:w-6/12 xl:w-50 hover:bg-gray-700 bg-gray-900"
                                        v-on:click="filProducts"
                                    >
                                        <span class="py-1 3xl:px-4"
                                            >Filter</span
                                        >
                                    </button>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <main class="max-w-9xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="relative z-10 flex items-baseline justify-between pt-6 pb-6 border-b border-gray-200"
                >
                    <h1
                        class="text-4xl font-extrabold tracking-tight text-gray-900"
                    >
                        Products
                    </h1>

                    <div class="flex items-center">
                        <div class="relative inline-block text-left">
                            <div>
                                <button
                                    type="button"
                                    class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900"
                                    id="menu-button"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                    @click="sort = !sort"
                                >
                                    Sort
                                    <!-- Heroicon name: solid/chevron-down -->
                                    <svg
                                        class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <div
                                class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu"
                                aria-orientation="vertical"
                                aria-labelledby="menu-button"
                                tabindex="-1"
                                v-if="sort"
                            >
                                <div class="py-1" role="none">
                                    <button
                                        @click="
                                            (sortType = sortOption.slug),
                                                (sort = false),
                                                filProducts()
                                        "
                                        v-for="sortOption in sortOptions"
                                        :key="sortOption"
                                        class="font-medium text-gray-900 block px-4 py-2 text-sm w-full"
                                        :class="[
                                            sortOption.slug == sortType
                                                ? 'font-medium text-gray-900'
                                                : 'text-gray-500',
                                            sortOption.slug == sortType
                                                ? 'bg-gray-100'
                                                : '',
                                            'block px-4 py-2 text-sm',
                                        ]"
                                    >
                                        {{ sortOption.name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                        <button
                            type="button"
                            @click="show = true"
                            class="p-2 -m-2 ml-4 sm:ml-6 text-gray-400 hover:text-gray-500 lg:hidden"
                        >
                            <span class="sr-only">Filters</span>
                            <!-- Heroicon name: solid/filter -->
                            <svg
                                class="w-5 h-5"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </button>
                    </div>
                </div>

                <section aria-labelledby="products-heading" class="pt-6 pb-24">
                    <h2 id="products-heading" class="sr-only">Products</h2>

                    <div
                        class="grid grid-cols-1 lg:grid-cols-5 gap-x-8 gap-y-10"
                    >
                        <!-- Filters -->
                        <div class="hidden lg:block">
                            <div
                                class="border-b border-gray-200 py-6"
                                v-if="MYcategories"
                            >
                                <h3
                                    class="py-3 -my-3 w-full flex font-bold items-center justify-between"
                                >
                                    Category
                                </h3>
                                <div class="pt-6" id="filter-section-2">
                                    <div
                                        class="mt-2 mb-4 flex flex-col space-y-4"
                                    >
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
                                </div>
                            </div>
                            <div class="border-b border-gray-200 py-6">
                                <h3
                                    class="py-3 -my-3 w-full flex font-bold items-center justify-between"
                                >
                                    Price
                                </h3>
                                <div class="pt-6" id="filter-section-2">
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
                                </div>
                            </div>
                            <div class="border-b border-gray-200 py-6">
                                <div class="pt-2" id="filter-section-2">
                                    <h3
                                        class="text-heading text-sm md:text-base mt-3 font-semibold mb-7 text-center"
                                    >
                                        <button
                                            class="text-[13px] md:text-sm leading-4 inline-flex items-center cursor-pointer transition ease-in-out duration-300 font-semibold font-body text-center justify-center border-0 border-transparent rounded-md placeholder-white focus-visible:outline-none focus:outline-none h-11 md:h-12 px-3 bg-heading text-white py-1 transform-none normal-case hover:text-white w-50 md:w-6/12 xl:w-50 hover:bg-gray-700 bg-gray-900"
                                            v-on:click="filProducts"
                                        >
                                            <span class="py-1 3xl:px-4"
                                                >Filter</span
                                            >
                                        </button>
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Product grid -->
                        <div class="lg:col-span-4">
                            <div>
                                <div
                                    class="border-gray-200 grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-4 rounded-lg h-96 lg:h-full"
                                >
                                    <product-card
                                        v-for="product in MyProducts"
                                        :key="product.id"
                                        :product="product"
                                    ></product-card>
                                </div>
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
                </section>
            </main>
        </div>
    </div>
</template>

<script>
import ProductCard from "../../Components/ProductCard.vue";
import VueTailwindPagination from "@ocrv/vue-tailwind-pagination";
const sortOptions = [
    { name: "Newest", slug: "newest" },
    { name: "Price: Low to High", slug: "priceLTH" },
    { name: "Price: High to Low", slug: "priceHTL" },
];

export default {
    components: { ProductCard, VueTailwindPagination },
    props: {
        products: Object,
        categories: Object,
        category: Object,
    },
    data() {
        return {
            MyProducts: this.products.data,
            MYcategories: this.categories,
            min_price: null,
            max_price: null,
            filCategories: [],
            show: false,
            sort: false,
            sortType: "newest",
            currentPage: this.products.meta.current_page,
            perPage: this.products.meta.per_page,
            total: this.products.meta.total,
            sortOptions,
        };
    },
    methods: {
        filProducts() {
            axios
                .get(this.route("filter"), {
                    params: {
                        page: this.currentPage,
                        sortBy: this.sortType,
                        categories: this.MYcategories
                            ? this.filCategories
                            : [this.category.id],
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
