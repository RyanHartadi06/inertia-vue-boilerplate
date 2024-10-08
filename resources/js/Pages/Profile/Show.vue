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
        <div class="col-xxl-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-center mb-4">
                <img
                  :src="$page.props.auth.user.avatar || '/images/logo.png'"
                  alt="user-img"
                  class="rounded-circle w-36 h-36"
                />
              </div>

              <div class="d-flex align-items-center mt-2">
                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                  <div
                    class="avatar-title bg-light rounded-circle fs-16 text-primary"
                  >
                    <i class="ri-user-2-fill"></i>
                  </div>
                </div>
                <h6 class="text-truncate mb-0">
                  {{ resource.name }}
                </h6>
              </div>

              <div class="d-flex align-items-center mt-2">
                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                  <div
                    class="avatar-title bg-light rounded-circle fs-16 text-primary"
                  >
                    <i class="ri-mail-fill"></i>
                  </div>
                </div>
                <h6 class="text-truncate mb-0">
                  {{ resource.email }}
                </h6>
              </div>
              <div class="d-flex align-items-center mt-2">
                <div class="flex-shrink-0 avatar-xs align-self-center me-3">
                  <div
                    class="avatar-title bg-light rounded-circle fs-16 text-primary"
                  >
                    <i class="ri-shield-user-fill"></i>
                  </div>
                </div>
                <h6 class="text-truncate mb-0">
                  {{ resource.roles[0].name }}
                </h6>
              </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-9">
          <div class="card">
            <div class="card-header align-items-center d-flex">
              <h5 class="card-title mb-0">About</h5>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Name</div>
                <div class="col-sm-9">: {{ resource.name }}</div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Email</div>
                <div class="col-sm-9">: {{ resource.email }}</div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Username</div>
                <div class="col-sm-9">: {{ resource.username }}</div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Roles</div>
                <div class="col-sm-9">
                  <div class="d-flex align-items-center">
                    :
                    <span
                      v-for="role in resource.roles"
                      :key="role.id"
                      class="badge bg-primary-subtle text-primary mx-1"
                    >
                      {{ role.name }}
                    </span>
                  </div>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Last update</div>
                <div class="col-sm-9">
                  :
                  {{ moment(resource.updated_at).format("DD MMMM YYYY HH:mm") }}
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Permission List</div>
                <div class="col-sm-9">
                  <div class="d-flex">
                    :
                    <div>
                      <div
                        v-for="permission in resource.roles[0].permissions"
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
