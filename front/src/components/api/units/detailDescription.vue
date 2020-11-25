<template>
  <div class="detail-description">
    <div class="description">
      <div class="item-head">
        <button class="req-btn req-btn-first">说明</button>
      </div>
      <textarea name id cols="30" rows="10" v-model="newDescription"></textarea>
    </div>
  </div>
</template>

<script>
export default {
  name: "detailDescription",
  props: {
    description: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      newDescription: this.description,
    };
  },
  watch: {
    newDescription: function (val) {
      this.$emit("update", val);
    },
    description: function () {
      this.newDescription = this.description;
    },
  },
};
</script>

<style scoped>
.description {
  padding-top: 10px;
}

.description textarea {
  width: 100%;
  height: 100%;
  border-radius: 5px;
  resize: none;
  outline: none;
  border: 1px solid rgb(204, 203, 203);
}
</style>