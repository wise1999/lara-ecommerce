<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User's Addresses
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
                  <div class="col-span-12 text-right">
                    <inertia-link :href="route('address.create')"
                      >Add New</inertia-link
                    >
                  </div>
                  <div
                    class="col-span-6"
                    v-for="address in addresses"
                    :key="address.id"
                  >
                    <div class="single-address">
                      <ul>
                        <li>
                          <h3>
                            {{ address.name }}
                            <span v-if="address.default">(Main)</span>
                          </h3>
                        </li>
                        <li>{{ address.country.name }}</li>
                        <li>{{ address.address_1 }}</li>
                        <li>{{ address.city }}</li>
                        <li>
                          {{ address.postal_code }}
                        </li>
                      </ul>
                      <div class="gap-2 flex flex-wrap">
                        <div v-if="!address.default" class="w-full">
                          <button @click="setDefault(address.id)">
                            Change to default
                          </button>
                        </div>
                        <inertia-link
                          :href="route('address.edit', { id: address.id })"
                          >Edit</inertia-link
                        >
                        <inertia-link @click="destroy(address.id)"
                          >Delete
                        </inertia-link>
                      </div>
                    </div>
                  </div>
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
    addresses: Array,
  },
  methods: {
    setDefault(id) {
      Inertia.post(route("set-default-address", { id: id }));
    },
    destroy(id) {
      Inertia.delete(route("address.destroy", { id: id }));
    },
  },
};
</script>
