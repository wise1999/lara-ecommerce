<template>
    <admin-layout>
        <div class="flex flex-wrap mt-4">
            <div class="w-full mb-12 px-4">
                <div
                    class="
                        relative
                        flex flex-col
                        min-w-0
                        break-words
                        w-full
                        mb-6
                        shadow-lg
                        rounded
                        bg-white
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
                                <p class="text-sm">
                                    {{ $page.props.flash.message }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-t mb-0 px-4 py-3 border-0">
                        <div class="flex flex-wrap items-center">
                            <div
                                class="
                                    relative
                                    w-full
                                    px-4
                                    max-w-full
                                    flex-grow flex-1
                                "
                            >
                                <h3
                                    class="
                                        font-semibold
                                        text-lg text-blueGray-700
                                    "
                                >
                                    Categories List
                                </h3>
                            </div>
                            <inertia-link
                                :href="route('categories.create')"
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
                                Add new
                            </inertia-link>
                        </div>
                    </div>
                    <div class="block w-full overflow-x-auto">
                        <table
                            class="
                                items-center
                                w-full
                                bg-transparent
                                border-collapse
                            "
                        >
                            <thead>
                                <tr>
                                    <th
                                        class="
                                            px-6
                                            align-middle
                                            border border-solid
                                            py-3
                                            text-xs
                                            uppercase
                                            border-l-0 border-r-0
                                            whitespace-nowrap
                                            font-semibold
                                            text-left
                                            bg-blueGray-50
                                            text-blueGray-500
                                            border-blueGray-100
                                        "
                                    >
                                        Category Name
                                    </th>
                                    <th
                                        class="
                                            px-6
                                            align-middle
                                            border border-solid
                                            py-3
                                            text-xs
                                            uppercase
                                            border-l-0 border-r-0
                                            whitespace-nowrap
                                            font-semibold
                                            text-left
                                            bg-blueGray-50
                                            text-blueGray-500
                                            border-blueGray-100
                                        "
                                    >
                                        Description
                                    </th>
                                    <th
                                        class="
                                            px-6
                                            align-middle
                                            border border-solid
                                            py-3
                                            text-xs
                                            uppercase
                                            border-l-0 border-r-0
                                            whitespace-nowrap
                                            font-semibold
                                            text-left
                                            bg-blueGray-50
                                            text-blueGray-500
                                            border-blueGray-100
                                        "
                                    >
                                        Slug
                                    </th>
                                    <th
                                        class="
                                            px-6
                                            align-middle
                                            border border-solid
                                            py-3
                                            text-xs
                                            uppercase
                                            border-l-0 border-r-0
                                            whitespace-nowrap
                                            font-semibold
                                            text-left
                                            bg-blueGray-50
                                            text-blueGray-500
                                            border-blueGray-100
                                        "
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody
                                v-for="category in categories"
                                :key="category.id"
                            >
                                <single-category :category="category" />
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>
<script>
import AdminLayout from "@/Layouts/AdminLayout";
import SingleCategory from "@/Components/Admin/Categories/SingleCategory";
export default {
    components: {
        AdminLayout,
        SingleCategory,
    },
    props: {
        categories: Array,
    },
};
</script>
<style></style>
