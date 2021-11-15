<template>
  <Head title="Dashboard" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Change Password
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
                <form
                  @submit.prevent="changePassword"
                  class="gap-y-4 flex flex-col"
                >
                  <label for="current_password" class="flex flex-col">
                    <span>Current Password</span>
                    <input
                      v-model="form.current_password"
                      type="password"
                      name="current_password"
                      id="current_password"
                    />
                    <span v-if="$page.props.errors.current_password">{{
                      $page.props.errors.current_password[0]
                    }}</span>
                  </label>
                  <label for="password" class="flex flex-col">
                    <span>New Password</span>
                    <input
                      v-model="form.new_password"
                      type="password"
                      name="new_password"
                      id="new_password"
                    />
                  </label>
                  <label for="name" class="flex flex-col">
                    <span>Repeat Password</span>
                    <input
                      v-model="form.new_password_confirm"
                      type="password"
                      name="new_password_confirm"
                      id="new_password_confirm"
                    />
                    <span v-if="$page.props.errors.new_password_confirm">{{
                      $page.props.errors.new_password_confirm[0]
                    }}</span>
                  </label>
                  <button type="submit" class="text-left">
                    Change Password
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
  props: ["errors"],
  setup(props) {
    const form = useForm({
      current_password: "",
      new_password: "",
      new_password_confirm: "",
    });

    return { form };
  },
  methods: {
    changePassword() {
      this.form.post(
        route("dashboard.password.store", {
          current_password: this.form.current_password,
          new_password: this.form.new_password,
          new_password_confirm: this.form.new_password_confirm,
        })
      );
    },
  },
};
</script>
