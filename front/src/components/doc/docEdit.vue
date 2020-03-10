<template>
  <div class="doc-edit">
    <div class="doc-wrapper">
      <div class="btn">
        <span></span>
        <button @click="updateDoc()">提交更新</button>
      </div>
      <div class="title">
        <span>标题:</span>
        <input type="text" name id v-model="doc.title" />
      </div>
      <div class="info">
        <span>分组:</span>
        <select name id v-model="doc.group_id" v-bind:disabled="groupList.length < 1">
          <option value disabled selected>-选择分组-</option>
          <option :value="group.id" v-for="group in groupList" :key="group.id">{{group.title}}</option>
        </select>
      </div>

      <div class="doc-content">
        <mavon-editor v-model="doc.content" ref="md" />
      </div>
    </div>
  </div>
</template>
<script>
const CODE_OK = 200;

export default {
  name: "docEdit",
  props: {
    docId: Number
  },
  data() {
    return {
      doc: {},
      groupList: [],
      isCreate: true
    };
  },
  methods: {
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

      if (!confirm("确认?")) {
        return;
      }

      this.$http
        .post(this.apiAddress + "/doc/update", {
          title: this.doc.title,
          content: this.doc.content,
          group_id: this.doc.group_id,
          id: this.docId
        })
        .then(
          res => {
            res = res.body;
            if (res.code === CODE_OK) {
              if (res.data) {
                this.$message.error("更新成功！");
              } else {
                this.$message.error("更新文档失败:" + res.msg);
              }
            }
          },
          () => {
            this.$message.error("更新文档失败");
          }
        );
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

    this.getGroup();
    this.getDocDetail();
  }
};
</script>
<style scoped>
.doc-wrapper {
  width: 75%;
  margin: 20px auto;
  border: 1px solid gray;
  min-height: 800px;
}

.doc-wrapper span {
  display: inline-block;
  width: 100px;
  text-align: right;
  padding-right: 20px;
}

.doc-wrapper input,
.doc-wrapper select {
  height: 25px;
  width: 200px;
}

.doc-wrapper input,
.doc-wrapper textarea {
  width: 300px;
}

.doc-wrapper textarea {
  width: 1200px;
  min-height: 600px;
}

.doc-wrapper div {
  margin: 20px auto;
}

.doc-wrapper button {
  width: 80px;
  height: 30px;
}

.doc-content .v-note-wrapper {
  margin: 10px;
  height: 1000px;
}
</style>