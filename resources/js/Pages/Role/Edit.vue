<template>
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div
                        class="card-header align-items-center d-flex justify-content-between"
                    >
                        <h5 class="card-title mb-0">Role</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-sm-6">
                                    <text-field
                                        :disabled="isStatic(form.name)"
                                        label="Nama"
                                        placeholder="Nama"
                                        name="name"
                                        v-model="form.name"
                                        :errors="$page.props.errors.name"
                                        required
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="card-body border-top d-flex justify-content-end"
                    >
                        <button
                            type="button"
                            class="btn btn-secondary me-2"
                            @click="$inertia.visit(route('roles.index'))"
                        >
                            <i class="ri-arrow-left-s-line me-1"></i>
                            Kembali
                        </button>
                        <button-action
                            type="submit"
                            label="Simpan"
                            :loading="loading"
                            @click="submit()"
                        />
                    </div>
                </div>

                <div
                    class="bg-white shadow rounded p-3 d-flex align-items-center mb-4"
                >
                    <h5 class="card-title mb-0">Permission List</h5>
                </div>

                <div class="row">
                    <div
                        class="col-sm-3 mb-4"
                        v-for="(item, index) in permissions"
                        :key="index"
                    >
                        <div class="card h-100">
                            <div class="card-header">
                                <div
                                    class="d-flex align-items-center justify-content-between"
                                >
                                    <h6 class="text-capitalize mb-0">
                                        {{ item.name }}
                                    </h6>
                                    <label
                                        :for="`permission-parent-input-${index}`"
                                        class="form-check-inline d-flex align-items-center"
                                    >
                                        <input
                                            type="checkbox"
                                            class="form-check-input me-1"
                                            :id="`permission-parent-input-${index}`"
                                            :checked="
                                                areAllChildPermissionsSelected(
                                                    item
                                                )
                                            "
                                            @click="
                                                toggleAllChildPermissions(
                                                    item,
                                                    $event.target.checked
                                                )
                                            "
                                        />
                                        <small class="text-muted pt-1">
                                            All
                                        </small>
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="">
                                    <div
                                        v-for="(
                                            permission, indexPermission
                                        ) in item.permissions"
                                        :key="`permission-${indexPermission}`"
                                    >
                                        <small
                                            :for="`permission-input-${index}-${indexPermission}`"
                                            class="mb-2 form-check-inline"
                                        >
                                            <input
                                                type="checkbox"
                                                class="form-check-input me-1"
                                                :id="`permission-input-${index}-${indexPermission}`"
                                                :value="permission"
                                                v-model="form.permissions"
                                            />
                                            {{ permission }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white shadow rounded p-3 d-flex justify-content-end mb-5"
                >
                    <Link
                        :href="route('roles.index')"
                        class="btn btn-secondary d-flex align-items-center me-2"
                    >
                        <i class="ri-arrow-left-s-line me-1"></i>
                        Kembali</Link
                    >
                    <button-action
                        @click="submit()"
                        :loading="loading"
                        type="button"
                        label="Simpan"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Layout from "@/Layouts/Main.vue";
import TextField from "@/Components/Global/Form/TextField.vue";
import ButtonAction from "@/Components/Global/Form/ButtonAction.vue";

export default {
    layout: Layout,
    components: {
        TextField,
        ButtonAction,
    },

    props: {
        resource: {
            type: Object,
            required: true,
        },
        savedPermissions: Array,
        permissions: [Array, Object],
        staticRoles: Array,
    },

    data() {
        return {
            form: {
                id: this.resource.id,
                name: this.resource.name,
                permissions: this.savedPermissions,
                _method: "PUT",
            },
            loading: false,
        };
    },

    methods: {
        isStatic(roleName) {
            return this.staticRoles.includes(roleName);
        },
        areAllChildPermissionsSelected(parentPermission) {
            return parentPermission.permissions.every((permission) =>
                this.form.permissions.includes(permission)
            );
        },
        toggleAllChildPermissions(parentPermission, isChecked) {
            parentPermission.permissions.forEach((permission) => {
                const permissionIndex =
                    this.form.permissions.indexOf(permission);

                if (isChecked && permissionIndex === -1) {
                    this.form.permissions.push(permission);
                } else if (!isChecked && permissionIndex !== -1) {
                    this.form.permissions.splice(permissionIndex, 1);
                }
            });
        },
        submit() {
            if (this.loading) {
                return;
            }
            this.loading = true;

            this.$inertia.post(
                this.route("roles.update", this.resource.id),
                this.form,
                {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.loading = false;
                    },
                    onError: () => {
                        this.loading = false;
                    },
                }
            );
        },
    },
};
</script>
