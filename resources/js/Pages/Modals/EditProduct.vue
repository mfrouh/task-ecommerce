<template>
    <Modal title="Edit Product" :show="showModal" @close="showModal = false">
        <form @submit.prevent="submit" enctype="multipart/form-data">
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
            <p class="text-sm text-red-600 font-bold" v-if="errors.name">
                {{ errors.name[0] }}
            </p>
            <div class="mt-4">
                <label class="flex items-center">
                    <span class="mr-3 text-sm text-gray-600">Status</span>
                    <BreezeCheckbox v-model:checked="form.status" />
                </label>
            </div>
            <p class="text-sm text-red-600 font-bold" v-if="errors.status">
                {{ errors.status[0] }}
            </p>
            <div class="mt-4">
                <BreezeLabel for="Price" value="Price" />
                <BreezeInput
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.price"
                    required
                />
            </div>
            <p class="text-sm text-red-600 font-bold" v-if="errors.price">
                {{ errors.price[0] }}
            </p>
            <div class="mt-4">
                <BreezeLabel for="Quantity" value="Quantity" />
                <BreezeInput
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.quantity"
                    required
                />
            </div>
            <p class="text-sm text-red-600 font-bold" v-if="errors.quantity">
                {{ errors.quantity[0] }}
            </p>
            <div class="mt-4">
                <BreezeLabel for="Description" value="Description" />
                <textarea
                    rows="3"
                    type="number"
                    class="mt-1 block w-full rounded-md"
                    v-model="form.description"
                    required
                >
                </textarea>
            </div>
            <p class="text-sm text-red-600 font-bold" v-if="errors.description">
                {{ errors.description[0] }}
            </p>
            <div class="mt-4">
                <BreezeLabel for="Category" value="Category" />
                <select
                    class="mt-1 py-2 px-1 block w-full rounded-md"
                    v-model="form.category_id"
                    required
                >
                    <option value="">Select Category</option>
                    <option
                        class="mt-1 block w-full py-1 px-1"
                        v-for="category in categories"
                        :key="category.id"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>
            </div>
            <p class="text-sm text-red-600 font-bold" v-if="errors.category_id">
                {{ errors.category_id[0] }}
            </p>
            <div class="mt-4">
                <BreezeLabel for="Image" value="Image" />
                <BreezeInput
                    type="file"
                    class="mt-1 block w-full"
                    ref="file"
                    v-on:change="onChangeFileUpload"
                    accept="image/*"
                />
            </div>
            <p class="text-sm text-red-600 font-bold" v-if="errors.image">
                {{ errors.image[0] }}
            </p>
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
        editProduct: Boolean,
        product: Object,
    },
    data() {
        return {
            showModal: this.editProduct,
            form: {
                name: this.product.name,
                status: this.product.status,
                image: "",
                price: this.product.price,
                quantity: this.product.quantity,
                description: this.product.description,
                category_id: this.product.category_id,
                processing: false,
            },
            categories: [],
            errors: {
                name: "",
                status: "",
                image: "",
                price: "",
                quantity: "",
                description: "",
                category_id: "",
            },
        };
    },
    methods: {
        submit() {
            let formDate = new FormData();
            formDate.append("image", this.form.image);
            formDate.append("name", this.form.name);
            // formDate.append("status", this.form.status);
            formDate.append("price", this.form.price);
            formDate.append("quantity", this.form.quantity);
            formDate.append("description", this.form.description);
            formDate.append("category_id", this.form.category_id);
            formDate.append("_method", "put");
            axios
                .post(
                    this.route("backend.product.update", this.product.id),
                    formDate
                )
                .then((response) => {
                    this.form.processing = false;
                    this.errors.name = "";
                    this.errors.status = "";
                    this.errors.price = "";
                    this.errors.description = "";
                    this.errors.category_id = "";
                    this.errors.image = "";
                    this.errors.quantity = "";
                    this.$emit("close");
                    this.$emit("ok");
                    this.$toast.success(response.data.message);
                })
                .catch((err) => {
                    this.errors = err.response.data.errors;
                    this.form.processing = false;
                });
        },
        getData() {
            axios
                .get(this.route("backend.category.getData"))
                .then((response) => {
                    this.categories = response.data.data;
                })
                .catch((e) => {});
        },
        onChangeFileUpload(e) {
            this.form.image = e.target.files[0];
        },
    },
    mounted() {
        this.getData();
    },
};
</script>
