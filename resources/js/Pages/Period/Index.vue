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
              <div class="flex-shrink-0">
                <button
                  class="btn btn-primary waves-effect waves-light d-flex align-items-center justify-content-center w-100"
                  type="button"
                  @click="$inertia.get(route('periods.create'))"
                >
                  <i class="ri-add-fill"></i> Tambah
                </button>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-sm-12">
                <search
                  :query="query"
                  @changePerPage="changePerPage"
                  @changeSearch="changeSearch"
                />
              </div>
            </div>

            <div class="table-responsive fixed-solution">
              <table class="table table-striped table-hover border">
                <thead>
                  <tr>
                    <table-header-column label="No" :enable-sorting="false" />
                    <table-header-column
                      label="Tahun"
                      :enable-sorting="true"
                      sorting-key="year"
                      :query-sort="query.sort"
                      :query-order="query.order"
                      @sort="sort"
                    />
                    <table-header-column
                      label="Bobot Direksi"
                      :enable-sorting="true"
                      sorting-key="direction_weight"
                      :query-sort="query.sort"
                      :query-order="query.order"
                      @sort="sort"
                    />
                    <table-header-column
                      label="Bobot User"
                      :enable-sorting="true"
                      sorting-key="weight"
                      :query-sort="query.sort"
                      :query-order="query.order"
                      @sort="sort"
                    />
                    <table-header-column
                      label="Status"
                      :enable-sorting="true"
                      sorting-key="status"
                      :query-sort="query.sort"
                      :query-order="query.order"
                      @sort="sort"
                    />
                    <table-header-column
                      label="Aksi"
                      :enable-sorting="false"
                      :alignCenter="true"
                    />
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, index) in resources.data" :key="index">
                    <td>
                      <Link
                        :href="route('periods.edit', item.id)"
                        class="text-dark text-decoration-none"
                        >{{ rowNumber(index) }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('periods.edit', item.id)"
                        class="text-dark text-decoration-none"
                      >
                        {{ item.year }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('periods.edit', item.id)"
                        class="text-dark text-decoration-none"
                        >{{ item.direction_weight || "-" }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('periods.edit', item.id)"
                        class="text-dark text-decoration-none"
                        >{{ item.weight || "-" }}
                      </Link>
                    </td>
                    <td>
                      <switch-input
                        class="mt-n4"
                        :id="`status-${item.id}`"
                        v-model="item.status"
                        :true-value="1"
                        :placeholder="item.status ? 'Aktif' : 'Tidak Aktif'"
                        @input="updateStatus(item, index)"
                      />
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <Link
                          :href="route('periods.edit', item.id)"
                          class="bg-warning rounded px-1 me-1"
                          title="Lihat detail"
                          ><i class="ri-pencil-fill text-white"></i
                        ></Link>
                        <a
                          href="#"
                          @click="confirmDelete(item.id)"
                          class="bg-danger rounded px-1"
                          title="Delete"
                          ><i class="ri-delete-bin-fill text-white"></i
                        ></a>
                      </div>
                    </td>
                  </tr>
                  <tr v-if="resources.total === 0">
                    <td colspan="6" class="text-center">
                      <span class="text-muted fst-italic">Tidak ada data</span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination
              :links="resources.links"
              :total="resources.total"
              :to="resources.to"
              :from="resources.from"
              :per-page-options="[10, 20, 50, 100]"
              @changePerPage="changePerPage"
            />
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import Main from "@/Layouts/Main.vue";
import FilterPanel from "@/Components/Global/Table/Filter/FilterPanel.vue";
import TableHeaderColumn from "@/Components/Global/Table/TableHeaderColumn.vue";
import Search from "@/Components/Global/Table/Search.vue";
import Pagination from "@/Components/Global/Table/Pagination.vue";
import SwitchInput from "@/Components/Global/Form/SwitchInput.vue";
import Swal from "sweetalert2";

export default {
  layout: Main,
  components: {
    FilterPanel,
    TableHeaderColumn,
    Search,
    Pagination,
    SwitchInput,
  },
  props: {
    title: String,
    resources: Object,
    filters: {
      type: Array,
      default: () => [],
    },
    requestQuery: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      query: {
        search: this.requestQuery.search,
        page: this.requestQuery.page,
        per_page: this.requestQuery.per_page,
        sort: this.requestQuery.sort,
        order: this.requestQuery.order,
      },
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
  methods: {
    sort(sort, order) {
      this.query.sort = sort;
      this.query.order = order;
      this.handleQueryChange();
    },
    handleQueryChange() {
      this.$inertia.visit(window.location.pathname, {
        data: this.query,
        replace: true,
        preserveScroll: true,
        preserveState: true,
      });
    },
    changePerPage(perPage) {
      this.query.per_page = perPage;
      this.query.page = 1;
      this.handleQueryChange();
    },
    changeSearch(search) {
      this.query.search = search;
      this.query.page = 1;
      this.handleQueryChange();
    },
    rowNumber(index) {
      const newIndex = Number(index);
      return (
        this.requestQuery.page * this.requestQuery.per_page -
        this.requestQuery.per_page +
        1 +
        newIndex
      );
    },
    updateStatus(item, index) {
      this.$inertia.put(
        route("periods.update-status", item.id),
        {
          status: item.status == 1 ? "0" : "1",
        },
        {
          preserveScroll: true,
          preserveState: false,
        }
      );
    },
    confirmDelete(id) {
      Swal.fire({
        title: "Apakah Anda Yakin ?",
        text: "Data akan dihapus",
        type: "danger",
        icon: "warning",
        showCancelButton: true,
        cancelButtonText: "Batal",
        cancelButtonColor: "#E64B3C",
        confirmButtonText: "Ya, Hapus",
        confirmButtonColor: "#2889F6",
      }).then((result) => {
        if (result.isConfirmed) {
          this.$inertia.post(
            route("periods.destroy", id),
            {
              _method: "DELETE",
            },
            {
              preserveScroll: false,
              preserveState: false,
            }
          );
        }
      });
    },
  },
};
</script>
