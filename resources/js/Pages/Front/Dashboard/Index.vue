<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        User's Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div
              class="
                bg-teal-100
                border-t-4 border-teal-500
                rounded-b
                text-teal-900
                px-4
                py-3
                shadow-md
                my-3
              "
              role="alert"
              v-if="$page.props.flash.message"
            >
              <div class="flex">
                <div>
                  <p class="text-sm">{{ $page.props.flash.message }}</p>
                </div>
              </div>
            </div>
            <div class="grid grid-cols-12 gap-4">
              <sidebar></sidebar>
              <div class="col-span-8">
                <div>
                  Default Address: <br />
                  {{ address.name }} <br />
                  {{ address.country.name }} <br />
                  {{ address.address_1 }} <br />
                  {{ address.city }} <br />
                  {{ address.postal_code }}
                  <br />
                  <inertia-link :href="route('address.index')"
                    >Manage Addresses</inertia-link
                  >
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

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Sidebar,
  },
  props: {
    address: Object,
  },
};
</script>
