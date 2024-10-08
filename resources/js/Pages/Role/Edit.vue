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
              <div
                class="col-sm-3 mb-5"
                v-for="(item, index) in permissions"
                :key="index"
              >
                <h6 class="text-capitalize mb-1">{{ item.name }}</h6>
                <div class="border h-100 p-2">
                  <div
                    v-for="(permission, indexPermission) in item.permissions"
                    :key="`permission-${indexPermission}`"
                  >
                    <label
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
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-end">
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
  </div>
</template>

<script>
import Layout from "@/Layouts/Main.vue";
import ButtonAction from "@/Components/Global/Form/ButtonAction.vue";

export default {
  layout: Layout,
  components: {
    ButtonAction,
  },

  props: {
    resource: {
      type: Object,
      required: true,
    },
    savedPermissions: Array,
    permissions: [Array, Object],
  },

  data() {
    return {
      form: {
        permissions: this.savedPermissions,
        _method: "PUT",
      },
      loading: false,
    };
  },

  methods: {
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
