<template>
  <div class="doc-edit">
    <div
      class="loading"
      v-loading="loading"
      element-loading-text="拼命加载中"
      element-loading-spinner="el-icon-loading"
    >
      <div class="btn">
        <div class="left">
          <el-button plain size="mini" @click="$router.go(-1)">&lt; 返回</el-button>
        </div>
        <div class="right">
          <el-button type="success" plain size="mini" @click="updateDoc()">保存文档</el-button>
        </div>
      </div>
      <div class="doc-wrapper">
        <DocInfo :doc="doc" :groupList="this.groupList" v-on:update-info="updateInfo($event)" />
        <div class="doc-content">
          <mavon-editor v-model="doc.content" ref="md" />
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import DocInfo from "./units/docInfo";
const CODE_OK = 200;

export default {
  components: {
    DocInfo
  },
  name: "docEdit",
  props: {
    docId: [Number, String]
  },
  data() {
    return {
      doc: {},
      groupList: [],
      isCreate: true,
      loading: true
    };
  },
  methods: {
    updateInfo(val) {
      this.doc.title = val.title;
      this.doc.group_id = val.groupId;
    },
    //获取分组列表
    getGroup(pageSize = 10, curr = 1, projectId) {
      this.$http
        .get(this.apiAddress + "/group/list", {
          params: {
            cp: curr,
            type: 3,
            ps: pageSize,
            projectId: projectId ? projectId : 0
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              if (response.data) {
                this.groupList = response.data;
              }
            } else {
              this.$message.error(
                "获取数据-操作失败!" + !response.msg ? response.msg : ""
              );
            }
          },
          () => {
            this.$message.error("获取数据-操作失败!");
          }
        );
    },
    //更新文档
    updateDoc() {
      if (!this.doc.group_id) {
        this.$message.error("请选择分组");
        return;
      }

      if (this.doc.title.length < 1) {
        this.$message.error("标题不能为空");
      }

      this.$confirm("要保存吗？", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      }).then(() => {
        this.$http
          .post(this.apiAddress + "/doc/update", {
            title: this.doc.title,
            content: this.doc.content,
            group_id: this.doc.group_id,
            id: this.docId
          })
          .then(res => {
            res = res.body;
            if (res.code === CODE_OK) {
              this.$message.success("更新成功!");
              this.$router.go(-1);
            } else {
              this.$message.error(res.msg);
            }
          });
      });
    },
    //获取文档详情
    getDocDetail() {
      this.$http
        .get(this.apiAddress + "/doc/detail", {
          params: {
            id: this.docId
          }
        })
        .then(
          res => {
            let response = res.body;
            if (response.code === CODE_OK) {
              this.doc = response.data;
            } else {
              this.$message.error(`获取数据失败:${response.msg}`);
            }
          },
          () => {
            this.$message.error("获取数据失败");
          }
        );
    }
  },
  created() {
    if (!this.docId) {
      return;
    }

    this.getGroup(100, 1, this.$route.params.id);
    this.getDocDetail();
  },
  watch: {
    doc: function(val) {
      if (val.id) {
        this.loading = false;
      }
    }
  }
};
</script>
<style scoped>
.doc-wrapper {
  margin: 20px auto;
  min-height: 800px;
}

.doc-content .v-note-wrapper {
  margin: 10px;
  height: 1000px;
}

.btn {
  width: 100%;
  display: flex;
}

.btn .right {
  text-align: right;
  padding-right: 20px;
}
</style>