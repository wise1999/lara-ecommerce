<template lang="">
    <div className="flex flex-col mb-4">
        Order Address
        <div class="order-tiles mb-4">
            <div class="order-tile default">
                <ul>
                    <li>
                        {{ current_address.name }}
                    </li>
                    <li>
                        {{ current_address.country.name }}
                    </li>
                    <li>
                        {{ current_address.address_1 }}
                    </li>
                    <li>
                        {{ current_address.city }}
                    </li>
                    <li>
                        {{ current_address.postal_code }}
                    </li>
                </ul>
            </div>
        </div>

        <div>
            <div v-if="addresses.length > 1">
                <button @click="changing = !changing">
                    Change Shipping Address
                </button>
            </div>
            <div v-else>
                <button @click="creating = !creating">Create new One</button>
            </div>

            <div v-if="changing" class="other-addresses flex gap-x-4">
                <div
                    class="single-addres"
                    v-for="address in addresses"
                    :key="address.id"
                >
                    <ul class="flex flex-col" v-if="!Boolean(address.default)">
                        <li>
                            {{ address.name }}
                        </li>
                        <li>
                            {{ address.country.name }}
                        </li>
                        <li>
                            {{ address.address_1 }}
                        </li>
                        <li>
                            {{ address.city }}
                        </li>
                        <li>
                            {{ address.postal_code }}
                        </li>
                        <button @click="setDefault(address.id)">
                            Ship here
                        </button>
                    </ul>
                </div>
            </div>

            <div v-if="creating" class="other-addresses flex gap-x-4">
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
                        <select
                            v-model="form.country"
                            name="country"
                            id="country"
                        >
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
                    <button
                        @click="create(form)"
                        type="button"
                        class="text-left"
                    >
                        Create
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
export default {
    data: function () {
        return {
            changing: false,
            creating: false,
        };
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
        addresses: Array,
        current_address: Object,
        countries: Array,
    },
    methods: {
        setDefault(id) {
            Inertia.post(route("set-default-address", { id: id }));
        },
        create() {
            this.form.post(route("address.store"), {
                name: this.form.name,
                country: this.form.country,
                address_1: this.form.address_1,
                city: this.form.city,
                postal_code: this.form.postal_code,
            });
            this.creating = false;
        },
    },
};
</script>
