<template>
    <div class="item-position flex items-center">
        <div class="product-name-image w-1/2 flex items-center gap-x-2">
            <img
                class="w-24 h-24"
                :src="`/storage/${item.attributes.first_image.path}`"
                alt=""
            />

            {{ item.name }}
        </div>
        <div class="product-price w-1/4">
            {{ item.attributes.formatted_price }} / pc
        </div>
        <div class="product-quantity w-1/4">
            <select v-model="quantity">
                <option v-if="item.quantity == 0" value="0">0</option>
                <option
                    v-for="x in item.attributes.product_stock"
                    :key="x.id"
                    :value="x"
                >
                    {{ x }}
                </option>
            </select>
        </div>

        <div class="product-action w-1/6 ml-auto">
            <button @click="removeItem(item.id)">x</button>
        </div>
    </div>
</template>
<script>
import { Inertia } from "@inertiajs/inertia";
export default {
    props: ["item"],
    computed: {
        quantity: {
            get() {
                return this.item.quantity;
            },
            set(quantity) {
                Inertia.post(route("cart.update", { id: this.item.id }), {
                    _method: "PUT",
                    quantity: quantity,
                });
            },
        },
    },
    methods: {
        removeItem(id) {
            Inertia.post(route("cart.destroy", { id: id }), {
                _method: "DELETE",
            });
        },
    },
};
</script>
