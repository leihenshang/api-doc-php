<template>
  <div class="doc-page">
    <div class="btn-wrapper">
      <button @click="addDoc()">+创建文档</button>
      <button @click="showCreateGroup = true">+新建分组</button>
    </div>

    <div class="doc-content">
      <div class="group-wrapper">
        <group
          :id="this.id"
          :groupList="groupList"
          v-on:change-group="changeGroup"
          v-on:flush-group-list="flushGroupList"
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
import group from "./group/group";

const CODE_OK = 200;
const GROUP_TYPE_DOC = 3;

export default {
  name: "docPage",
  props: {
    id: String
  },
  created() {
    this.getGroup(this.pageSize, this.curr, this.$route.params.id);
  },
  //默认数据
  data() {
    return {
      groupList: [],
      docData: {},
      curr: 1,
      pageSize: 100,
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
    //删除api
    docDelete() {
      this.getDoc(this.pageSize, this.curr, this.groupId);
    },
    //获取分组列表
    getGroup(pageSize, curr, projectId) {
      this.$http
        .get(this.apiAddress + "/group/list", {
          params: {
            cp: curr,
            type: GROUP_TYPE_DOC,
            ps: pageSize,
            projectId: projectId ? projectId : 0
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
          res => {
            let response = res.body;
            this.$message.error(
              "获取数据-操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },
    flushGroupList() {
      this.showCreateGroup = false;
      this.getGroup(1, 100, this.$route.params.id);
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
</style>
