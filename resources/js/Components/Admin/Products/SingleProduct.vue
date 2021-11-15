<template>
    <tr>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
                text-left
                flex
                items-center
            "
        >
            <img
                v-if="product.thumbnail"
                width="48"
                height="48"
                :src="`/storage/${product.thumbnail.path}`"
                class="h-12 w-12 bg-white rounded-full border object-contain"
                alt="..."
            /><span class="ml-3 font-bold text-blueGray-600">
                <inertia-link
                    :href="route('products.edit', { id: product.id })"
                >
                    {{ product.name }}
                </inertia-link>
            </span>
        </td>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
            "
        >
            <span v-if="product.in_stock">
                {{ product.stock_count }}
            </span>
            <span v-else> Out of stock </span>
        </td>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
            "
        >
            {{ product.price }}
        </td>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
            "
        >
            <span
                class="block"
                v-if="product.categories"
                v-for="category in product.categories"
                :key="category.id"
            >
                {{ category.name }}
            </span>
        </td>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
            "
        >
            {{ product.created }}
        </td>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
            "
        >
            <i class="fas fa-circle text-orange-500 mr-2"></i>
            {{ product.slug }}
        </td>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
            "
        >
            <inertia-link :href="route('products.edit', { id: product.id })">
                Edit
            </inertia-link>
            <inertia-link @click="destroy(product.id)"> Delete </inertia-link>
        </td>
    </tr>
</template>
<script>
export default {
    props: ["product"],
    methods: {
        destroy(id) {
            this.$inertia.delete(route("products.destroy", id));
        },
    },
};
</script>
<style></style>
