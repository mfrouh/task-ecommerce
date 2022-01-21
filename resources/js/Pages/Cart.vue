<template>
    <Head title="Cart" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cart
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl flex mx-auto sm:px-6 lg:px-8">
                <div class="container mx-auto">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-white shadow-md rounded-sm">
                                <tr>
                                    <th
                                        class="px-6 py-3 font-bold whitespace-nowrap"
                                    >
                                        Image
                                    </th>
                                    <th
                                        class="px-6 py-3 font-bold whitespace-nowrap"
                                    >
                                        Product
                                    </th>
                                    <th
                                        class="px-6 py-3 font-bold whitespace-nowrap"
                                    >
                                        Qty
                                    </th>
                                    <th
                                        class="px-6 py-3 font-bold whitespace-nowrap"
                                    >
                                        Price
                                    </th>
                                    <th
                                        class="px-6 py-3 font-bold whitespace-nowrap"
                                    ></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr
                                    v-for="cart in MyCarts"
                                    :key="cart.id"
                                    class="shadow-sm rounded-sm"
                                >
                                    <td>
                                        <div class="flex justify-center">
                                            <img
                                                :src="cart.product.image"
                                                class="object-cover h-28 w-28 rounded-2xl"
                                            />
                                        </div>
                                    </td>
                                    <td
                                        class="p-4 px-6 text-center whitespace-nowrap"
                                    >
                                        <div
                                            class="flex flex-col items-center justify-center"
                                        >
                                            <h3>{{ cart.product.name }}</h3>
                                        </div>
                                    </td>
                                    <td
                                        class="p-4 px-6 text-center whitespace-nowrap"
                                    >
                                        <div>{{ cart.quantity }}</div>
                                    </td>
                                    <td
                                        class="p-4 px-6 text-center whitespace-nowrap"
                                    >
                                        {{ cart.total_price }} EGP
                                    </td>
                                    <td
                                        class="p-4 px-6 text-center whitespace-nowrap"
                                    >
                                        <button
                                            v-on:click="removeFromCart(cart.id)"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="w-6 h-6 text-red-400"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr v-if="MyCarts.length==0">
                                    <td colspan="5">
                                        <p class="text-center p-3">Cart Empty</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
        carts: Object,
    },
    mounted() {},
    data() {
        return {
            MyCarts: this.carts,
        };
    },
    methods: {
        removeFromCart(cart) {
            axios
                .delete(this.route("cart.destroy", cart))
                .then((response) => {
                    this.$page.props.cartCount = response.data.cartCount;
                    this.$toast.error(response.data.message);
                    this.getCart();
                })
                .catch((e) => {});
        },
        getCart() {
            axios
                .get(this.route("getCart"))
                .then((response) => {
                    this.MyCarts = response.data.data;
                })
                .catch((e) => {});
        },
    },
};
</script>
