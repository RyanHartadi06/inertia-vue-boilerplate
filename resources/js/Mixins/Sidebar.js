export default {
    props: {
        currentUrl: {
            type: String,
            required: false,
        },
    },
    data() {
        return {
            activeUrl: "",
            flatMenu: false
        };
    },
    computed: {
        navItems() {
            return this.menus.map((item) => {
                return {
                    authorized: item.children
                        ?.map((children) => {
                            return children.authorized;
                        })
                        .find((children) => children),
                    ...item,
                    children: item.children?.map((children) => ({
                        ...children,
                        isActive:
                            this.getCurrentMenu(this.activeUrl, this.flatMenu ? 1 : 2) ===
                            this.getCurrentMenu(
                                route(children.routeName).toString(),
                                this.flatMenu ? 1 : 2
                            ),
                    })),
                    isActive: item.children
                        ? this.getCurrentMenu(this.activeUrl) === item.name || this.isChildActive(item.children)
                        : this.getCurrentMenu(this.activeUrl) ===
                        this.getCurrentMenu(route(item.routeName).toString()),
                };
            });
        },
    },
    watch: {
        $page: {
            immediate: true,
            handler(val) {
                this.activeUrl = window.location.href;
            },
        },
    },
    methods: {
        getCurrentMenu(url, count = 1) {
            const indexBasePath = 4;
            const menuPathArray = url.split("/");
            const slicedPath = menuPathArray
                .slice(indexBasePath, indexBasePath + count)
                .join("/");
            const removedParams = slicedPath.split("?")[0];
            return removedParams;
        },
        isChildActive(item) {
            let parentActive = false
            item?.map((children) => {
                if (this.getCurrentMenu(this.activeUrl, this.flatMenu ? 1 : 2) ===
                    this.getCurrentMenu(
                        route(children.routeName).toString(),
                        this.flatMenu ? 1 : 2
                    )) {
                    parentActive = true;
                }
            });
            return parentActive
        }
    },
}
