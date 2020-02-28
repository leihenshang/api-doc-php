<template>
  <div class="detail-description">
    <div class="description">
      <textarea name id cols="30" rows="10" v-model="description"></textarea>
    </div>
  </div>
</template>

<script>
export default {
  name: "detailDescription",
  data() {
    return {
      description: ""
    };
  },
  watch: {
    description: function(val) {
      this.$emit("update", val);
    }
  }
};
</script>

<style scoped>
.description textarea {
  width: 100%;
  height: 100%;
  border-radius: 5px;
  resize: none;
  outline: none;
  border: 1px solid rgb(204, 203, 203);
}
</style>