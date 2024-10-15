<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <section class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">
                                {{ $page.props.title }}
                            </h5>
                            <div class="flex-shrink-0">
                                <button
                                    v-if="authCan('create roles')"
                                    class="btn btn-primary waves-effect waves-light d-flex align-items-center justify-content-center w-100"
                                    type="button"
                                    @click="$inertia.get(route('roles.create'))"
                                >
                                    <i class="ri-add-fill"></i> Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive fixed-solution">
                            <table
                                class="table table-striped table-hover border"
                            >
                                <thead>
                                    <tr>
                                        <table-header-column
                                            label="No"
                                            :enable-sorting="false"
                                        />
                                        <table-header-column
                                            label="Nama"
                                            :enable-sorting="false"
                                        />
                                        <table-header-column
                                            label="Users"
                                            :enable-sorting="false"
                                        />
                                        <table-header-column
                                            label="Permissions"
                                            :enable-sorting="false"
                                        />
                                        <table-header-column
                                            label="Aksi"
                                            :enable-sorting="false"
                                            :alignCenter="true"
                                        />
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(item, index) in resources"
                                        :key="index"
                                    >
                                        <td>
                                            <Link
                                                :href="
                                                    route('roles.show', item.id)
                                                "
                                                class="text-dark text-decoration-none"
                                                >{{ index + 1 }}
                                            </Link>
                                        </td>
                                        <td>
                                            <Link
                                                :href="
                                                    route('roles.show', item.id)
                                                "
                                                class="text-dark text-decoration-none"
                                            >
                                                {{ item.name }}
                                            </Link>
                                        </td>
                                        <td>
                                            <Link
                                                :href="
                                                    route('roles.show', item.id)
                                                "
                                                class="text-dark text-decoration-none"
                                                >{{ item.users.length }}
                                            </Link>
                                        </td>
                                        <td>
                                            <Link
                                                :href="
                                                    route('roles.show', item.id)
                                                "
                                                class="text-dark text-decoration-none"
                                                >{{
                                                    item.name === "SUPER ADMIN"
                                                        ? "All"
                                                        : item.permissions
                                                              .length
                                                }}
                                            </Link>
                                        </td>
                                        <td>
                                            <div
                                                class="d-flex justify-content-end"
                                            >
                                                <Link
                                                    :href="
                                                        route(
                                                            'roles.show',
                                                            item.id
                                                        )
                                                    "
                                                    class="bg-primary rounded px-1 me-1"
                                                    title="Lihat detail"
                                                    ><i
                                                        class="ri-eye-fill text-white"
                                                    ></i
                                                ></Link>
                                                <Link
                                                    v-if="
                                                        item.name !==
                                                            'SUPER ADMIN' &&
                                                        authCan('edit roles')
                                                    "
                                                    :href="
                                                        route(
                                                            'roles.edit',
                                                            item.id
                                                        )
                                                    "
                                                    class="bg-warning rounded px-1 me-1"
                                                    title="Edit"
                                                    ><i
                                                        class="ri-pencil-fill text-white"
                                                    ></i
                                                ></Link>
                                                <a
                                                    v-if="
                                                        authCan(
                                                            'delete roles'
                                                        ) &&
                                                        !isStaticRole(
                                                            item.name
                                                        ) &&
                                                        item.users.length === 0
                                                    "
                                                    href="#"
                                                    @click="
                                                        confirmDelete(item.id)
                                                    "
                                                    class="bg-danger rounded px-1"
                                                    title="Delete"
                                                    ><i
                                                        class="ri-delete-bin-fill text-white"
                                                    ></i
                                                ></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="resources.length === 0">
                                        <td colspan="5" class="text-center">
                                            <span class="text-muted fst-italic"
                                                >No data</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script>
import Main from "@/Layouts/Main.vue";
import TableHeaderColumn from "@/Components/Global/Table/TableHeaderColumn.vue";
import Swal from "sweetalert2";

export default {
    layout: Main,
    components: {
        TableHeaderColumn,
    },
    props: {
        title: String,
        resources: Object,
        staticRoles: Array,
    },
    data() {
        return {
            key: 1,
        };
    },
    watch: {
        query: {
            // eslint-disable-next-line func-names
            handler() {
                this.handleQueryChange();
            },
            deep: true,
        },
    },
    methods: {
        isStaticRole(role) {
            return this.staticRoles.includes(role);
        },
        confirmDelete(id) {
            Swal.fire({
                title: "Apakah Anda Yakin ?",
                text: "Data akan dihapus",
                type: "danger",
                icon: "warning",
                showCancelButton: true,
                cancelButtonText: "Batal",
                cancelButtonColor: "#E64B3C",
                confirmButtonText: "Ya, Hapus",
                confirmButtonColor: "#2889F6",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.post(
                        route("roles.destroy", id),
                        {
                            _method: "DELETE",
                        },
                        {
                            preserveScroll: false,
                            preserveState: false,
                        }
                    );
                }
            });
        },
    },
};
</script>
