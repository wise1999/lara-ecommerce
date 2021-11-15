<template>
  <Head title="Create Address" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Add new Address
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-12 gap-4">
              <sidebar></sidebar>
              <div class="col-span-8">
                <form @submit.prevent="create" class="gap-y-4 flex flex-col">
                  <label for="name" class="flex flex-col">
                    <span>Name</span>
                    <input
                      v-model="form.name"
                      type="text"
                      name="name"
                      id="name"
                    />
                  </label>
                  <label for="country" class="flex flex-col">
                    <span>Country</span>
                    <select v-model="form.country" name="country" id="country">
                      <option
                        v-for="country in countries"
                        :key="country.id"
                        :value="country.id"
                      >
                        {{ country.name }}
                      </option>
                    </select>
                  </label>
                  <label for="address_1" class="flex flex-col">
                    <span>Addres Line 1</span>
                    <input
                      v-model="form.address_1"
                      type="text"
                      name="address_1"
                      id="address_1"
                    />
                  </label>
                  <label for="city" class="flex flex-col">
                    <span>City</span>
                    <input
                      v-model="form.city"
                      type="text"
                      name="city"
                      id="city"
                    />
                  </label>
                  <div class="flex flex-col">
                    <span>Postal Code</span>
                    <input
                      v-model="form.postal_code"
                      type="text"
                      name="postal_code"
                      id="postal_code"
                    />
                  </div>
                  <button @click="create(form)" type="button" class="text-left">
                    Create
                  </button>
                </form>
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
import { Head, useForm } from "@inertiajs/inertia-vue3";
import Sidebar from "@/Components/Front/Dashboard/Sidebar.vue";

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Sidebar,
  },
  setup() {
    const form = useForm({
      name: null,
      country: null,
      address_1: null,
      city: null,
      postal_code: null,
    });

    return { form };
  },
  props: {
    countries: Array,
  },
  methods: {
    create() {
      this.form.post(route("address.store"), {
        name: this.form.name,
        country: this.form.country,
        address_1: this.form.address_1,
        city: this.form.city,
        postal_code: this.form.postal_code,
      });
    },
  },
};
</script>
