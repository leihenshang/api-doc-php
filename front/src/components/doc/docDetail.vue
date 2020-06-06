<template>
  <div class="doc-wrapper">
    <div class="btn">
      <div class="left">
        <el-button plain size="small" @click="$router.go(-1)">
          <i class="el-icon-arrow-left"></i> 文档列表
        </el-button>
      </div>
      <div class="right">
        <el-button
          type="success"
          plain
          size="mini"
          @click="updateDoc()"
          :loading="btnLoading"
          v-show="$store.state.projectPermission == 6"
        >修改文档</el-button>
      </div>
    </div>
    <div class="doc-detail" v-if="doc">
      <div class="title">
        <h3>{{doc.title}}</h3>
      </div>
      <div class="info">
        <span>作者:{{doc.nick_name}}</span>
        <span>{{doc.create_time}}</span>
        <span>阅读次数:{{doc.view_count}}</span>
        <span>点赞次数:{{doc.like_count}}</span>
      </div>
      <div class="doc-content">
        <mavon-editor
          v-model="doc.content"
          ref="md"
          :subfield="false"
          :editable="false"
          :toolbarsFlag="false"
          :defaultOpen="'preview'"
        />
      </div>
    </div>
  </div>
</template>
<script>
const CODE_OK = 200;

export default {
  name: "docDetail",
  props: {
    docId: [Number, String]
  },
  data() {
    return {
      btnLoading: true,
      doc: Object
    };
  },
  methods: {
    updateDoc() {
      this.$router.push({ name: "docEdit" });
    },
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
              this.btnLoading = !this.btnLoading;
            }
          },
          () => {
            this.$message.error("获取数据失败");
          }
        );
    }
  },
  created() {
    this.getDocDetail();
  }
};
</script>
<style scoped>
.doc-detail {
  margin: 10px auto;
  background-color: #fff;
  height: 100%;
  min-height: 800px;
}

.doc-detail .title {
  margin: 30px 0;
  text-align: center;
}

.doc-detail .info span {
  margin-right: 12px;
  font-size: 12px;
  color: gray;
}

.doc-detail .info {
  margin-left: 30px;
}

.doc-content .v-note-wrapper {
  margin: 10px;
  height: 1000px;
}

.doc-content ul li {
  list-style: auto;
}

.btn {
  width: 100%;
  display: flex;
  margin: 0 10px;
}

.btn .right {
  text-align: right;
  padding-right: 20px;
}
</style>