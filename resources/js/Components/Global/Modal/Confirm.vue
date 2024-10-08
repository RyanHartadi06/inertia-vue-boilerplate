<template>
  <div :id="content.modalId || 'modal-confirm'" class="modal-block mfp-hide">
    <section class="card">
      <header class="card-header">
        <h2 class="card-title">{{ content.title }}</h2>
      </header>
      <div class="card-body">
        {{ content.description }}
      </div>
      <footer class="card-footer">
        <div class="d-flex justify-content-end">
          <button class="btn btn-sm btn-default me-2" @click="closeModal()">
            Batal
          </button>
          <button
            class="btn btn-sm btn-primary"
            :class="content.modalId || 'modal-confirm'"
            @click="action()"
          >
            {{ content.action }}
          </button>
        </div>
      </footer>
    </section>
  </div>
</template>

<script>
export default {
  props: {
    content: Object,
    data: [Object, Array],
  },
  methods: {
    action() {
      this.$emit("confirmed", this.content, this.data);
      this.closeModal();
    },
    closeModal() {
      $.magnificPopup.close();
    },
  },
};
</script>
