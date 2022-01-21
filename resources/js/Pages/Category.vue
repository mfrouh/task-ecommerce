<template>
    <Head title="Category" />

    <BreezeAuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-9xl grid grid-cols-4 gap-4 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white col-span-1 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-3 border-b border-gray-200 text-center">
                        Filter
                    </div>
                </div>
                <div class="col-span-3 overflow-hidden">
                    <div class=" grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 gap-4">
                         <div class="bg-white rounded-md text-left shadow-md" v-for="product in products" :key="product.id">
                        <img class="w-full h-64 rounded-md" :src="product.image"/>
                        <div class="p-2">
                            {{ product.name }}
                            ({{ product.price }} Pound)
                        </div>
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
    data() {
        return {
            products: [],
        };
    },
};
</script>
