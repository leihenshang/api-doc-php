<template>
  <div class="api-page">
    <div class="btn-wrapper">
      <button @click="addApi()">+创建api</button>
      <button @click="showCreateGroup = true">+新建分组</button>
    </div>

    <div class="api-content">
      <div class="group-wrapper">
        <group
          :groupList="groupList"
          v-on:add-group="flushGroupList"
          v-on:change-group="changeGroup"
          v-on:close-add-group="closeAddGroup"
          :showCreateGroup="showCreateGroup"
        />
      </div>

      <div class="api-wrapper" v-loading="loading">
        <apiList :apiList="apiList" v-on:api-delete="apiDelete" />
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
  props: {},
  created() {
    if (this.$route.params.groupId) {
      this.changeGroup(this.$route.params.groupId);
    } else {
      this.getApi(this.pageSize, this.curr, this.$route.params.id);
    }

    this.getGroup(this.pageSize, this.curr, this.$route.params.id);
  },
  data() {
    return {
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
                //添加已点击判断
                for (const key in response.data) {
                  if (this.$route.params.groupId == response.data[key].id) {
                    response.data[key].isClick = true;
                  } else {
                    response.data[key].isClick = false;
                  }
                }
                this.groupList = response.data;
              }
            }
          },
          () => {
            this.$message.error("获取数据-操作失败!");
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
              this.loading = false;
            }
          },
          () => {
            this.loading = false;
            this.$message.error("获取数据-操作失败!");
          }
        );
    },
    flushGroupList() {
      this.getGroup(1, 100, this.$route.params.projectId);
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
