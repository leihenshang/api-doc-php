<template>
  <div class="doc-page">
    <div class="btn-wrapper">
      <div class="btn">
        <el-button @click="addDoc()" size="small">创建文档</el-button>
        <el-button @click="showCreateGroup = !showCreateGroup" size="small">+新建分组</el-button>
      </div>
      <div class="input">
        <el-input
          placeholder="请输入标题"
          v-model="keyword"
          class="input-with-select"
          style="width:300px"
          size="small"
        >
          <el-button slot="append" icon="el-icon-search" @click="searchDoc()"></el-button>
        </el-input>
      </div>
    </div>

    <div class="doc-content">
      <div class="group-wrapper">
        <group
          :type="type"
          v-on:change-group="changeGroup"
          :showCreateGroup="showCreateGroup"
          :showIsEdit="$store.state.projectPermission == 4 ? false : true"
        >全部文档</group>
      </div>
      <div class="doc-wrapper">
        <transition name="el-fade-in-linear" mode="out-in" appear>
          <router-view />
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import group from "../project/group";

// const CODE_OK = 200;

export default {
  name: "docPage",
  props: {
    id: String
  },
  created() {},
  //默认数据
  data() {
    return {
      keyword: "",
      groupList: [],
      docData: {},
      type: 3,
      // curr: 1,
      // pageSize: 100,
      indesideRoute: [
        { title: "项目概况", route: "detail" },
        { title: "API接口", route: "api" }
      ],
      showCreateGroup: false,
      groupId: 0,
      isCreate: false
    };
  },
  methods: {
    searchDoc() {
      this.$router
        .push({
          name: "docList",
          params: { groupId: 0 },
          query: { keyword: this.keyword }
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
    }
  },
  components: {
    group
  }
};
</script>

<style scoped>
.doc-page {
  height: calc(100% - 48px);
}

.btn-wrapper {
  height: 48px;
  line-height: 48px;
}

.doc-content {
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

.doc-wrapper {
  flex: 1;
  overflow-y: scroll;
  padding: 10px;
}

.btn {
  width: 15%;
}

.input,
.btn {
  float: left;
}
</style>
