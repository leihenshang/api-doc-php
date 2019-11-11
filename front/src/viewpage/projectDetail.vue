<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="detail">
    <!-- 头部导航栏开始 -->
    <div class="top">
      <topBar />
    </div>
    <!-- 头部导航栏结束 -->
    <div class="content">
      <!-- 左侧导航栏开始 -->
      <div class="left">
        <leftMenu :menuList="indesideRoute" />
      </div>
      <!-- 左侧导航栏结束 -->
      <!-- 右侧内容开始 -->
      <div class="right">
        <router-view></router-view>
      </div>
      <!-- 右侧内容结束 -->
    </div>
  </div>
</template>

<script>
import LeftMenu from "../components/common/leftMenu";
import TopBar from "../components/common/topBar";

const CODE_OK = 200;
export default {
  name: "projectDetail",
  props: {
    id: String
  },
  created() {
    this.getDetail();
  },
  data() {
    return {
      projectData: {},
      indesideRoute: [
        { title: "项目概况", route: "detail", child: "detailPage" },
        { title: "API接口", route: "detail", child: "apiPage" }
      ]
    };
  },
  methods: {
    getDetail() {
      this.$http
        .get(this.apiAddress + "/project/detail", {
          params: { id: this.$route.params.id }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.projectData = response.data;
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
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

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.content {
  width: 100%;
  display: flex;
  height: 1200px;
}

.left {
  width: 23%;
}


/* <!-- 右侧内容开始 --> */
.right {
  position: absolute;
  width: 87%;
  height: auto;
  left: 241px;
  background-color: #f8f8f8;
}


</style>
