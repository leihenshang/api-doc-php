<template>
  <div class="api-page">
    <div class="btn-wrapper">
      <div
        class="btn"
        v-show="$store.state.projectPermission == 6 || $store.state.userInfo.type === 2"
      >
        <el-button @click="showCreateGroup = !showCreateGroup">+新建分组</el-button>
      </div>
      <div class="input" v-show=" $route.name != 'apiCreate' && $route.name != 'apiEdit' ">
        <el-button
          style="margin:0 10px;"
          @click="addApi()"
          v-show="$store.state.projectPermission == 6 || $store.state.userInfo.type === 2"
        >+创建api</el-button>
        <el-input
          placeholder="请输入标题"
          v-model="keyword"
          class="input-with-select"
          style="width:300px"
        >
          <el-button size slot="append" icon="el-icon-search" @click="searchApi()"></el-button>
        </el-input>
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

      <div class="api-wrapper">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import group from "../project/group";

export default {
  name: "apiPage",
  props: {},
  created() {},
  data() {
    return {
      type: 1,
      groupId: 0,
      groupList: [],
      apiList: {},
      curr: 1,
      pageSize: 100,
      showCreateGroup: false,
      keyword: "",
    };
  },
  methods: {
    searchApi() {
      this.$router
        .push({
          name: "apiList",
          params: { groupId: 0 },
          query: { keyword: this.keyword },
        })
        .catch(() => {});
    },
    //更改分组
    changeGroup(id) {
      id = id ? id : 0;
      this.$router.push(
        { name: "apiList", params: { groupId: id } },
        () => {
          return;
        },
        () => {
          return;
        }
      );
    },
    //调整添加api
    addApi() {
      this.$router.push({
        name: "apiCreate",
      });
    },
  },
  components: {
    group,
  },
};
</script>

<style lang="scss" scoped>
.btn-wrapper {
  padding: 10px 0;
  overflow: hidden;
}

.btn {
  width: 15%;
  float: left;
}

.input {
  float: left;
}

.api-content {
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
