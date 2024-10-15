<template>
    <div class="row">
        <div class="col-12">
            <form @submit.prevent="submit">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Role</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <text-field
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
                        />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Main from "@/Layouts/Main.vue";
import TextField from "@/Components/Global/Form/TextField.vue";
import ButtonAction from "@/Components/Global/Form/ButtonAction.vue";

export default {
    layout: Main,
    components: {
        TextField,
        ButtonAction,
    },
    props: {},
    data() {
        return {
            loading: false,
            form: {
                name: null,
            },
        };
    },
    methods: {
        submit() {
            if (this.loading) {
                return;
            }

            this.loading = true;
            this.$inertia.post(this.route("roles.store"), this.form, {
                preserveScroll: true,
                preserveState: true,
                onSuccess: (response) => {
                    this.loading = false;
                },
                onError: (error) => {
                    this.loading = false;
                },
            });
        },
    },
};
</script>
