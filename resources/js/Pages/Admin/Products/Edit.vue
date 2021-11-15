<template>
    <Head title="Edit Product" />
    <admin-layout>
        <div
            class="
                relative
                flex flex-col
                min-w-0
                break-words
                w-full
                mb-6
                shadow-lg
                rounded-lg
                bg-blueGray-100
                border-0
            "
        >
            <div
                class="
                    bg-teal-100
                    border-t-4 border-teal-500
                    rounded-b
                    text-teal-900
                    px-4
                    py-3
                    shadow-md
                    my-3
                "
                role="alert"
                v-if="$page.props.flash.message"
            >
                <div class="flex">
                    <div>
                        <p class="text-sm">{{ $page.props.flash.message }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-t bg-white mb-0 px-6 py-6">
                <div class="text-center flex justify-between">
                    <h6 class="text-blueGray-700 text-xl font-bold">
                        Edit Product: {{ product.name }}
                    </h6>
                    <inertia-link
                        :href="route('products.index')"
                        class="
                            bg-black
                            text-white
                            active:bg-emerald-600
                            font-bold
                            uppercase
                            text-xs
                            px-4
                            py-2
                            rounded
                            shadow
                            hover:shadow-md
                            outline-none
                            focus:outline-none
                            mr-1
                            ease-linear
                            transition-all
                            duration-150
                        "
                    >
                        Back to Products
                    </inertia-link>
                </div>
            </div>
            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                <form @submit.prevent="update">
                    <div class="flex flex-wrap mb-3">
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="
                                        block
                                        uppercase
                                        text-blueGray-600 text-xs
                                        font-bold
                                        mb-2
                                    "
                                    for="grid-password"
                                >
                                    Product Name </label
                                ><input
                                    type="text"
                                    class="
                                        border-0
                                        px-3
                                        py-3
                                        placeholder-blueGray-300
                                        text-blueGray-600
                                        bg-white
                                        rounded
                                        text-sm
                                        shadow
                                        focus:outline-none focus:ring
                                        w-full
                                        ease-linear
                                        transition-all
                                        duration-150
                                    "
                                    v-model="form.name"
                                    id="name"
                                    name="name"
                                    required
                                />
                                <div
                                    v-if="$page.props.errors.name"
                                    class="text-red-500"
                                >
                                    {{ $page.props.errors.name[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="
                                        block
                                        uppercase
                                        text-blueGray-600 text-xs
                                        font-bold
                                        mb-2
                                    "
                                    for="grid-password"
                                >
                                    Product Slug </label
                                ><input
                                    type="text"
                                    class="
                                        border-0
                                        px-3
                                        py-3
                                        placeholder-blueGray-300
                                        text-blueGray-600
                                        bg-white
                                        rounded
                                        text-sm
                                        shadow
                                        focus:outline-none focus:ring
                                        w-full
                                        ease-linear
                                        transition-all
                                        duration-150
                                    "
                                    v-model="form.slug"
                                    id="slug"
                                    name="slug"
                                    required
                                />
                            </div>
                            <div class="relative w-full mb-3">
                                <label
                                    class="
                                        block
                                        uppercase
                                        text-blueGray-600 text-xs
                                        font-bold
                                        mb-2
                                    "
                                    for="grid-password"
                                >
                                    Product Quantity </label
                                ><input
                                    type="number"
                                    class="
                                        border-0
                                        px-3
                                        py-3
                                        placeholder-blueGray-300
                                        text-blueGray-600
                                        bg-white
                                        rounded
                                        text-sm
                                        shadow
                                        focus:outline-none focus:ring
                                        w-full
                                        ease-linear
                                        transition-all
                                        duration-150
                                    "
                                    v-model="form.quantity"
                                    id="quantity"
                                    name="quantity"
                                    required
                                    min="1"
                                />
                            </div>
                            <div class="relative w-full mb-3">
                                <label
                                    class="
                                        block
                                        uppercase
                                        text-blueGray-600 text-xs
                                        font-bold
                                        mb-2
                                    "
                                    for="grid-password"
                                >
                                    Product Price Per Unit
                                </label>
                                <currency-input
                                    type="text"
                                    class="
                                        border-0
                                        px-3
                                        py-3
                                        placeholder-blueGray-300
                                        text-blueGray-600
                                        bg-white
                                        rounded
                                        text-sm
                                        shadow
                                        focus:outline-none focus:ring
                                        w-full
                                        ease-linear
                                        transition-all
                                        duration-150
                                    "
                                    v-model="form.price"
                                    id="price"
                                    name="price"
                                    required
                                    :options="{
                                        currency: 'USD',
                                        locale: 'en',
                                        currencyDisplay: 'narrowSymbol',
                                        precision: 2,
                                        exportValueAsInteger: true,
                                    }"
                                />
                            </div>
                            <div class="relative w-full mb-3">
                                <label
                                    class="
                                        block
                                        uppercase
                                        text-blueGray-600 text-xs
                                        font-bold
                                        mb-2
                                    "
                                    for="grid-password"
                                >
                                    Select Category
                                </label>

                                <Multiselect
                                    name="categories[]"
                                    v-model="form.categories"
                                    :options="
                                        categories.map(
                                            (category) => category.id
                                        )
                                    "
                                    :custom-label="
                                        (opt) => {
                                            let category = categories.find(
                                                (x) => x.id == opt
                                            );

                                            return (
                                                category.parent_category
                                                    .parent_category.name +
                                                ' / ' +
                                                category.parent_category.name +
                                                ' / ' +
                                                category.name
                                            );
                                        }
                                    "
                                    placeholder="Select Categories"
                                    :multiple="true"
                                />
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="
                                        block
                                        uppercase
                                        text-blueGray-600 text-xs
                                        font-bold
                                        mb-2
                                    "
                                    for="grid-password"
                                >
                                    Product Images
                                </label>
                                <div class="flex gap-x-4 mb-4">
                                    <div
                                        v-for="existingImage in existingImages"
                                        :key="existingImage.id"
                                        class="single-image w-24 h-24 relative"
                                    >
                                        <img
                                            :src="`/storage/${existingImage.path}`"
                                            class="object-cover w-full h-full"
                                        />
                                        <button
                                            onclick="event.preventDefault()"
                                            @click="
                                                removeImage(existingImage.id)
                                            "
                                            type="submit"
                                            class="
                                                absolute
                                                -top-1
                                                -right-1
                                                text-white
                                                px-2
                                                py-1
                                                font-semibold
                                                leading-tight
                                                bg-red-400
                                                opacity-75
                                                rounded-xl
                                                hover:opacity-100
                                            "
                                        >
                                            X
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-4" v-if="countImages() > 0">
                            <div class="relative w-full mb-3">
                                <label
                                    class="
                                        block
                                        uppercase
                                        text-blueGray-600 text-xs
                                        font-bold
                                        mb-2
                                    "
                                    for="grid-password"
                                >
                                    Upload New Images
                                </label>
                                <file-pond
                                    name="images"
                                    ref="pond"
                                    :label-idle="`Drop files here... ${countImages()} left`"
                                    allow-multiple="true"
                                    :max-files="countImages()"
                                    accepted-file-types="image/jpeg, image/png"
                                    v-on:updatefiles="handleFilePondUpdateFile"
                                    v-model="form.images"
                                />
                            </div>
                        </div>
                    </div>

                    <button
                        class="
                            bg-black
                            text-white
                            active:bg-blueGray-600
                            text-sm
                            font-bold
                            uppercase
                            px-6
                            py-3
                            rounded
                            shadow
                            hover:shadow-lg
                            outline-none
                            focus:outline-none
                            mr-1
                            mb-1
                            w-full
                            ease-linear
                            transition-all
                            duration-150
                        "
                        type="button"
                        @click="update(form)"
                    >
                        Update
                    </button>
                </form>
            </div>
        </div>
    </admin-layout>
</template>
<script>
import AdminLayout from "@/Layouts/AdminLayout";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import vueFilePond from "vue-filepond";
import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import { Inertia } from "@inertiajs/inertia";
import Multiselect from "@suadelabs/vue3-multiselect";
import CurrencyInput from "../../../Components/Admin/Inputs/CurrencyInput";

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview
);

export default {
    components: {
        AdminLayout,
        FilePond,
        Head,
        Multiselect,
        CurrencyInput,
    },
    props: ["errors"],
    props: {
        product: Object,
        existingImages: Object,
        quantity: Number,
        categories: Array,
        price: Object,
    },
    setup(props) {
        const form = useForm({
            name: props.product.name,
            slug: props.product.slug,
            quantity: props.quantity ? props.quantity : 0,
            categories: props.product.categories.map((category) => category.id),
            price: props.price,
            images: [],
        });

        return { form };
    },
    watch: {
        existingImages: function (oldVal, newVal) {
            this.countImages();
        },
    },
    methods: {
        countImages() {
            const maxImages = 6;
            return maxImages - this.existingImages.length;
        },
        handleFilePondUpdateFile(files) {
            this.form.images = files.map((files) => files.file);
        },
        removeImage(id) {
            this.$inertia.delete(route("product-image.delete", id));
        },
        update() {
            Inertia.post(`/admin/products/${this.product.id}`, {
                _method: "put",
                forceFormData: true,
                name: this.form.name,
                slug: this.form.slug,
                quantity: this.form.quantity,
                price: this.form.price,
                categories: this.form.categories,
                images: this.form.images,
                _token: this.$page.props.csrf_token,
            });
        },
    },
    created() {
        this.countImages();
    },
};
</script>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>
