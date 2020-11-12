<template>
  <div class="bottom">
    <p>From my api-doc</p>
  </div>
</template>

<script>
export default {
  name: "homeFooter"
};
</script>

<style scoped>
/* 底部开始 */
.bottom {
  height: 50px;
  border-top: 1px solid #e5e5e5;
  background-color: #f1f1f1;
  width: 100%;
  position: fixed;
  bottom: 0;
  line-height: 50px;
}

.bottom p {
  font-size: 14px;
  text-align: center;
}
</style>