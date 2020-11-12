<template>
  <div class="doc-list">
    <div class="doc-list-table">
      <el-table :data="docList" stripe style="width: 100%" v-loading="loading" border>
        <el-table-column prop="title" label="名称" width="180"></el-table-column>
        <el-table-column prop="nick_name" label="创建者" width="180"></el-table-column>
        <el-table-column prop="create_time" label="创建时间"></el-table-column>
        <el-table-column label="操作">
          <template slot-scope="scope">
            <el-button
              size="mini"
              @click="jumpPage('docEdit',scope.row.id)"
              v-show="$store.state.projectPermission == 6"
            >编辑</el-button>
            <el-button size="mini" @click="jumpPage('docDetail',scope.row.id)">详情</el-button>
            <el-button
              v-if="$route.params.groupId == -1"
              size="mini"
              type="danger"
              @click="restoreDoc(scope.row.id)"
              v-show="$store.state.projectPermission == 6"
            >还原</el-button>
            <el-button
              v-else
              size="mini"
              type="danger"
              @click="delDoc(scope.row.id)"
              v-show="$store.state.projectPermission == 6"
            >删除</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div class="page" v-show=" !$route.query.keyword">
      <el-pagination
        background
        layout="total,prev, pager, next"
        :total="count"
        :page-size="ps"
        :current-page="cp"
        @prev-click="changePage($event)"
        @next-click="changePage($event)"
        @current-change="changePage($event)"
      ></el-pagination>
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "docList",
  props: {
    id: String,
    groupId: {
      type: [Number, String],
      default: 0
    },
    projectId: {
      type: [Number, String],
      default: 0
    }
  },
  created() {
    this.getDocList(this.ps, this.cp, this.groupId, this.$route.params.id);
  },
  data() {
    return {
      loading: true,
      docList: [],
      cp: 1,
      ps: 10,
      count: 0
    };
  },
  methods: {
    restoreDoc(id) {
      this.$confirm("该文档将被还原, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$http
            .post( "/doc/restore", {
              id: id
            })
            .then(
              response => {
                response = response.data;
                if (response.code === CODE_OK) {
                  this.$message.success("成功!");
                  this.getDocList(
                    this.ps,
                    this.cp,
                    this.groupId,
                    this.$route.params.id
                  );
                } else {
                  this.$message.error("操作失败!");
                }
              },
              () => {
                this.$message.error("操作失败!");
              }
            );
        })
        .catch(() => {});
    },
    //翻页
    changePage(event) {
      if (event == this.cp) {
        return;
      }
      this.loading = true;
      this.getDocList(this.ps, event, this.groupId, this.$route.params.id);
      this.cp = event;
    },
    //删除文档
    delDoc(id) {
      this.$confirm("该文档将被删除, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$http
            .post( "/doc/delete", {
              id: id,
              projectId: this.$route.params.id
            })
            .then(
              response => {
                response = response.data;
                if (response.code === CODE_OK) {
                  this.$message.success("成功!");
                  this.getDocList(
                    this.ps,
                    this.cp,
                    this.groupId,
                    this.$route.params.id
                  );
                } else {
                  this.$message.error("操作失败!");
                }
              },
              () => {
                this.$message.error("操作失败!");
              }
            );
        })
        .catch(() => {});
    },
    //获取文档
    getDocList(size, curr, groupId, projectId, keyword = "") {
      if (!projectId) {
        this.$message.error("异常错误");
        return;
      }

      if (!groupId) {
        groupId = 0;
      }

      this.$http
        .get( "/doc/list", {
          params: {
            group_id: groupId,
            project_id: projectId,
            ps: size,
            cp: curr,
            is_deleted: groupId < 0 ? 1 : 0,
            keyword: keyword.length > 0 ? keyword : ""
          }
        })
        .then(
          response => {
            response = response.data;
            if (response.code === CODE_OK) {
              this.docList = response.data.data;
              this.count = Number.parseInt(response.data.total);
              this.loading = false;
            }
          },
          res => {
            let response = res.data;
            this.$message.error(
              "获取数据-操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },
    jumpPage(name, docId) {
      this.$router.push({ name, params: { docId: docId } });
    }
  },
  watch: {
    $route: function(to) {
      if (to.query.keyword) {
        this.cp = 1;
        this.getDocList(20, 1, 0, to.params.id, to.query.keyword);
        this.loading = true;
      } else {
        this.cp = 1;
        this.getDocList(this.ps, this.cp, to.params.groupId, to.params.id);
        this.loading = true;
      }
    }
  }
};
</script>

<style scoped>
.doc-list-table {
  min-height: 620px;
}

.page {
  background-color: #fff;
  border: 1px;
  text-align: center;
  margin: 20px 0;
}
</style>
