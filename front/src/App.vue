<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-11 09:14:00
 * @LastEditTime: 2019-10-11 09:22:19
 * @LastEditors: Please set LastEditors
 -->
<template>
  <div id="app">
    <transition name="el-fade-in-linear"  mode="out-in" appear>
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
export default {
  name: "app",
  created() {}
};
</script>


<style>
@import "static/css/base.css";

#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  width: 100%;
  height: 100%;
}
</style>
