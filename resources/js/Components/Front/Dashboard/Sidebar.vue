<template lang="">
    <div class="col-span-4">
        <div class="sidebar">
            <ul>
                <li>
                    <inertia-link :href="route('dashboard')"
                        >Dashboard</inertia-link
                    >
                </li>
                <li>
                    <inertia-link :href="route('orders.index')"
                        >Orders</inertia-link
                    >
                </li>
                <li>
                    <inertia-link :href="route('address.index')"
                        >Shipping Addresses</inertia-link
                    >
                </li>
                <li>
                    <inertia-link :href="route('dashboard.password')"
                        >Change Password</inertia-link
                    >
                </li>
                <li>
                    <inertia-link :href="route('logout')" method="post"
                        >Logout</inertia-link
                    >
                </li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {};
</script>
