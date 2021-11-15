<template>
    <Head title="Create Product" />
    <admin-layout>
        <div
            class="
                relative
                flex flex-col
                min-w-0
                break-words
                w-full
                mb-6
                shadow-lg
                rounded-lg
                bg-blueGray-100
                border-0
            "
        >
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
            <div class="rounded-t bg-white mb-0 px-6 py-6">
                <div class="text-center flex justify-between">
                    <h6 class="text-blueGray-700 text-xl font-bold">
                        Add new shipping method
                    </h6>
                    <inertia-link
                        :href="route('shipping-methods.index')"
                        class="
                            bg-black
                            text-white
                            active:bg-emerald-600
                            font-bold
                            uppercase
                            text-xs
                            px-4
                            py-2
                            rounded
                            shadow
                            hover:shadow-md
                            outline-none
                            focus:outline-none
                            mr-1
                            ease-linear
                            transition-all
                            duration-150
                        "
                    >
                        Back to Shipping Methods
                    </inertia-link>
                </div>
            </div>
            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                <form @submit.prevent="create">
                    <div class="flex flex-wrap mb-3">
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="
                                        block
                                        uppercase
                                        text-blueGray-600 text-xs
                                        font-bold
                                        mb-2
                                    "
                                    for="grid-password"
                                >
                                    Shipping Method Name </label
                                ><input
                                    type="text"
                                    class="
                                        border-0
                                        px-3
                                        py-3
                                        placeholder-blueGray-300
                                        text-blueGray-600
                                        bg-white
                                        rounded
                                        text-sm
                                        shadow
                                        focus:outline-none focus:ring
                                        w-full
                                        ease-linear
                                        transition-all
                                        duration-150
                                    "
                                    v-model="form.name"
                                    id="name"
                                    required
                                />
                                <div
                                    v-if="$page.props.errors.name"
                                    class="text-red-500"
                                >
                                    {{ $page.props.errors.name[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="w-full px-4">
                            <div class="relative w-full mb-3">
                                <label
                                    class="
                                        block
                                        uppercase
                                        text-blueGray-600 text-xs
                                        font-bold
                                        mb-2
                                    "
                                    for="grid-password"
                                >
                                    Shipping Method Price </label
                                ><currency-input
                                    type="text"
                                    class="
                                        border-0
                                        px-3
                                        py-3
                                        placeholder-blueGray-300
                                        text-blueGray-600
                                        bg-white
                                        rounded
                                        text-sm
                                        shadow
                                        focus:outline-none focus:ring
                                        w-full
                                        ease-linear
                                        transition-all
                                        duration-150
                                    "
                                    v-model="form.price"
                                    id="price"
                                    name="price"
                                    required
                                    :options="{
                                        currency: 'USD',
                                        locale: 'en',
                                        currencyDisplay: 'narrowSymbol',
                                        precision: 2,
                                        exportValueAsInteger: true,
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                    <button
                        class="
                            bg-black
                            text-white
                            active:bg-blueGray-600
                            text-sm
                            font-bold
                            uppercase
                            px-6
                            py-3
                            rounded
                            shadow
                            hover:shadow-lg
                            outline-none
                            focus:outline-none
                            mr-1
                            mb-1
                            w-full
                            ease-linear
                            transition-all
                            duration-150
                        "
                        type="button"
                        @click="create(form)"
                    >
                        Save
                    </button>
                </form>
            </div>
        </div>
    </admin-layout>
</template>
<script>
import AdminLayout from "@/Layouts/AdminLayout";
import { Head } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import CurrencyInput from "../../../Components/Admin/Inputs/CurrencyInput";

export default {
    components: {
        AdminLayout,
        Head,
        CurrencyInput,
    },
    props: ["errors"],
    setup() {
        const form = useForm({
            name: null,
            price: null,
        });

        return { form };
    },
    methods: {
        create() {
            this.form.post(route("shipping-methods.store"), {
                name: this.form.name,
                price: this.form.price,
            });
        },
    },
};
</script>
<style src="@suadelabs/vue3-multiselect/dist/vue3-multiselect.css"></style>