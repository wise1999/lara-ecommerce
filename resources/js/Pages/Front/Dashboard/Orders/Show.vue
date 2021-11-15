<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Order {{ order.id }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-12 gap-4">
              <sidebar></sidebar>
              <div class="col-span-8">
                <ul class="w-full">
                  <li>Order ID: {{ order.id }}</li>
                  <li>Ordered :{{ order.time }}</li>
                  <li>
                    Shipping Method Chosen: {{ order.shipping.name }}
                    {{ order.shipping.price }}
                  </li>
                  <li>Status: {{ order.status }}</li>
                  <li>Subtotal: {{ order.subtotal }}</li>
                  <li>
                    Country: {{ address.country.name }}
                    <br />
                    Address Name: {{ address.name }}
                    <br />
                    Address Line 1: {{ address.address_1 }}
                    <br />
                    City: {{ address.city }}
                    <br />
                    Postal Code: {{ address.postal_code }}
                  </li>
                </ul>
                <ul class="flex flex-col gap-y-4">
                  <li v-for="product in products" :key="product.id">
                    <div>
                      <inertia-link
                        class="flex w-full items-center"
                        :href="route('product.show', { slug: product.slug })"
                      >
                        <img
                          height="150"
                          width="150"
                          class="hover:grow hover:shadow-lg"
                          :src="`/storage/${product.thumbnail.path}`"
                        />
                        <strong class="ml-auto"
                          >Quantity Ordered: {{ product.quantity }}</strong
                        >
                        <div class="pt-3 flex flex-col ml-auto">
                          <p class="">{{ product.name }}</p>
                          <p class="pt-1 text-gray-900">{{ product.price }}</p>
                        </div>
                      </inertia-link>
                    </div>
                  </li>
                </ul>
                <inertia-link
                  ><strong class="text-right block"
                    >Generate PDF Invoice</strong
                  ></inertia-link
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
import Sidebar from "@/Components/Front/Dashboard/Sidebar.vue";
import { Inertia } from "@inertiajs/inertia";
export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Sidebar,
  },
  props: {
    order: Object,
    address: Object,
    products: Array,
  },
};
</script>
<style lang="">
</style>