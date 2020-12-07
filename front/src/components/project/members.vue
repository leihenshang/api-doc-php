<template>
  <div class="members">
    <div class="user-search">
      <el-select
        v-model="keywords"
        filterable
        remote
        placeholder="输入昵称或邮箱"
        :remote-method="getUserList"
        :loading="loading"
        @change="addProjectUser($event)"
        clearable
      >
        <el-option
          v-for="item in searchUserList.list"
          :key="item.id"
          :label="item.nick_name"
          :value="item"
        ></el-option>
      </el-select>
    </div>
    <div class="all-user" v-loading="loading">
      <el-table :data="userList" stripe style="width: 100%" border>
        <el-table-column prop="name" label="账号" width="180"></el-table-column>
        <el-table-column prop="state" label="状态" width="180">
          <template slot-scope="scope">{{ transferState(scope.row.state) }}</template>
        </el-table-column>
 <el-table-column prop="is_leader" label="项目管理员" width="180">
          <template slot-scope="scope">{{scope.row.is_leader == 1 ? '是' : '否' }}</template>
        </el-table-column>
        <el-table-column prop="nick_name" label="昵称" width="180"></el-table-column>
        <el-table-column prop="email" label="邮箱"></el-table-column>
        <el-table-column prop="last_login_time" label="最后登录时间"></el-table-column>
        <el-table-column align="center" label="操作" width="100">
          <template slot-scope="scope">
            <el-dropdown placement="bottom" trigger="click" @command="handleCommand">
             <el-button type="text">项目设置</el-button>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item
                  :command="{action:'setLeader',data:scope.row}"
                >设为{{scope.row.is_leader == 0 ? '管理员' : '普通用户' }}</el-dropdown-item>
                <el-dropdown-item :command="{action:'quit',data:scope.row}">移出项目</el-dropdown-item>
                <el-dropdown-item
                  :command="{action:'setPermission',data:scope.row}"
                >设置{{scope.row.permission == 4 ? '读/写':'只读'}}</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;

export default {
  name: "members",
  data() {
    return {
      loading: false,
      keywords: "",
      searchUserList: [],
      userList: [],
    };
  },
  created() {
    this.getProjectUserList();
  },
  methods: {
    //转换状态字符串显示
    transferState(state) {
      state = parseInt(state);
      let str = "";
      //1正常2禁用3未激活
      switch (state) {
        case 1:
          str = "正常";
          break;
        case 2:
          str = "正常";
          break;
        case 3:
          str = "正常";
          break;

        default:
          str = "正常";
          break;
      }

      return str;
    },
    handleCommand(val) {
      switch (val.action) {
        case "setLeader":
          this.setLeader(val.data);
          break;
        case "quit":
          this.quitProject(val.data);
          break;

        case "setPermission":
          this.setPermission(val.data);
          break;

        default:
          break;
      }
    },
    //获取项目用户列表
    getProjectUserList() {
      this.$http
        .get("/project/project-user", {
          params: {
            id: this.$route.params.id,
          },
        })
        .then(
          (response) => {
            response = response.data;
            if (response.code === CODE_OK) {
              this.userList = response.data;
            }
          },
          (res) => {
            let response = res.data;
            this.$message.error(
              "获取数据-操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },

    //增加项目用户
    addProjectUser(val) {
      this.$confirm(
        "将用户" + val.nick_name + "加入该项目, 是否继续?",
        "提示",
        {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning",
        }
      )
        .then(() => {
          this.$http
            .post("/project/add-user", {
              user_id: val.id,
              project_id: this.$route.params.id,
            })
            .then(
              (response) => {
                response = response.data;
                if (response.code === CODE_OK) {
                  this.getProjectUserList();
                  this.$message.success("操作成功");
                } else {
                  this.$message.error(response.msg);
                }
              },
              () => {
                this.$message.error("操作失败!");
              }
            );
        })
        .catch(() => {});
    },
    //设置用户对项目的读写权限
    setPermission(val) {
      let userPermission = val.permission == 4 ? 6 : 4;
      userPermission = Number.parseInt(userPermission);
      this.$confirm("将用户" + val.nick_name + "修改权限, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning",
      })
        .then(() => {
          this.$http
            .post("/project/set-permission", {
              userId: val.id,
              permission: userPermission,
              projectId: this.$route.params.id,
            })
            .then(
              (response) => {
                response = response.data;
                if (response.code === CODE_OK) {
                  this.getProjectUserList();
                  this.$message.success("操作成功!");
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

    //设置项目管理员
    setLeader(val) {
      this.$confirm(
        "将用户" + val.nick_name + "设置为项目管理员, 是否继续?",
        "提示",
        {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning",
        }
      )
        .then(() => {
          this.$http
            .post("/project/set-leader", {
              userId: val.id,
              projectId: this.$route.params.id,
              cancel: val.is_leader == 1 ? 1 : 0,
            })
            .then(
              (response) => {
                response = response.data;
                if (response.code === CODE_OK) {
                  this.getProjectUserList();
                  this.$message.success("成功!");
                } else {
                  this.$message.error("操作失败");
                }
              },
              () => {
                this.$message.error("请求失败");
              }
            );
        })
        .catch(() => {});
    },
    handleSelect(val) {
      this.$confirm(
        "将用户" + val.nick_name + "加入该项目, 是否继续?",
        "提示",
        {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning",
        }
      )
        .then(() => {
          this.$message({
            type: "success",
            message: "删除成功!",
          });
        })
        .catch(() => {});
    },
    //移除出项目
    quitProject(val) {
      this.$confirm(
        "将用户" + val.nick_name + "移出该项目, 是否继续?",
        "提示",
        {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning",
        }
      )
        .then(() => {
          this.$http
            .post("/project/quit-project", {
              userId: val.id,
              projectId: this.$route.params.id,
            })
            .then(
              (response) => {
                response = response.data;
                if (response.code === CODE_OK) {
                  this.getProjectUserList();
                  this.$message.success("成功!");
                } else {
                  this.$message.faild(response.msg);
                }
              },
              () => {
                this.$message.error("操作失败!");
              }
            );
        })
        .catch(() => {});
    },
    //获取用户列表
    getUserList(keywords) {
      if (keywords && keywords.length < 2) {
        return;
      }

      this.$http
        .get("/user/list", {
          params: {
            keywords,
            notProjectId: true,
          },
        })
        .then((response) => {
          response = response.data;
          if (response.code === CODE_OK) {
            this.searchUserList = response.data;
          }
        });
    },
  },
};
</script>

<style lang="scss" scope>
.user-search {
  margin: 10px 0;
}
</style>