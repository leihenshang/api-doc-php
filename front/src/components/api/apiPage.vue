<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="apiPage">
    <!-- 右侧内容开始 -->
    <div class="btn-wrapper">
      <button @click="addApi()">添加api</button>
    </div>
    <div class="api-content">
      <div class="group-wrapper">
        <group :id="this.id" :groupList="groupList" v-on:add-group="flushGroupList" />
      </div>

      <div class="api-wrapper">
        <apiList :id="id" />
      </div>
    </div>
  </div>
  <!-- 右侧内容结束 -->
</template>

<script>
import group from "./group";
import apiList from "./apiList";

const CODE_OK = 200;
export default {
  name: "apiPage",
  props: {
    id: String
  },
  created() {
    this.getGroup(this.curr, this.pageSize);
  },
  data() {
    return {
      groupList: [],
      apiList: [],
      curr: 1,
      pageSize: 10,
      indesideRoute: [
        { title: "项目概况", route: "detail" },
        { title: "API接口", route: "api" }
      ]
    };
  },
  methods: {
    getGroup(curr, pageSize) {
      this.$http
        .get(this.apiAddress + "/group/list", {
          params: { cp: curr, ps: pageSize, projectId: this.$route.params.id }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.groupList = response.data;
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    flushGroupList() {
      this.getGroup(1, 100);
    },
    addApi() {
      this.$router.push("/detail/" + this.$route.params.id + "/createApi");
    }
  },
  components: {
    group,
    apiList
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.api-content {
  position: absolute;
  left: 0;
  top: 51px;
  width: 100%;
  height: 100%;
  display: flex;
}

.group-wrapper {
  width: 20%;
  height: 100%;
  border-right: 1px solid #e5e5e5;
}

.api-wrapper {
  width: 80%;
  height: 100%;
  border-right: 1px solid #e5e5e5;
}

.btn-wrapper {
  height: 50px;
  width: 100%;
  border-bottom: 1px solid #e5e5e5;
  position: absolute;
}
</style>
