<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User's Orders
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-12 gap-4">
              <sidebar></sidebar>
              <div class="col-span-8">
                <div class="grid grid-cols-12 gap-4">
                  <table
                    class="items-center bg-transparent w-full border-collapse"
                  >
                    <thead>
                      <tr>
                        <th
                          class="
                            px-6
                            bg-blueGray-50
                            text-blueGray-500
                            align-middle
                            border border-solid border-blueGray-100
                            py-3
                            text-xs
                            uppercase
                            border-l-0 border-r-0
                            whitespace-nowrap
                            font-semibold
                            text-left
                          "
                        >
                          Order ID
                        </th>
                        <th
                          class="
                            px-6
                            bg-blueGray-50
                            text-blueGray-500
                            align-middle
                            border border-solid border-blueGray-100
                            py-3
                            text-xs
                            uppercase
                            border-l-0 border-r-0
                            whitespace-nowrap
                            font-semibold
                            text-left
                          "
                        >
                          Order Time
                        </th>
                        <th
                          class="
                            px-6
                            bg-blueGray-50
                            text-blueGray-500
                            align-middle
                            border border-solid border-blueGray-100
                            py-3
                            text-xs
                            uppercase
                            border-l-0 border-r-0
                            whitespace-nowrap
                            font-semibold
                            text-left
                          "
                        >
                          Shipping Type
                        </th>
                        <th
                          class="
                            px-6
                            bg-blueGray-50
                            text-blueGray-500
                            align-middle
                            border border-solid border-blueGray-100
                            py-3
                            text-xs
                            uppercase
                            border-l-0 border-r-0
                            whitespace-nowrap
                            font-semibold
                            text-left
                          "
                        >
                          Status
                        </th>
                        <th
                          class="
                            px-6
                            bg-blueGray-50
                            text-blueGray-500
                            align-middle
                            border border-solid border-blueGray-100
                            py-3
                            text-xs
                            uppercase
                            border-l-0 border-r-0
                            whitespace-nowrap
                            font-semibold
                            text-left
                          "
                        >
                          Subtotal
                        </th>
                        <th
                          class="
                            px-6
                            bg-blueGray-50
                            text-blueGray-500
                            align-middle
                            border border-solid border-blueGray-100
                            py-3
                            text-xs
                            uppercase
                            border-l-0 border-r-0
                            whitespace-nowrap
                            font-semibold
                            text-left
                          "
                        ></th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for="order in orders" :key="order.id">
                        <th
                          class="
                            border-t-0
                            px-6
                            align-middle
                            border-l-0 border-r-0
                            text-xs
                            whitespace-nowrap
                            p-4
                            text-left text-blueGray-700
                          "
                        >
                          {{ order.id }}
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
                          {{ order.time }}
                        </td>
                        <td
                          class="
                            border-t-0
                            px-6
                            align-center
                            border-l-0 border-r-0
                            text-xs
                            whitespace-nowrap
                            p-4
                          "
                        >
                          {{ order.shipping.name }}
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
                          <i class="fas fa-arrow-up text-emerald-500 mr-4"></i>
                          {{ order.status }}
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
                          <i class="fas fa-arrow-up text-emerald-500 mr-4"></i>
                          {{ order.subtotal }}
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
                          <i class="fas fa-arrow-up text-emerald-500 mr-4"></i>
                          <inertia-link
                            :href="route('orders.show', { id: order.id })"
                          >
                            View Order
                          </inertia-link>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
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
    orders: Array,
  },
};
</script>
