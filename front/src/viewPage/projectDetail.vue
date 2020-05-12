<template>
  <div class="detail">
    <div class="top">
      <topBar />
    </div>
    <div class="content">
      <div class="left">
        <el-menu
          :default-active="$route.redirectedFrom ? $route.redirectedFrom : $route.path"
          :router="true"
          ref="menu"
          class="el-menu"
        >
          <el-menu-item :index="item.route" v-for="item in insideRoute" :key="item.id">
            <i class="el-icon-setting"></i>
            <span slot="title">{{item.title}}</span>
          </el-menu-item>
        </el-menu>
      </div>
      <div class="right">
        <transition name="el-fade-in-linear" mode="out-in" appear>
          <router-view></router-view>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import TopBar from "../components/common/topBar";

export default {
  name: "projectDetail",
  props: {
    id: String
  },
  created() {},
  data() {
    return {
      projectData: {},
      insideRoute: [
        {
          title: "项目概况",
          route: "/detail/" + this.$route.params.id
        },
        {
          title: "API接口",
          route: "/detail/" + this.$route.params.id + "/apiPage"
        },
        {
          title: "项目文档",
          route: "/detail/" + this.$route.params.id + "/projectDoc"
        },
        {
          title: "字段映射",
          route: "/detail/" + this.$route.params.id + "/fieldMapping"
        }
      ]
    };
  },
  methods: {},
  components: {
    topBar: TopBar
  }
};
</script>

<style scoped>
.detail {
  width: 100%;
  height: 100%;
}

.detail .right {
  padding: 0 10px;
  box-sizing: border-box;
  overflow-x: hidden;
}

.el-menu {
  height: 100%;
}
</style>
