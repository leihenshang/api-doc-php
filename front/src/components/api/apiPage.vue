<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="api-page">
    <div class="btn-wrapper">
      <button @click="addApi()">+创建api</button>
      <button @click="showCreateGroup = true">+新建分组</button>
    </div>

    <div class="api-content">
      <div class="group-wrapper">
        <group
          :id="this.id"
          :groupList="groupList"
          v-on:add-group="flushGroupList"
          v-on:change-group="changeGroup"
          v-on:close-add-group="closeAddGroup"
          :showCreateGroup="showCreateGroup"
        />
      </div>

      <div class="api-wrapper">
        <apiList :id="id" :apiList="apiList" v-on:api-delete="apiDelete" />
      </div>
    </div>
  </div>
</template>

<script>
import group from "./group/group";
import apiList from "./apiList";

const CODE_OK = 200;
export default {
  name: "apiPage",
  props: {
    id: String
  },
  created() {
    this.getGroup(this.pageSize, this.curr, this.$route.params.id);
    this.getApi(this.pageSize, this.curr, this.$route.params.id);
  },
  data() {
    return {
      groupList: [],
      apiList: {},
      curr: 1,
      pageSize: 100,
      indesideRoute: [
        { title: "项目概况", route: "detail" },
        { title: "API接口", route: "api" }
      ],
      showCreateGroup: false
    };
  },
  methods: {
    closeAddGroup(val) {
      this.showCreateGroup = val;
    },
    apiDelete() {
      this.getApi(this.pageSize, this.curr, this.$route.params.id);
    },
    //获取分组列表
    getGroup(pageSize, curr, projectId) {
      this.$http
        .get(this.apiAddress + "/group/list", {
          params: {
            cp: curr,
            ps: pageSize,
            projectId,
            token: this.$store.state.userInfo.token
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              if (response.data) {
                for (const key in response.data) {
                  response.data[key].isClick = false;
                }
                this.groupList = response.data;
              }
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    //获取api列表
    getApi(pageSize, curr, projectId, groupId) {
      let params = {
        cp: curr,
        ps: pageSize,
        projectId,
        token: this.$store.state.userInfo.token
      };
      if (groupId) {
        params = {
          cp: curr,
          ps: pageSize,
          projectId,
          groupId,
          token: this.$store.state.userInfo.token
        };
      }

      this.$http
        .get(this.apiAddress + "/api/list", {
          params: params
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.apiList = response.data;
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    flushGroupList() {
      this.getGroup(1, 100, this.$route.params.id);
    },
    changeGroup(id) {
      this.getApi(this.pageSize, this.curr, this.$route.params.id, id);
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

<style scoped>
.api-page {
  height: calc(100% - 48px);
}

.btn-wrapper {
  height: 48px;
  line-height: 48px;
}

.btn-wrapper button {
  width: 87px;
  height: 32px;
  padding: 0 10px;
  margin-right: 2px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  border-radius: 3px;
  font-size: 12px;
}

.api-content {
  box-sizing: border-box;
  width: 100%;
  height: calc(100% - 21px);
  margin-bottom: 20px;

  display: flex;
  border: 1px solid #e5e5e5;
}

.group-wrapper {
  width: 15%;
  height: auto;
  border-right: 1px solid #e5e5e5;
}

.api-wrapper {
  flex: 1;
  overflow-y: scroll;
  padding: 10px;
}
</style>
