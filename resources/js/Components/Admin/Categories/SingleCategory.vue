<template>
    <tr>
        <th
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
                text-left
                flex
                items-center
            "
        >
            <span class="ml-3 font-bold text-blueGray-600">
                <inertia-link
                    :href="route('categories.edit', { id: category.id })"
                >
                    {{ category.name }}
                </inertia-link>
            </span>
        </th>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
            "
        >
            {{ category.description.slice(0, 50).concat("...") }}
        </td>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
            "
        >
            <i class="fas fa-circle text-orange-500 mr-2"></i>
            {{ category.slug }}
        </td>
        <td
            class="
                border-t-0
                px-6
                align-middle
                border-l-0 border-r-0
                text-xs
                whitespace-nowrap
                p-4
            "
        >
            <inertia-link :href="route('categories.edit', { id: category.id })">
                Edit
            </inertia-link>
            <inertia-link @click="destroy(category.id)"> Delete </inertia-link>
        </td>
    </tr>

    <template
        v-for="childCategory in category.child_categories"
        :key="childCategory.id"
    >
        <tr>
            <th
                class="
                    border-t-0
                    px-6
                    align-middle
                    border-l-0 border-r-0
                    text-xs
                    whitespace-nowrap
                    p-4
                    text-left
                    flex
                    items-center
                "
            >
                <span class="ml-3 font-bold text-blueGray-600">
                    <inertia-link
                        :href="
                            route('categories.edit', { id: childCategory.id })
                        "
                    >
                        — {{ childCategory.name }}
                    </inertia-link>
                </span>
            </th>
            <td
                class="
                    border-t-0
                    px-6
                    align-middle
                    border-l-0 border-r-0
                    text-xs
                    whitespace-nowrap
                    p-4
                "
            >
                {{ childCategory.description.slice(0, 50).concat("...") }}
            </td>
            <td
                class="
                    border-t-0
                    px-6
                    align-middle
                    border-l-0 border-r-0
                    text-xs
                    whitespace-nowrap
                    p-4
                "
            >
                <i class="fas fa-circle text-orange-500 mr-2"></i>
                {{ childCategory.slug }}
            </td>
            <td
                class="
                    border-t-0
                    px-6
                    align-middle
                    border-l-0 border-r-0
                    text-xs
                    whitespace-nowrap
                    p-4
                "
            >
                <inertia-link
                    :href="route('categories.edit', { id: childCategory.id })"
                >
                    Edit
                </inertia-link>
                <inertia-link @click="destroy(childCategory.id)">
                    Delete
                </inertia-link>
            </td>
        </tr>

        <tr
            v-for="childChildCategory in childCategory.child_categories"
            :key="childChildCategory.id"
        >
            <th
                class="
                    border-t-0
                    px-6
                    align-middle
                    border-l-0 border-r-0
                    text-xs
                    whitespace-nowrap
                    p-4
                    text-left
                    flex
                    items-center
                "
            >
                <span class="ml-3 font-bold text-blueGray-600">
                    <inertia-link
                        :href="
                            route('categories.edit', {
                                id: childChildCategory.id,
                            })
                        "
                    >
                        —— {{ childChildCategory.name }}
                    </inertia-link>
                </span>
            </th>
            <td
                class="
                    border-t-0
                    px-6
                    align-middle
                    border-l-0 border-r-0
                    text-xs
                    whitespace-nowrap
                    p-4
                "
            >
                {{ childChildCategory.description.slice(0, 50).concat("...") }}
            </td>
            <td
                class="
                    border-t-0
                    px-6
                    align-middle
                    border-l-0 border-r-0
                    text-xs
                    whitespace-nowrap
                    p-4
                "
            >
                <i class="fas fa-circle text-orange-500 mr-2"></i>
                {{ childChildCategory.slug }}
            </td>
            <td
                class="
                    border-t-0
                    px-6
                    align-middle
                    border-l-0 border-r-0
                    text-xs
                    whitespace-nowrap
                    p-4
                "
            >
                <inertia-link
                    :href="
                        route('categories.edit', { id: childChildCategory.id })
                    "
                >
                    Edit
                </inertia-link>
                <inertia-link @click="destroy(childChildCategory.id)">
                    Delete
                </inertia-link>
            </td>
        </tr>
    </template>
</template>
<script>
export default {
    props: ["category"],
    methods: {
        destroy(id) {
            this.$inertia.delete(route("categories.destroy", id));
        },
    },
};
</script>
<style></style>
