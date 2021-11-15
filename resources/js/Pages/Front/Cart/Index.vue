<template>
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cart
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="cart-overview">
                            <cart-product
                                v-for="item in cart"
                                :item="item"
                                :key="item.id"
                            />
                            Subtotal: {{ subtotal }}
                            <div
                                v-if="cart.length !== 0"
                                class="w-full block mb-4"
                            >
                                Shipping Method:
                                <div
                                    class="shippings"
                                    v-for="shipping in shippings"
                                    :key="shipping.id"
                                >
                                    <div class="single-shipping mb-1">
                                        <input
                                            type="radio"
                                            @change="setShipping(shipping.id)"
                                            name="shipping"
                                            :id="`shipping-${shipping.id}`"
                                            :value="shipping.id"
                                            :checked="
                                                current_shipping === shipping.id
                                            "
                                        />
                                        <label
                                            class="ml-2"
                                            :for="`shipping-${shipping.id}`"
                                        >
                                            {{ shipping.name }} +
                                            {{ shipping.formatted }}
                                        </label>
                                    </div>
                                </div>
                                Total: {{ total }}
                                <Link :href="route('order.index')"
                                    >Go to checkout</Link
                                >
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
import { Head, Link } from "@inertiajs/inertia-vue3";
import CartProduct from "@/Components/Front/Cart/CartProduct";
import { Inertia } from "@inertiajs/inertia";

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
        CartProduct,
    },
    props: {
        cart: Object,
        cart_products: Array,
        subtotal: String,
        total: String,
        shippings: Array,
        current_shipping: Number,
    },
    methods: {
        setShipping(id) {
            Inertia.post(route("shipping.store", { id: id }), {
                shipping_id: id,
            });
        },
    },
};
</script>
