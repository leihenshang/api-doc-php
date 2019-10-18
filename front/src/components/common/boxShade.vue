<template>
  <div class="box-shade">
    <span>等待加载 。。。</span>
  </div>
</template>

<script>
export default {
  name: "boxShade",
  props: {},
  computed: {},
  methods: {},
  data: function() {
    return {};
  },
  watch: {}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.box-shade {
  width: 100%;
  height: 100%;
  background-color: rgba(94, 88, 88, 0.2);
  position: absolute;
}

.box-shade span {
  position: absolute;
  background-color: #fff;
  height: 100px;
  width: 200px;
  line-height: 100px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
