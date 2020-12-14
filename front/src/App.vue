<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-11 09:14:00
 * @LastEditTime: 2019-10-11 09:22:19
 * @LastEditors: Please set LastEditors
 -->
<template>
  <div id="app">
    <el-container style="height:100%">
      <el-header style="padding:0">
        <topBar />
      </el-header>
      <el-main>
        <router-view></router-view>
      </el-main>
    </el-container>
  </div>
</template>

<script>
import TopBar from "@/components/common/topBar";
export default {
  name: "app",
  components: {
    topBar: TopBar,
  },
};
</script>


<style>
@import "../public/css/normalize.css";

#app {
  font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB",
    "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* background-color: #F6F6F6; */
  /* background-color: #F8F8F5; */
  /* background-color: #F6F5F0; */
}
</style>
