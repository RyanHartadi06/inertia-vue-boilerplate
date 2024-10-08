<script>
import { Link, Head } from "@inertiajs/vue3";
export default {
  components: {
    Link,
    Head,
  },
  props: {
    message: {
      type: String,
      default: "Error",
    },
    status: {
      type: [String, Number],
      default: "Error",
    },
  },
  computed: {
    description() {
      return {
        503: "503: Service Unavailable",
        500: "500: Server Error",
        404: "404: Page Not Found",
        403: "403: Forbidden",
      }[this.status];
    },
  },
};
</script>

<template>
  <Head title="404" />
  <div class="auth-page-wrapper pt-5">
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
      <div class="bg-overlay"></div>
      <div class="shape">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          version="1.1"
          xmlns:xlink="http://www.w3.org/1999/xlink"
          viewBox="0 0 1440 120"
        >
          <path
            d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"
          ></path>
        </svg>
      </div>
    </div>

    <div class="auth-page-content">
      <BContainer>
        <BRow>
          <BCol lg="12">
            <div class="text-center pt-4">
              <div class="">
                <img
                  src="@assets/images/error.svg"
                  alt=""
                  class="error-basic-img move-animation"
                />
              </div>
              <div class="mt-n4">
                <h1 class="display-1 fw-medium">{{ status }}</h1>
                <h3 class="text-uppercase">{{ message }}</h3>
                <p class="text-muted mb-4">{{ description }}</p>
                <Link href="/" class="btn btn-secondary"
                  ><i class="mdi mdi-home me-1"></i>Back to home</Link
                >
              </div>
            </div>
          </BCol>
        </BRow>
      </BContainer>
    </div>
  </div>
</template>