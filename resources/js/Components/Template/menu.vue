<script>
import { layoutComputed } from "@/state/helpers";
import simplebar from "simplebar-vue";
import SidebarMixin from "@/Mixins/Sidebar.js";
import AuthMixin from "@/Mixins/AuthMixin.js";

export default {
  mixins: [SidebarMixin, AuthMixin],
  components: {
    simplebar,
  },
  data() {
    return {
      menus: [
        {
          label: "Dashboard",
          key: "dashboard",
          routeName: "dashboard",
          authorized: true,
          icon: "ri-dashboard-2-line",
          topTitle: {
            label: "Main Menu",
            key: "title-menu",
          },
        },
        {
          label: "User",
          key: "user",
          routeName: "users.index",
          authorized: this.authCan("view users"),
          icon: "ri-user-line",
          topTitle: {
            label: "Authentication",
            key: "title-auth",
          },
        },
        {
          label: "Role",
          key: "role",
          routeName: "roles.index",
          authorized: this.authCan("view roles"),
          icon: "ri-shield-user-line",
        },
        {
          label: "Master Data KPI",
          key: "master",
          authorized: this.authCan("view periods"),
          icon: "ri-settings-3-line",
          topTitle: {
            label: "Performance Management",
            key: "title-performance-management",
          },
          children: [
            {
              label: "Periode",
              key: "period",
              routeName: "periods.index",
              authorized: this.authCan("view periods"),
              icon: "ri-calendar-2-line",
            },
            {
              label: "Satuan",
              key: "unit",
              routeName: "indicator-units.index",
              authorized: this.authCan("view indicator units"),
              icon: "ri-stack-line",
            },
            {
              label: "Panduan",
              key: "guide",
              routeName: "guides.index",
              authorized: this.authCan("view guides"),
              icon: "ri-book-read-line",
            },
          ],
        },
      ],
    };
  },
  computed: {
    ...layoutComputed,
    layoutType: {
      get() {
        return this.$store ? this.$store.state.layout.layoutType : {} || {};
      },
    },
  },
  mounted() {
    this.initActiveMenu();
    this.onRoutechange();
    if (document.querySelectorAll(".navbar-nav .collapse")) {
      let collapses = document.querySelectorAll(".navbar-nav .collapse");

      collapses.forEach((collapse) => {
        // Hide sibling collapses on `show.bs.collapse`
        collapse.addEventListener("show.bs.collapse", (e) => {
          e.stopPropagation();
          let closestCollapse = collapse.parentElement.closest(".collapse");
          if (closestCollapse) {
            let siblingCollapses =
              closestCollapse.querySelectorAll(".collapse");
            siblingCollapses.forEach((siblingCollapse) => {
              if (siblingCollapse.classList.contains("show")) {
                siblingCollapse.classList.remove("show");
                siblingCollapse.parentElement.firstChild.setAttribute(
                  "aria-expanded",
                  "false"
                );
              }
            });
          } else {
            let getSiblings = (elem) => {
              // Setup siblings array and get the first sibling
              let siblings = [];
              let sibling = elem.parentNode.firstChild;
              // Loop through each sibling and push to the array
              while (sibling) {
                if (sibling.nodeType === 1 && sibling !== elem) {
                  siblings.push(sibling);
                }
                sibling = sibling.nextSibling;
              }
              return siblings;
            };
            let siblings = getSiblings(collapse.parentElement);
            siblings.forEach((item) => {
              if (item.childNodes.length > 2) {
                item.firstElementChild.setAttribute("aria-expanded", "false");
                item.firstElementChild.classList.remove("active");
              }
              let ids = item.querySelectorAll("*[id]");
              ids.forEach((item1) => {
                item1.classList.remove("show");
                item1.parentElement.firstChild.setAttribute(
                  "aria-expanded",
                  "false"
                );
                item1.parentElement.firstChild.classList.remove("active");
                if (item1.childNodes.length > 2) {
                  let val = item1.querySelectorAll("ul li a");

                  val.forEach((subitem) => {
                    if (subitem.hasAttribute("aria-expanded"))
                      subitem.setAttribute("aria-expanded", "false");
                  });
                }
              });
            });
          }
        });

        // Hide nested collapses on `hide.bs.collapse`
        collapse.addEventListener("hide.bs.collapse", (e) => {
          e.stopPropagation();
          let childCollapses = collapse.querySelectorAll(".collapse");
          childCollapses.forEach((childCollapse) => {
            let childCollapseInstance = childCollapse;
            childCollapseInstance.classList.remove("show");
            childCollapseInstance.parentElement.firstChild.setAttribute(
              "aria-expanded",
              "false"
            );
          });
        });
      });
    }
  },

  methods: {
    onRoutechange() {
      // this.initActiveMenu();
      setTimeout(() => {
        var currentPath = window.location.pathname;
        if (document.querySelector("#navbar-nav")) {
          let currentPosition = document
            .querySelector("#navbar-nav")
            .querySelector('[href="' + currentPath + '"]')?.offsetTop;
          if (currentPosition > document.documentElement.clientHeight) {
            document.querySelector("#scrollbar .simplebar-content-wrapper")
              ? (document.querySelector(
                  "#scrollbar .simplebar-content-wrapper"
                ).scrollTop =
                  currentPosition + document.documentElement.clientHeight / 2)
              : "";
          }
        }
      }, 500);
    },

    initActiveMenu() {
      setTimeout(() => {
        var currentPath = window.location.pathname;
        if (document.querySelector("#navbar-nav")) {
          let a = document
            .querySelector("#navbar-nav")
            .querySelector('[href="' + currentPath + '"]');
          if (a) {
            a.classList.add("active");
            let parentCollapseDiv = a.closest(".collapse.menu-dropdown");
            if (parentCollapseDiv) {
              parentCollapseDiv.classList.add("show");
              parentCollapseDiv.parentElement.children[0].classList.add(
                "active"
              );
              parentCollapseDiv.parentElement.children[0].setAttribute(
                "aria-expanded",
                "true"
              );
              if (
                parentCollapseDiv.parentElement.closest(
                  ".collapse.menu-dropdown"
                )
              ) {
                parentCollapseDiv.parentElement
                  .closest(".collapse")
                  .classList.add("show");
                if (
                  parentCollapseDiv.parentElement.closest(".collapse")
                    .previousElementSibling
                )
                  parentCollapseDiv.parentElement
                    .closest(".collapse")
                    .previousElementSibling.classList.add("active");
                const grandparent = parentCollapseDiv.parentElement
                  .closest(".collapse")
                  .previousElementSibling.parentElement.closest(".collapse");
                if (
                  grandparent &&
                  grandparent &&
                  grandparent.previousElementSibling
                ) {
                  grandparent.previousElementSibling.classList.add("active");
                  grandparent.classList.add("show");
                }
              }
            }
          }
        }
      }, 0);
    },
  },
};
</script>

<template>
  <BContainer fluid>
    <div id="two-column-menu"></div>

    <ul class="navbar-nav h-100" id="navbar-nav">
      <template v-for="(item, index) in navItems" :key="index">
        <li v-if="item.topTitle" class="menu-title">
          <i class="ri-more-fill" aria-expanded="false"></i>
          <span :data-key="`t-${item.topTitle.key}`">
            {{ item.topTitle.label }}
          </span>
        </li>
        <li
          class="nav-item"
          :class="{
            'text-primary': item.isActive,
          }"
        >
          <Link
            class="nav-link menu-link"
            :href="route(item.routeName)"
            v-if="item.authorized && !item.children"
          >
            <i :class="item.icon"></i>
            <span :data-key="`t-${item.key}`"> {{ item.label }}</span>
          </Link>
          <a
            class="nav-link menu-link"
            :href="`#${item.key}`"
            data-bs-toggle="collapse"
            role="button"
            aria-expanded="false"
            :aria-controls="item.key"
            v-else-if="item.authorized"
          >
            <i :class="item.icon"></i>
            <span :data-key="`t-${item.key}`"> {{ item.label }}</span>
          </a>

          <div
            v-if="item.authorized && item.children && item.children.length"
            class="collapse menu-dropdown"
            :id="item.key"
          >
            <ul class="nav nav-sm flex-column">
              <li
                class="nav-item"
                v-for="(itemChild, indexChild) in item.children"
                :key="indexChild"
              >
                <Link
                  :href="route(itemChild.routeName)"
                  class="nav-link"
                  :data-key="`t-${item.key}`"
                >
                  <i :class="itemChild.icon"></i>
                  <span :data-key="`t-${itemChild.key}`">
                    {{ itemChild.label }}</span
                  >
                </Link>
              </li>
            </ul>
          </div>
        </li></template
      >
    </ul>
  </BContainer>
</template>