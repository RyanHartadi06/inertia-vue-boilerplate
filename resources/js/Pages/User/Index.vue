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
            <div class="row mb-3">
              <slot name="filter" :query="query" :filters="filters">
                <filter-panel
                  class="col-sm-2 pb-1"
                  v-model="query"
                  :filters="filters"
                />
              </slot>

              <div class="col-sm-10">
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
                    <table-header-column :enable-sorting="false" />
                    <table-header-column
                      label="Nama"
                      :enable-sorting="true"
                      sorting-key="name"
                      :query-sort="query.sort"
                      :query-order="query.order"
                      @sort="sort"
                    />
                    <table-header-column
                      label="Email"
                      :enable-sorting="true"
                      sorting-key="email"
                      :query-sort="query.sort"
                      :query-order="query.order"
                      @sort="sort"
                    />
                    <table-header-column
                      label="Username"
                      :enable-sorting="true"
                      sorting-key="username"
                      :query-sort="query.sort"
                      :query-order="query.order"
                      @sort="sort"
                    />
                    <table-header-column
                      label="Roles"
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
                  <tr v-for="(item, index) in resources.data" :key="index">
                    <td>
                      <Link
                        :href="route('users.show', item.id)"
                        class="text-dark text-decoration-none"
                        >{{ rowNumber(index) }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('users.show', item.id)"
                        class="text-dark text-decoration-none"
                        ><img
                          :src="item.avatar || '/images/logo.png'"
                          alt="user-img"
                          class="rounded-circle w-8 h-8"
                        />
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('users.show', item.id)"
                        class="text-dark text-decoration-none"
                      >
                        {{ item.name }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('users.show', item.id)"
                        class="text-dark text-decoration-none"
                        >{{ item.email || "-" }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('users.show', item.id)"
                        class="text-dark text-decoration-none"
                        >{{ item.username || "-" }}
                      </Link>
                    </td>
                    <td>
                      <Link
                        :href="route('users.show', item.id)"
                        class="text-dark text-decoration-none d-flex"
                      >
                        <span
                          v-for="role in item.roles"
                          :key="role.id"
                          class="badge bg-primary-subtle text-primary mx-1"
                        >
                          {{ role.name }}
                        </span>
                      </Link>
                    </td>
                    <td>
                      <div class="d-flex justify-content-center">
                        <Link
                          :href="route('users.show', item.id)"
                          class="bg-primary rounded px-1 me-1"
                          title="Detail"
                          ><i class="ri-eye-fill text-white"></i
                        ></Link>
                        <Link
                          :href="route('users.edit', item.id)"
                          class="bg-warning rounded px-1"
                          title="Edit"
                          ><i class="ri-pencil-fill text-white"></i
                        ></Link>
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
              :links="links"
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
import axios from "axios";

export default {
  layout: Main,
  components: {
    FilterPanel,
    TableHeaderColumn,
    Search,
    Pagination,
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
    links: {
      type: Array,
      default: () => [],
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
  },
};
</script>
