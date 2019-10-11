<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-11 09:14:00
 * @LastEditTime: 2019-10-11 09:22:19
 * @LastEditors: Please set LastEditors
 -->
<template>
  <div id="app">
    <div>
        <router-link to="/api">test</router-link>
      <project />
    </div>
    <div class="content">
     <router-view></router-view>
    </div>
  </div>
</template>

<script>
import project from "./viewPage/project";

export default {
  name: "app",
  components: {
    project
  }
};
</script>

<style>
@import 'static/css/base.css';

#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
