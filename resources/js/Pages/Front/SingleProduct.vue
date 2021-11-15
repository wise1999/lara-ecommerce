<template>
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ product.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex wrap gap-x-12">
                            <div class="left-col w-1/2">
                                <carousel :items-to-show="1">
                                    <slide
                                        v-for="image in product.images"
                                        :key="image.id"
                                    >
                                        <img
                                            class="w-24 h-24"
                                            :src="`/storage/${image.path}`"
                                            alt=""
                                        />
                                    </slide>

                                    <template #addons>
                                        <navigation />
                                        <pagination />
                                    </template>
                                </carousel>
                            </div>
                            <div class="right-col w-1/2">
                                <h1>{{ product.name }}</h1>
                                <h2>{{ product.price }}</h2>
                                <form
                                    @submit.prevent="add"
                                    class="flex flex-col"
                                >
                                    <select
                                        name="quantity"
                                        id="quantity"
                                        v-model="form.quantity"
                                    >
                                        <option
                                            :value="x"
                                            v-for="x in parseInt(
                                                product.stock_count
                                            )"
                                            :key="x"
                                        >
                                            {{ x }}
                                        </option>
                                    </select>
                                    <button class="text-left">
                                        Add to cart
                                    </button>
                                </form>
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
import { Inertia } from "@inertiajs/inertia";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import "vue3-carousel/dist/carousel.css";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
        Carousel,
        Slide,
        Pagination,
        Navigation,
        useForm,
    },
    props: {
        product: Object,
    },
    setup() {
        const form = useForm({
            quantity: 1,
        });
        return { form };
    },
    methods: {
        add() {
            Inertia.post(route("cart.store"), {
                quantity: this.form.quantity,
                product_id: this.product.id,
                user_id: this.$page.props.auth.user.id,
            });
        },
    },
};
</script>
