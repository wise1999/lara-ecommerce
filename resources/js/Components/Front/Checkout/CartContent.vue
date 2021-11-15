<template lang="">
    <div>
        Order Content
        <div class="cart-overview">
            <cart-product v-for="item in cart" :item="item" :key="item.id" />
            Subtotal: {{ subtotal }}
            <div v-if="cart.length !== 0" class="w-full block mb-4">
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
                            :checked="current_shipping === shipping.id"
                        />
                        <label class="ml-2" :for="`shipping-${shipping.id}`">
                            {{ shipping.name }} + {{ shipping.formatted }}
                        </label>
                    </div>
                </div>
                Total: {{ total }}
            </div>
        </div>
    </div>
</template>
<script>
import CartProduct from "@/Components/Front/Cart/CartProduct";
import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
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
