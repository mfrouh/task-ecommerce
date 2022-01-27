<template>
    <Head title="Category" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ category.name }}
            </h2>
        </template>

        <Filter :products="products" :category="category"></Filter>
    </BreezeAuthenticatedLayout>
</template>

<script>
import Filter from "@/Pages/Frontend/Filter.vue";
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Head,
        Filter,
        BreezeAuthenticatedLayout,
    },
    props: {
        products: Object,
        category: Object,
    },
};
</script>
