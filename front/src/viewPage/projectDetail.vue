<template>
  <div class="detail">
    <div class="top">
      <topBar />
    </div>
    <div class="content">
      <div class="left">
        <leftMenu :menuList="indesideRoute" />
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
import LeftMenu from "../components/common/leftMenu";
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
      indesideRoute: [
        { title: "项目概况", route: "detail", child: "", isClick: true },
        {
          title: "API接口",
          route: "detail",
          child: "apiPage",
          isClick: false
        },
        {
          title: "项目文档",
          route: "detail",
          child: "projectDoc",
          isClick: false
        }
      ]
    };
  },
  methods: {},
  components: {
    leftMenu: LeftMenu,
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
</style>
