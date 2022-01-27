<template>
    <Head title="Product" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ product.name }}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl flex mx-auto sm:px-6 lg:px-8">
                <div
                    class="block lg:grid grid-cols-2 gap-x-10 xl:gap-x-14 pt-7 pb-10 lg:pb-14 2xl:pb-20 items-start"
                >
                    <div class="col-span-1 grid grid-cols-1 gap-2.5">
                        <div
                            class="col-span-1 transition duration-150 ease-in hover:opacity-90"
                        >
                            <img
                                :src="product.image"
                                class="object-cover w-full"
                            />
                        </div>
                    </div>
                    <div class="col-span-1 grid grid-cols-1 gap-2.5">
                        <div class="pb-7 border-b border-gray-300">
                            <h2
                                class="text-heading text-lg md:text-xl lg:text-2xl 2xl:text-3xl font-bold hover:text-black mb-3.5"
                            >
                                {{ product.name }}
                            </h2>
                            <p
                                class="text-body text-sm lg:text-base leading-6 lg:leading-8"
                            >
                                {{ product.description }}
                            </p>
                            <div class="flex items-center mt-5">
                                <div
                                    class="text-heading font-bold text-base md:text-xl lg:text-2xl 2xl:text-4xl pe-2 md:pe-0 lg:pe-2 2xl:pe-0"
                                >
                                    {{ product.price }} EGP
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex items-center gap-4 space-s-4 md:pe-32 lg:pe-12 2xl:pe-32 3xl:pe-48 border-b border-gray-300 py-8"
                        >
                            <select
                                v-model="quantity"
                                class="font-justify-center semibold rounded-md py-3 px-1 inline-flex w-full"
                            >
                                <option
                                    v-for="index in 10"
                                    :key="index"
                                    :value="index"
                                >
                                    {{ index }}
                                </option>
                            </select>
                            <button
                                class="text-[13px] md:text-sm leading-4 inline-flex items-center cursor-pointer transition ease-in-out duration-300 font-semibold font-body text-center justify-center border-0 border-transparent rounded-md placeholder-white focus-visible:outline-none focus:outline-none h-11 md:h-12 px-5 bg-heading text-white py-2 transform-none normal-case hover:text-white w-full md:w-6/12 xl:w-full hover:bg-gray-700 bg-gray-900"
                                v-on:click="addToCart"
                            >
                                <span class="py-2 3xl:px-8">Add to cart</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },
    props: {
        product: Object,
        productQuantity: Number,
    },
    data() {
        return {
            quantity: this.productQuantity,
        };
    },
    mounted() {},
    methods: {
        addToCart() {
            axios
                .post(this.route("cart.store"), {
                    product_id: this.product.id,
                    quantity: this.quantity,
                })
                .then((response) => {
                    this.$page.props.cart= response.data.cart;
                    this.$toast.success(response.data.message);
                })
                .catch((e) => {
                    if (e.response.status === 401) {
                        this.$toast.error("You Need To Login");
                    }
                });
        },
    },
};
</script>
