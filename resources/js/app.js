require("./bootstrap");
import { createApp, h } from "vue";
import { createInertiaApp, Link } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";

const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .component("inertia-link", Link)
            .use(plugin)
            .mixin({
                methods: {
                    route,
                    Role: function (role) {
                        var hasRole = false;
                        if (this.$page.props.auth.role == role) hasRole = true;

                        return hasRole;
                    },
                    Cart: function () {
                        return cart;
                    }
                },
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });
