<template>
  <div class="row">
    <div class="col-12">
      <form @submit.prevent="submit">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">User</h4>
          </div>
          <div class="card-body">
            <div v-for="(role, index) in roles" :key="`role-${index}`">
              <label
                :for="`role-input-${index}`"
                class="mb-2 form-check-inline"
              >
                <input
                  type="checkbox"
                  class="form-check-input me-1"
                  :id="`role-input-${index}`"
                  :value="role.label"
                  v-model="form.roles"
                />
                {{ role.label }}
              </label>
            </div>
          </div>

          <div class="card-body border-top d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-secondary me-2"
              @click="$inertia.visit(route('users.index'))"
            >
              Kembali
            </button>
            <button-action type="submit" label="Simpan" :loading="loading" />
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Main from "@/Layouts/Main.vue";
import TextField from "@/Components/Global/Form/TextField.vue";
import SelectInput from "@/Components/Global/Form/SelectInput.vue";
import ButtonAction from "@/Components/Global/Form/ButtonAction.vue";

export default {
  layout: Main,
  components: {
    TextField,
    SelectInput,
    ButtonAction,
  },
  props: {
    resource: Object,
    selectedRoles: Array,
    roles: Array,
  },
  data() {
    return {
      loading: false,
      form: {
        id: this.resource.id,
        roles: this.selectedRoles,
        _method: "PUT",
      },
    };
  },
  methods: {
    submit() {
      if (this.loading) {
        return;
      }

      this.loading = true;
      this.$inertia.post(
        this.route("users.update", this.resource.id),
        this.form,
        {
          preserveScroll: true,
          preserveState: true,
          onSuccess: (response) => {
            this.loading = false;
          },
          onError: (error) => {
            this.loading = false;
          },
        }
      );
    },
  },
};
</script>
