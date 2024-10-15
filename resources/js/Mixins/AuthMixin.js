export default {
    data() {
        return {
            authVersion: 0,
        };
    },
    methods: {
        authCan(permissions, guard = "web") {
            if (this.$page.props.auth.user.guard !== guard) {
                return false;
            }
            if (this.authIs("SUPER ADMIN")) {
                return true;
            }
            if (
                this.$page.props.auth.user &&
                this.$page.props.auth.user.permissions
            ) {
                if (Array.isArray(permissions)) {
                    for (const i in permissions) {
                        if (
                            this.$page.props.auth.user.permissions.indexOf(
                                permissions[i]
                            ) === -1
                        ) {
                            return false;
                        }
                    }
                    return true;
                } else {
                    return (
                        this.$page.props.auth.user.permissions.indexOf(
                            permissions
                        ) !== -1
                    );
                }
            }
            return false;
        },
        authCant(permissions) {
            if (this.authIs("SUPER ADMIN")) {
                return false;
            }

            if (
                this.$page.props.auth.user &&
                this.$page.props.auth.user.permissions
            ) {
                if (Array.isArray(permissions)) {
                    for (const i in permissions) {
                        if (
                            this.$page.props.auth.user.permissions.indexOf(
                                permissions[i]
                            ) !== -1
                        ) {
                            return true;
                        }
                    }
                    return false;
                } else {
                    return (
                        this.$page.props.auth.user.permissions.indexOf(
                            permissions
                        ) === -1
                    );
                }
            }
            return true;
        },
        authIs(role) {
            if (
                this.$page.props.auth.user &&
                this.$page.props.auth.user.activeRole &&
                this.$page.props.auth.user.activeRole === role
            ) {
                return true;
            }
            return false;
        },
        authAre(roles) {
            if (
                this.$page.props.auth.user &&
                this.$page.props.auth.user.activeRole &&
                Array.isArray(roles)
            ) {
                return (
                    roles.indexOf(this.$page.props.auth.user.activeRole) !== -1
                );
            }
            return false;
        },
    },
    watch: {
        // whenever question changes, this function will run
        "$page.props.auth.user.permissions": function (newVal, oldVal) {
            if (JSON.stringify(newVal) != JSON.stringify(oldVal)) {
                this.authVersion++;
            }
        },
        "$page.props.auth.user.roles": function (newVal, oldVal) {
            if (JSON.stringify(newVal) != JSON.stringify(oldVal)) {
                this.authVersion++;
            }
        },
    },
};
