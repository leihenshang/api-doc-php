<template>
  <div class="api-list">
    <div class="api-box">
      <table v-loading="loading">
        <tr>
          <th>名称</th>
          <th>请求方法</th>
          <th>url</th>
          <th>协议</th>
          <th>语言</th>
          <th>创建时间</th>
          <th>操作</th>
        </tr>
        <tr v-for="item in apiList.resItem" :key="item.id">
          <td>
            <span class="span-dot"></span>
            {{item.api_name}}
          </td>
          <td>{{item.http_method_type}}</td>
          <td>{{item.url}}</td>
          <td>{{item.protocol_type}}</td>
          <td>{{item.develop_language}}</td>
          <td>{{item.create_time}}</td>
          <td class="api-list-btn">
            <button
              @click="jumpPage('edit',item.id)"
              v-show="$store.state.projectPermission == 6"
            >编辑</button>

            <button @click="jumpPage('detail',item.id)">详情</button>
            <el-popconfirm
              v-if="item.is_deleted == 1"
              title="确定要还原这个api?"
              placement="top"
              @onConfirm="restoreApi(item.id)"
              width="200"
            >
              <el-button slot="reference" v-show="$store.state.projectPermission == 6">还原</el-button>
            </el-popconfirm>
            <el-popconfirm
              v-else
              title="确定要删除这个api?"
              placement="top"
              @onConfirm="delApi(item.id)"
              width="200"
            >
              <el-button slot="reference" v-show="$store.state.projectPermission == 6">删除</el-button>
            </el-popconfirm>
          </td>
        </tr>
      </table>
    </div>
    <div class="page" v-show="count > 0 && !$route.query.keyword">
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
  name: "apiList",
  props: {
    showEdit: Number
  },
  created() {
    this.getApiList(
      this.ps,
      this.cp,
      this.$route.params.id,
      this.$route.params.groupId
    );
  },
  data() {
    return {
      loading: true,
      apiList: {},
      ps: 10,
      cp: 1,
      count: 0
    };
  },
  methods: {
    restoreApi(id) {
      this.$confirm("该API将被还原, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$http
            .post(this.apiAddress + "/api/restore", {
              id: id
            })
            .then(
              response => {
                response = response.body;
                if (response.code === CODE_OK) {
                  this.$message.success("成功!");
                  this.$router.push({
                    name: "apiList",
                    params: { groupId: 0 }
                  });
                  // this.getApiList(
                  //   this.ps,
                  //   this.cp,
                  //   this.$route.params.id,
                  //   this.$route.params.groupId
                  // );
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
    //获取api列表
    getApiList(ps, cp, projectId, groupId) {
      this.$http
        .get(this.apiAddress + "/api/list", {
          params: {
            cp: cp,
            ps: ps,
            projectId,
            isDeleted: groupId < 0 ? 1 : 0,
            groupId: groupId
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.apiList = response.data;
              this.count = parseInt(response.data.resCount);
              this.loading = false;
            }
          },
          () => {
            this.loading = false;
            this.$message.error("获取数据-操作失败!");
          }
        );
    },
    //翻页
    changePage(event) {
      if (event == this.cp) {
        return;
      }
      this.loading = true;
      this.getApiList(
        this.ps,
        event,
        this.$route.params.id,
        this.$route.params.groupId
      );
      this.cp = event;
    },
    delApi(id) {
      this.$http
        .post(
          this.apiAddress + "/api/del",
          {
            id: id,
            token: this.$store.state.userInfo.token
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.$message.success("成功~");
              this.$router.push({
                name: "apiList",
                params: { groupId: this.$route.params.groupId },
                query: { random: Math.random() }
              });
            } else {
              this.$message.error("失败:" + response.msg);
            }
          },
          () => {
            this.$message.error("失败~");
          }
        );
    },
    jumpPage(name, id) {
      id = parseInt(id);
      switch (name) {
        case "edit":
          this.$router.push({ name: "apiEdit", params: { apiId: id } });
          break;

        case "detail":
          this.$router.push({ name: "apiDetail", params: { apiId: id } });
          break;

        default:
          break;
      }
    }
  },
  computed: {
    getapiId() {
      return this.$route.params.apiId;
    }
  },
  components: {},
  watch: {
    $route: function(to) {
      if (to.query.keyword) {
        this.cp = 1;
        this.getApiList(20, 1, 0, to.params.id, to.query.keyword);
        this.loading = true;
      } else {
        this.cp = 1;
        this.getApiList(this.ps, this.cp, to.params.id, to.params.groupId);
        this.loading = true;
      }
    }
  }
};
</script>

<style scoped>
.api-list {
  background-color: #fff;
  height: auto;
}

.api-list td,
.api-list th {
  padding: 8px 8px;
  font-size: 12px;
  font-weight: 700;
  color: #666;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.api-list tr:hover {
  background-color: #e3f1e5;
}

.api-list th {
  font-size: 14px;
  font-weight: 700;
  text-align: left;
}

.api-list table {
  border-collapse: collapse;
  width: 99%;
  margin: 0 auto;
}

.api-list table button {
  height: 28px;
  padding: 0 10px;
  margin-right: 2px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  border-radius: 3px;
  font-size: 12px;
}

.api-box {
  min-height: 650px;
}

.api-list .page {
  text-align: center;
  padding: 20px 0;
}

.span-dot {
  width: 10px;
  height: 10px;
  display: inline-block;
  border-radius: 10px;
  background-color: #4caf50;
  margin-right: 5px;
}
</style>
