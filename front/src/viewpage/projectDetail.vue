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

<style scoped>
.detail {
  width: 100%;
  height: 100%;
}

.detail .right {
  padding:0 10px;
  box-sizing: border-box;
  overflow-x: hidden;
}

</style>
