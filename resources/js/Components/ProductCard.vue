<template>
    <div
        class="relative col-span-1 bg-white shadow-md rounded-3xl p-2 mx-1 my-3 cursor-pointer"
    >
        <div class="overflow-x-hidden rounded-2xl relative">
            <img
                class="h-40 rounded-2xl w-full object-cover"
                :src="product.image"
            />
            <p
                class="absolute right-2 top-2 bg-white rounded-full p-2 cursor-pointer group"
                v-on:click="addToCart"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 group-hover:opacity-50 opacity-70"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="black"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.5"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                    ></path>
                </svg>
            </p>
        </div>
        <div class="mt-4 pl-2 mb-2 flex justify-between">
            <div>
                <p class="text-lg font-semibold text-gray-900 mb-0">
                    {{ product.name }}
                </p>
                <p class="text-md text-gray-800 mt-0">
                    {{ product.price }} EGP
                </p>
            </div>
            <div class="flex flex-col-reverse mb-1 mr-4 group cursor-pointer">
                <Link :href="product.url">Details</Link>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },
    props: {
        product: Object,
    },
    data() {
        return {};
    },
    methods: {
        addToCart() {
            axios
                .post(this.route("cart.store"), {
                    product_id: this.product.id,
                })
                .then((response) => {
                    this.$page.props.cart = response.data.cart;
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
