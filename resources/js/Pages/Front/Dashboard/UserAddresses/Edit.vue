<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit Address: {{ address.name }}
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-12 gap-4">
              <sidebar></sidebar>
              <div class="col-span-8">
                <form @submit.prevent="update" class="gap-y-4 flex flex-col">
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
                  <button type="submit" class="text-left">Update</button>
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
import { Inertia } from "@inertiajs/inertia";

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    Sidebar,
  },
  props: {
    address: Object,
    countries: Array,
  },
  setup(props) {
    const form = useForm({
      name: props.address.name,
      country: props.address.country.id,
      address_1: props.address.address_1,
      city: props.address.city,
      postal_code: props.address.postal_code,
    });

    return { form };
  },
  methods: {
    update() {
      this.form.put(
        route("address.update", {
          id: this.address.id,
          name: this.form.name,
          country: this.form.country,
          address_1: this.form.address_1,
          city: this.form.city,
          postal_code: this.form.postal_code,
        })
      );
    },
  },
};
</script>
