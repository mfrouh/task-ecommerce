<template>
    <div
        v-if="show"
        class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center"
    >
        <div
            @click.self="closeModal()"
            class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
        ></div>

        <div
            class="modal-container bg-white w-full md:max-w-md mx-auto rounded-md shadow-lg z-50 overflow-y-auto"
        >
            <div
                class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current"
            >
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md"
                >
                    <h5
                        class="text-xl font-medium leading-normal text-gray-800"
                        id="exampleModalLabel"
                    >
                        {{ title }}
                    </h5>
                    <button
                        type="button"
                        class="btn-close box-content w-4 h-4 p-1 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                        @click="closeModal()"
                    >
                        X
                    </button>
                </div>
                <div class="modal-body relative p-4">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        show: Boolean,
        title: String,
    },
    data() {
        return {};
    },

    methods: {
        closeModal() {
            this.$emit("close");
        },
    },
};
</script>
