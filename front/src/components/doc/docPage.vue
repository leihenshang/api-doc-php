<template>
  <div class="doc-page">
    <div class="group-wrapper">
      <group
        :type="type"
        v-on:change-group="changeGroup"
        :showCreateGroup="showCreateGroup"
        :showIsEdit="$store.state.projectPermission == 4 ? false : true"
      >全部文档</group>
    </div>
    <div class="doc-wrapper">
      <div class="btn-wrapper" v-show=" $route.name == 'docList' ">
        <div class="input" style="display:inline-block;">
          <el-button @click="addDoc()" style="margin-right:5px">创建文档</el-button>
          <el-input
            placeholder="请输入标题"
            v-model="keyword"
            class="input-with-select"
            style="width:300px"
            clearable
          ></el-input>
          <el-button icon="el-icon-search" @click="searchDoc()" style="margin-left:5px;">搜索</el-button>
        </div>
      </div>
      <router-view />
    </div>
  </div>
</template>

<script>
import group from "../project/group";

// const CODE_OK = 200;

export default {
  name: "docPage",
  props: {
    id: String,
  },
  created() {},
  //默认数据
  data() {
    return {
      keyword: "",
      groupList: [],
      docData: {},
      type: 3,
      indesideRoute: [
        { title: "项目概况", route: "detail" },
        { title: "API接口", route: "api" },
      ],
      showCreateGroup: false,
      groupId: 0,
      isCreate: false,
    };
  },
  methods: {
    searchDoc() {
      this.$router
        .push({
          name: "docList",
          params: { groupId: 0 },
          query: { keyword: this.keyword },
        })
        .catch(() => {});
    },
    changeGroup(id) {
      id = id ? id : 0;
      this.$router.push(
        { name: "docList", params: { groupId: id } },
        () => {
          return;
        },
        () => {
          return;
        }
      );
    },
    //添加文档
    addDoc() {
      this.isCreate = true;
      this.$router.push({ name: "docCreate" });
    },
  },
  components: {
    group,
  },
};
</script>

<style lang="scss" scoped>
.doc-page {
  width: 100%;
  height: calc(100% - 21px);
  display: flex;

  .group-wrapper {
    width: 260px;
    height: auto;
    border: 1px solid #e5e5e5;
    flex: 0.2;
    margin: 10px 0 0 0;
  }

  .doc-wrapper {
    flex: 1;
    padding-left: 10px;
    .btn-wrapper {
      padding: 10px 0;
      overflow: hidden;
    }
  }
}
</style>
