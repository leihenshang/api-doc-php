<template>
  <div class="api-page">
    <div class="btn-wrapper">
      <div v-show="$store.state.projectPermission == 6">
        <button @click="addApi()">+创建api</button>
        <button @click="showCreateGroup = !showCreateGroup">+新建分组</button>
      </div>
    </div>

    <div class="api-content">
      <div class="group-wrapper">
        <group
          :type="type"
          v-on:change-group="changeGroup"
          :showCreateGroup="showCreateGroup"
          :showIsEdit="$store.state.projectPermission == 4 ? false : true"
        >全部接口</group>
      </div>

      <div class="api-wrapper" v-loading="loading">
        <apiList
          :apiList="apiList"
          v-on:api-delete="apiDelete"
          :showEdit="$store.state.projectPermission == 4 ? 0 : 1"
        />
      </div>
    </div>
  </div>
</template>

<script>
import apiList from "./apiList";
import group from "../project/group";

const CODE_OK = 200;
export default {
  name: "apiPage",
  props: {},
  created() {
    if (this.$route.params.groupId) {
      this.changeGroup(this.$route.params.groupId);
    } else {
      this.getApi(this.pageSize, this.curr, this.$route.params.id);
    }
  },
  data() {
    return {
      type: 1,
      groupId: 0,
      groupList: [],
      apiList: {},
      curr: 1,
      pageSize: 100,
      indesideRoute: [
        { title: "项目概况", route: "detail" },
        { title: "API接口", route: "api" }
      ],
      showCreateGroup: false,
      loading: true
    };
  },
  methods: {
    apiDelete() {
      this.getApi(this.pageSize, this.curr, this.$route.params.id);
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
              this.loading = false;
            }
          },
          () => {
            this.loading = false;
            this.$message.error("获取数据-操作失败!");
          }
        );
    },
    //更改分组
    changeGroup(id) {
      this.groupId = id;
      this.loading = true;
      this.getApi(this.pageSize, this.curr, this.$route.params.id, id);
    },
    //调整添加api
    addApi() {
      this.$router.push({
        path: "/detail/" + this.$route.params.id + "/apiCreate/" + this.groupId
      });
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
