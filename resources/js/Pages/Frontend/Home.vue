<template>
    <Head title="Home" />
    <BreezeAuthenticatedLayout>
        <Filter :categories="categories" :products="products"></Filter>
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
        categories: Object,
    },
};
</script>
