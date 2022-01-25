<template>
    <Modal title="Edit Category" :show="showModal" @close="showModal = false">
        <form @submit.prevent="submit">
            <div>
                <BreezeLabel for="Name" value="Name" />
                <BreezeInput
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                />
            </div>
            <p class="text-red text-sm font-bold">{{ errors.name[0] }}</p>
            <div class="mt-4">
                <label class="flex items-center">
                    <span class="mr-3 text-sm text-gray-600">Status</span>
                    <BreezeCheckbox
                        name="status"
                        :checked="checkStatus"
                        v-model:checked="form.status"
                    />
                </label>
            </div>
            <div class="flex items-center justify-center mt-4">
                <BreezeButton
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Save
                </BreezeButton>
            </div>
        </form>
    </Modal>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3";
import Modal from "@/Components/Modal.vue";
import BreezeButton from "@/Components/Button.vue";
import BreezeCheckbox from "@/Components/Checkbox.vue";
import BreezeInput from "@/Components/Input.vue";
import BreezeLabel from "@/Components/Label.vue";
import axios from "axios";

export default {
    components: {
        BreezeButton,
        BreezeCheckbox,
        BreezeInput,
        BreezeLabel,
        Modal,
        Head,
    },
    props: {
        editCategory: Boolean,
        category: Object,
    },
    data() {
        return {
            showModal: this.editCategory,
            form: {
                name: this.category.name,
                status: this.category.status,
                processing: false,
            },
            errors: {
                name: "",
                status: "",
            },
        };
    },
    methods: {
        submit() {
            axios
                .put(
                    this.route("backend.category.update", this.category.id),
                    this.form
                )
                .then((response) => {
                    this.form.processing = false;
                    this.form.name = "";
                    this.form.status = false;
                    this.errors.name = "";
                    this.errors.status = "";
                    this.$emit("close");
                    this.$emit("ok");
                    this.$toast.success(response.data.message);
                })
                .catch((err) => {
                    console.log(err.response.data.errors);
                    this.errors = err.response.data.errors;
                    this.form.processing = false;
                });
        },
    },
     computed: {
        checkStatus() {
            return this.form.status ? true : false;
        },
    },
};
</script>
