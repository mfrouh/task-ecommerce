<template>
    <div class="flex bg-gray-200 font-roboto h-screen ">
        <AdminSidebar />
        <div class="flex-1 flex flex-col overflow-scroll">
            <AdminHeader />
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<script>
import AdminHeader from "@/Components/AdminHeader.vue";
import AdminSidebar from "@/Components/AdminSidebar.vue";

export default {
    components: {
        AdminHeader,
        AdminSidebar,
    },

    data() {
        return {};
    },
};
</script>
