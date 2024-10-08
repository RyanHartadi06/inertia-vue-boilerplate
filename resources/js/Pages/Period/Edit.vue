<template>
  <div class="row">
    <div class="col-12">
      <form @submit.prevent="submit">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Periode</h4>
          </div>
          <div class="card-body">
            <select-input
              label="Periode"
              placeholder="Periode"
              name="name"
              :options="years"
              v-model="form.year"
              :current-val="form.year"
              :errors="$page.props.errors.year"
              required
            />
            <text-field
              label="Bobot Direksi"
              type="number"
              placeholder="Bobot Direksi"
              name="direction_weight"
              v-model="form.direction_weight"
              :errors="$page.props.errors.direction_weight"
              required
            />
            <text-field
              label="Bobot User"
              type="number"
              placeholder="Bobot User"
              name="weight"
              v-model="form.weight"
              :errors="$page.props.errors.weight"
              required
            />
          </div>

          <div class="card-body border-top d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-secondary me-2"
              @click="$inertia.visit(route('periods.index'))"
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
    years: Array,
  },
  data() {
    return {
      loading: false,
      form: {
        id: this.resource.id,
        year: this.resource.year,
        weight: this.resource.weight,
        direction_weight: this.resource.direction_weight,
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
        this.route("periods.update", this.resource.id),
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
