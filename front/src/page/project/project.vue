<template>
  <div class="detail">
    <el-menu
      mode="horizontal"
      :default-active="
          $route.redirectedFrom ? $route.redirectedFrom : $route.path
        "
      :router="true"
      ref="menu"
      class="el-menu"
    >
      <el-menu-item :index="item.route" v-for="item in insideRoute" :key="item.id">
        <i :class="item.icon ? item.icon : 'el-icon-setting'"></i>
        <span slot="title">{{ item.title }}</span>
      </el-menu-item>
    </el-menu>
    <transition name="el-fade-in-linear" mode="out-in" appear>
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
export default {
  name: "project",
  props: {
    id: String,
  },
  created() {},
  data() {
    let menu = [
      {
        title: "项目概况",
        route: "/detail/" + this.$route.params.id,
        icon: "el-icon-s-platform",
      },
      {
        title: "API接口",
        route: "/detail/" + this.$route.params.id + "/apiPage",
        icon: "el-icon-s-promotion",
      },
      {
        title: "文档",
        route: "/detail/" + this.$route.params.id + "/projectDoc",
        icon: "el-icon-reading",
      },

      {
        title: "BUG管理",
        route: "/detail/" + this.$route.params.id + "/bugHome",
        icon: "el-icon-sort",
      },
    ];

    let mmanagerMenu = [
      {
        title: "字段映射",
        route: "/detail/" + this.$route.params.id + "/fieldMapping",
        icon: "el-icon-coin",
      },
      {
        title: "成员管理",
        route: "/detail/" + this.$route.params.id + "/members",
        icon: "el-icon-user",
      },
    ];

    //如果不是普通用户，加入管理菜单
    if (this.$store.state.userInfo.type != 1) {
      menu.push(...mmanagerMenu);
    }

    return {
      projectData: {},
      insideRoute: menu,
    };
  },
  methods: {},
  components: {},
};
</script>

<style lang="scss" scoped>
</style>
