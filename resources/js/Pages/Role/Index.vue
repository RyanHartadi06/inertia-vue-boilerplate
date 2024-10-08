<template>
  <div>
    <div class="row">
      <div class="col-lg-12">
        <section class="card">
          <div class="card-header">
            <div class="d-flex align-items-center">
              <h5 class="card-title mb-0 flex-grow-1">
                {{ $page.props.title }}
              </h5>
              <div class="flex-shrink-0"></div>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive fixed-solution">
              <table class="table table-striped table-hover border">
                <thead>
                  <tr>
                    <table-header-column label="No" :enable-sorting="false" />
                    <table-header-column label="Nama" :enable-sorting="false" />
                    <table-header-column
                      label="Users"
                      :enable-sorting="false"
                    />
                    <table-header-column
                      label="Permissions"
                      :enable-sorting="false"
                    />
                    <table-header-column
                      label="Aksi"
                      :enable-sorting="false"
                      :alignCenter="true"
                    />
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in resources" :key="index">
                    <td>
                      <Link
                        :href="route('roles.show', item.id)"
                        class="text-dark text-decoration-none"
                        >{{ index + 1 }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('roles.show', item.id)"
                        class="text-dark text-decoration-none"
                      >
                        {{ item.name }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('roles.show', item.id)"
                        class="text-dark text-decoration-none"
                        >{{ item.users.length }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('roles.show', item.id)"
                        class="text-dark text-decoration-none"
                        >{{
                          item.name === "SUPER ADMIN"
                            ? "All"
                            : item.permissions.length
                        }}
                      </Link>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <Link
                          :href="route('roles.show', item.id)"
                          class="bg-primary rounded px-1 me-1"
                          title="Lihat detail"
                          ><i class="ri-eye-fill text-white"></i
                        ></Link>
                        <Link
                          v-if="item.name !== 'SUPER ADMIN'"
                          :href="route('roles.edit', item.id)"
                          class="bg-warning rounded px-1"
                          title="Edit"
                          ><i class="ri-pencil-fill text-white"></i
                        ></Link>
                      </div>
                    </td>
                  </tr>
                  <tr v-if="resources.length === 0">
                    <td colspan="5" class="text-center">
                      <span class="text-muted fst-italic">Tidak ada data</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import Main from "@/Layouts/Main.vue";
import TableHeaderColumn from "@/Components/Global/Table/TableHeaderColumn.vue";

export default {
  layout: Main,
  components: {
    TableHeaderColumn,
  },
  props: {
    title: String,
    resources: Object,
  },
  data() {
    return {
      key: 1,
    };
  },
  watch: {
    query: {
      // eslint-disable-next-line func-names
      handler() {
        this.handleQueryChange();
      },
      deep: true,
    },
  },
  methods: {},
};
</script>
