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
      <el-main style>
        <div class="app-full">
          <el-row>
            <el-col :span="3" v-show="showMenu">
              <el-menu :default-active="$route.path" :router="true" ref="menu" class="el-menu">
                <el-menu-item :index="item.route" v-for="item in myRoute" :key="item.id">
                  <span slot="title">{{ item.title }}</span>
                </el-menu-item>
              </el-menu>
            </el-col>

            <el-col :span="showMenu ? 21 : 24">
              <transition name="el-fade-in-linear" mode="out-in" appear>
                <router-view></router-view>
              </transition>
            </el-col>
          </el-row>
        </div>
      </el-main>
    </el-container>
  </div>
</template>

<script>
import TopBar from "./components/common/topBar";

export default {
  name: "app",
  created() {},
  computed: {
    myRoute: function () {
      let route = [
        {
          title: "项目列表",
          route: "/projectList",
          icon: "el-icon-s-fold",
        },
      ];

      if (this.$store.state.userInfo && this.$store.state.userInfo.type > 1) {
        route.push({
          title: "用户管理",
          route: "/userManager",
          icon: "el-icon-user",
        });
      }

      return route;
    },
    showMenu: function () {
      if (
        this.$route.params.projectId &&
        this.$route.params.projectId == this.$store.state.project.id
      ) {
        return false;
      }

      return true;
    },
  },
  components: {
    topBar: TopBar,
  },
};
</script>


<style>
@import "../public/css/normalize.css";

html,
body,
#app {
  height: 100%;
}

#app {
  font-family: "Helvetica Neue", Helvetica, "PingFang SC", "Hiragino Sans GB",
    "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  /* background-color: #F6F6F6; */
  /* background-color: #F8F8F5; */
  /* background-color: #F6F5F0; */
}

.app-full {
  margin: 0 auto;
  min-height: 700px;
}
</style>
