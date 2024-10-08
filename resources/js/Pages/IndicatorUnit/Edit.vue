<template>
  <div class="row">
    <div class="col-12">
      <form @submit.prevent="submit">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Satuan</h4>
          </div>
          <div class="card-body">
            <text-field
              label="Satuan"
              placeholder="Satuan"
              name="name"
              v-model="form.name"
              :errors="$page.props.errors.name"
              required
            />
          </div>

          <div class="card-body border-top d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-secondary me-2"
              @click="$inertia.visit(route('indicator-units.index'))"
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
import ButtonAction from "@/Components/Global/Form/ButtonAction.vue";

export default {
  layout: Main,
  components: {
    TextField,
    ButtonAction,
  },
  props: {
    resource: Object,
  },
  data() {
    return {
      loading: false,
      form: {
        id: this.resource.id,
        name: this.resource.name,
      },
    };
  },
  methods: {
    submit() {
      if (this.loading) {
        return;
      }

      this.loading = true;
      this.$inertia.put(
        this.route("indicator-units.update", this.resource.id),
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
