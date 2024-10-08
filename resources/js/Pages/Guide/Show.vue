<script setup>
import Layout from "@/Layouts/Main.vue";

defineProps({
  resource: Object,
});
</script>

<template>
  <Layout>
    <div>
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div
              class="card-header align-items-center d-flex justify-content-between"
            >
              <h5 class="card-title mb-0">Panduan</h5>

              <div class="d-flex">
                <Link
                  :href="route('guides.edit', resource.id)"
                  class="btn btn-sm btn-success d-flex align-items-center me-1"
                >
                  <i class="ri-pencil-line me-1"></i>
                  Edit</Link
                >
                <Link
                  :href="route('guides.index')"
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
                <div class="col-sm-3 text-muted">Deskripsi</div>
                <div class="col-sm-9">: {{ resource.description || "-" }}</div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">File</div>
                <div class="col-sm-9">
                  :
                  <a
                    :href="resource.file_url || '#'"
                    target="_blank"
                    class="text-primary text-decoration-none"
                  >
                    {{ resource.file || "no-file" }}
                  </a>
                </div>
              </div>
              <div class="row mb-2">
                <div class="col-sm-3 text-muted">Last update</div>
                <div class="col-sm-9">
                  :
                  {{ moment(resource.updated_at).format("DD MMMM YYYY HH:mm") }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
