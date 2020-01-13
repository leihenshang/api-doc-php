<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
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
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import LeftMenu from "../components/common/leftMenu";
import TopBar from "../components/common/topBar";

// const CODE_OK = 200;
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
        { title: "项目概况", route: "detail", child: "detailPage" },
        { title: "API接口", route: "detail", child: "apiPage" },
        { title: "项目用户管理", route: "detail", child: "user" },
        { title: "项目文档", route: "detail", child: "projectDoc" }
      ]
    };
  },
  methods: {
    jump(name) {
      this.$router.push("/" + name + "/" + this.id);
    }
  },
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
