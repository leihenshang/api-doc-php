<template>
  <div id="app">
    <div>
      <router-link to="/toProject">进入项目首页</router-link>
      <button @click="jump">Button-跳转到购物车页面</button>
    </div>
    <div class="content"></div>
  </div>
</template>

<script>
export default {
  name: "app",
  methods: {
    jump() {
      //this.$router.push("/cart")
      //传递的参数用{{ $route.query.goodsId }}获取
      this.$router.push({ path: "/project" });
      //this.$router.go(-2)
      //后退两步
    }
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
