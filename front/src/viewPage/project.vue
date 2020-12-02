<template>
  <div class="detail">
    <div class="middle-menu">
      <el-menu
        mode="horizontal"
        :default-active="
          $route.redirectedFrom ? $route.redirectedFrom : $route.path
        "
        :router="true"
        ref="menu"
        class="el-menu"
      >
        <el-menu-item
          :index="item.route"
          v-for="item in insideRoute"
          :key="item.id"
        >
          <i :class="item.icon ? item.icon : 'el-icon-setting'"></i>
          <span slot="title">{{ item.title }}</span>
        </el-menu-item>
      </el-menu>
    </div>
    <div class="content">
      <div class="right">
        <transition name="el-fade-in-linear" mode="out-in" appear>
          <router-view></router-view>
        </transition>
      </div>
    </div>
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
    return {
      projectData: {},
      insideRoute: [
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
          title: "项目文档",
          route: "/detail/" + this.$route.params.id + "/projectDoc",
          icon: "el-icon-reading",
        },
        {
          title: "字段映射",
          route: "/detail/" + this.$route.params.id + "/fieldMapping",
          icon: "el-icon-coin",
        },
        {
          title: "公共参数",
          route: "/detail/" + this.$route.params.id + "/commonlyParams",
          icon: "el-icon-thumb",
        },
        {
          title: "BUG管理",
          route: "/detail/" + this.$route.params.id + "/bugHome",
          icon: "el-icon-sort",
        },
      ],
    };
  },
  methods: {},
  components: {},
};
</script>

<style scoped>
.detail {
  width: 100%;
  height: 100%;
}

.detail .right {
  box-sizing: border-box;
  overflow-x: hidden;
}

.right {
  margin-left: 10px;
}

.middle-menu {
  height: auto;
  width: 100%;
}
</style>
