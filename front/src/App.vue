<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-11 09:14:00
 * @LastEditTime: 2019-10-11 09:22:19
 * @LastEditors: Please set LastEditors
 -->
<template>
  <div id="app">
    <el-container>
      <el-header style="padding:0">
        <topBar />
      </el-header>
      <el-main style="padding:0 0 40px 0;">
        <transition name="el-fade-in-linear" mode="out-in" appear>
          <div class="app-full">
            <router-view></router-view>
          </div>
        </transition>
      </el-main>
      <el-footer style="padding:0">
        <bottomBar />
      </el-footer>
    </el-container>
  </div>
</template>

<script>
import TopBar from "./components/common/topBar";
import BottomBar from "./components/common/bottomBar";

export default {
  name: "app",
  created() {},
  computed: {},
  components: {
    topBar: TopBar,
    bottomBar: BottomBar,
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
}

.app-full {
  width: 85%;
  margin: 0 auto;
  min-height: 800px;
}
</style>
