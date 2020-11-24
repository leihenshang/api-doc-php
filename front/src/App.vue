<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-11 09:14:00
 * @LastEditTime: 2019-10-11 09:22:19
 * @LastEditors: Please set LastEditors
 -->
<template>
  <div id="app">
              <div class="top">
      <topBar />
    </div>
    <transition name="el-fade-in-linear" mode="out-in" appear>
      <div class="app-full">
      <router-view></router-view>
      </div>
    </transition>
  </div>
</template>

<script>

import TopBar from "./components/common/topBar";

export default {
  name: "app",
  created() {},
   components: {
    topBar: TopBar
  },
};
</script>


<style>
@import "static/css/base.css";

#app {
  font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB",
    "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  width: 100%;
  height: 100%;
}

.app-full {
  width:85%;
  margin:0 auto;
}

</style>
