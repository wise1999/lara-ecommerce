<template>
    <sidebar />
    <div class="relative md:ml-64 bg-blueGray-100 md:pt-48 pb-48 pt-12">
        <admin-navbar />
        <div class="px-4 md:px-10 mx-auto w-full -m-24">
            <slot />
            <footer-admin />
        </div>
    </div>
</template>
<script>
import AdminNavbar from "@/components/Admin/Navbars/AdminNavbar";
import Sidebar from "@/components/Admin/Sidebar/Sidebar";
import FooterAdmin from "@/components/Admin/Footers/FooterAdmin";

export default {
    name: "admin-layout",
    components: {
        AdminNavbar,
        Sidebar,
        FooterAdmin,
    },
};
</script>
