<template>
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Order
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <shipping-address
                            :addresses="addresses"
                            :current_address="current_address"
                            :countries="countries"
                        />
                        <payment-method />
                        <cart-content
                            :cart="cart"
                            :shippings="shippings"
                            :current_shipping="current_shipping"
                            :subtotal="subtotal"
                            :total="total"
                        />
                        <button @click.once="order">Order Now</button>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import ShippingAddress from "@/Components/Front/Checkout/ShippingAddress.vue";
import PaymentMethod from "@/Components/Front/Checkout/PaymentMethod.vue";
import CartContent from "@/Components/Front/Checkout/CartContent.vue";
import { Inertia } from "@inertiajs/inertia";

export default {
    components: {
        BreezeAuthenticatedLayout,
        ShippingAddress,
        PaymentMethod,
        CartContent,
    },
    props: {
        addresses: Array,
        current_address: Object,
        countries: Array,
        cart: Object,
        cart_products: Array,
        subtotal: String,
        total: String,
        shippings: Array,
        current_shipping: Number,
    },
    methods: {
        order() {
            Inertia.post(route("order.store"), {
                address_id: this.current_address.id,
                shipping_method_id: this.current_shipping,
            });
        },
    },
};
</script>
