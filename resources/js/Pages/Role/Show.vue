<script setup>
import Layout from "@/Layouts/Main.vue";

defineProps({
  resource: Object,
});
</script>

<template>
  <Layout title="Profile">
    <div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div
              class="card-header align-items-center d-flex justify-content-between"
            >
              <h5 class="card-title mb-0">Role</h5>

              <div class="d-flex">
                <Link
                  v-if="resource.name !== 'SUPER ADMIN'"
                  :href="route('roles.edit', resource.id)"
                  class="btn btn-sm btn-success d-flex align-items-center me-1"
                >
                  <i class="ri-pencil-line me-1"></i>
                  Edit</Link
                >
                <Link
                  :href="route('roles.index')"
                  class="btn btn-sm btn-secondary d-flex align-items-center"
                >
                  <i class="ri-arrow-left-s-line me-1"></i>
                  Kembali</Link
                >
              </div>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Name</div>
                <div class="col-sm-9">: {{ resource.name }}</div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Users</div>
                <div class="col-sm-9">: {{ resource.users.length }}</div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Permissions</div>
                <div class="col-sm-9">
                  :
                  {{
                    resource.name === "SUPER ADMIN"
                      ? "All"
                      : resource.permissions.length
                  }}
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Permission List</div>
                <div class="col-sm-9">
                  <div class="d-flex">
                    :
                    <div>
                      <div
                        v-for="permission in resource.permissions"
                        :key="permission.id"
                        class="badge bg-primary-subtle text-primary mx-1"
                      >
                        {{ permission.name }}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
