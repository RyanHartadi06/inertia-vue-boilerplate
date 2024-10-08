<template>
  <div class="row">
    <div class="col-12">
      <form @submit.prevent="submit">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Satuan</h4>
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
                <text-area
                  label="Deskripsi"
                  placeholder="Deskripsi"
                  name="description"
                  v-model="form.description"
                  :errors="$page.props.errors.description"
                />
              </div>
              <div class="col-sm-6">
                <file-input
                  label="File"
                  placeholder="File"
                  name="file"
                  v-model="form.file"
                  :errors="$page.props.errors.file"
                  accept=".pdf"
                  max-size="2MB"
                  no-preview
                  required
                  imageIcon="ri-file-paper-line display-3"
                />
              </div>
            </div>
          </div>

          <div class="card-body border-top d-flex justify-content-end">
            <button
              type="button"
              class="btn btn-secondary me-2"
              @click="$inertia.visit(route('guides.index'))"
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
import TextArea from "@/Components/Global/Form/TextArea.vue";
import FileInput from "@/Components/Global/Form/FileInput.vue";
import ButtonAction from "@/Components/Global/Form/ButtonAction.vue";

export default {
  layout: Main,
  components: {
    TextField,
    TextArea,
    FileInput,
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
        description: this.resource.description,
        file: this.resource.file,
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
        this.route("guides.update", this.resource.id),
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
