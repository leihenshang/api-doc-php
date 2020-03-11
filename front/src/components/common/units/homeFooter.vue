<template>
  <div class="bottom">
    <p>该开源网站由api doc提供技术支持，开源协议遵循MIT，如需获取最新的api doc开源版以及相关资讯，请点击这里</p>
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