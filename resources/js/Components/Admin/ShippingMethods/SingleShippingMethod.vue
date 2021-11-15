<template>
  <tr>
    <th
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
      <span class="ml-3 font-bold text-blueGray-600">
        <inertia-link>
          {{ shipping.name }}
        </inertia-link>
      </span>
    </th>
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
      {{ shipping.price }}
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
      <inertia-link :href="route('shipping-methods.edit', { id: shipping.id })">
        Edit
      </inertia-link>
      <inertia-link @click="destroy(shipping.id)"> Delete </inertia-link>
    </td>
  </tr>
</template>
<script>
export default {
  props: ["shipping"],
  methods: {
    destroy(id) {
      this.$inertia.delete(route("shipping-methods.destroy", id));
    },
  },
};
</script>
<style></style>
