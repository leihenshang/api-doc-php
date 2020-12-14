<template>
  <div class="home-container">
    <el-container style="height:100%">
      <el-header style="padding:0">
        <topBar />
      </el-header>
      <el-main>
        <div class="app-full">
          <el-row :gutter="15">
            <el-col :span="3" style="padding-right:5px;">
              <el-menu :default-active="$route.path" :router="true" ref="menu" class="el-menu">
                <el-menu-item :index="item.route" v-for="item in myRoute" :key="item.id">
                  <span slot="title">{{ item.title }}</span>
                </el-menu-item>
              </el-menu>
            </el-col>

            <el-col :span=" 21">
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
import TopBar from "@/components/common/topBar";

export default {
  name: "home",
  components: {
    topBar: TopBar,
  },
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

      if (this.$store.state.userInfo.id) {
        return route;
      }

      return [];
    },
  },
};
</script>
<style lang="scss" scoped>
</style>