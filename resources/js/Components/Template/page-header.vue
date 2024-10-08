<script>
export default {
  components: {},
};
</script>



<template>
  <BRow>
    <BCol cols="12">
      <div
        class="page-title-box d-sm-flex align-items-center justify-content-between"
      >
        <h6 class="mb-sm-0"></h6>
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item">
              <a href="javascript: void(0);">{{ $page.props.pageTitle }}</a>
            </li>
            <li class="breadcrumb-item active">{{ $page.props.title }}</li>
          </ol>
        </div>
      </div>
    </BCol>
  </BRow>
</template>
