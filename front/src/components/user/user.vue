<template>
  <div class="user">
    <div class="text-box" v-show="$store.state.projectPermission === 6">
      <input type="text" v-model="keyword" />
      <button @click="userList = [];keyword=''">重置</button>
      <button @click="getUserList(keyword)">搜索用户</button>
    </div>

    <div class="all-user" v-show="userList.length > 0">
      <h4>搜索到的用户列表：</h4>
      <div class="user-tab" v-for="user in userList" :key="user.id">
        <div class="user-tab-info">
          <div class="avatar">
            <img src="../../assets/logo.png" alt width="60" />
          </div>
          <div class="info">
            <table border="1">
              <tr>
                <td>用户名</td>
                <td>{{user.name}}</td>
              </tr>
              <tr>
                <td>昵称</td>
                <td>{{user.nick_name}}</td>
                <td>类型</td>
                <td colspan="3">{{user.type == 1 ? '普通用户' : '管理员' }}</td>
              </tr>
              <tr>
                <td>邮箱</td>
                <td colspan="3">{{user.email}}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="btn">
          <button @click="addProjectUser(user.id)">添加</button>
        </div>
      </div>
    </div>
    <hr />
    <h4>项目组成员：</h4>
    <div class="all-user" v-show="projectUser">
      <div class="user-tab" v-for="(user,index) in projectUser" :key="user.id">
        <div class="user-tab-info">
          <div class="avatar">
            <img src="../../assets/logo.png" alt width="60" />
          </div>
          <div class="info">
            <table border="1">
              <tr>
                <td>昵称</td>
                <td colspan="3">{{user.nick_name}}</td>
              </tr>
              <tr>
                <td>类型</td>
                <td
                  colspan="3"
                >{{user.type == 1 ? '普通用户' : '管理员' }}{{ user.is_leader == 1 ? '(项目管理员)' :'' }}</td>
              </tr>
              <tr>
                <td>邮箱</td>
                <td colspan="3">{{user.email}}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="btn" v-if="$store.state.projectPermission == 4"></div>
        <div class="btn" v-else>
          <button @click="open(user.nick_name,index)">修改昵称</button>
          <button @click="quitProject(user.id)">踢出项目</button>
          <button v-if="user.is_leader != 1" @click="setLeader(user.id)">设置项目管理员</button>
          <button v-else @click="setLeader(user.id,1)">取消项目管理权限</button>
          <button v-if="user.permission == 6" @click="setPermission(user.id,4)">设置只读</button>
          <button v-else @click="setPermission(user.id,6)">设置为读/写</button>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
const CODE_OK = 200;

export default {
  name: "user",
  data() {
    return {
      userList: [],
      projectUser: [],
      keyword: ""
    };
  },
  created() {
    this.getProjectUserList();
    this.getPermission();
  },
  methods: {
    //获取用户操作权限
    getPermission() {
      this.$http
        .get(this.apiAddress + "/project/get-project-operation-permission", {
          params: {
            token: this.$store.state.userInfo.token,
            projectId: this.$route.params.id
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.permission = response.data;
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
    //修改昵称弹出框
    open(name, index) {
      this.$prompt("请输入新昵称", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        inputPattern: /.{2,20}/,
        inputErrorMessage: "昵称不正确",
        inputValue: name
      })
        .then(({ value }) => {
          this.$http
            .post(
              this.apiAddress + "/user/update-nickname",
              {
                userId: this.projectUser[index].id,
                nickname: value
              },
              { emulateJSON: true }
            )
            .then(
              response => {
                response = response.body;
                if (response.code === CODE_OK) {
                  this.getProjectUserList();
                  this.$message.success({
                    type: "success",
                    message: "你的新昵称是: " + value
                  });
                } else {
                  this.$message.error(
                    "操作失败!" + !response.msg ? response.msg : ""
                  );
                }
              },
              res => {
                let response = res.body;
                this.$message.error(
                  "操作失败!" + !response.msg ? response.msg : ""
                );
              }
            );
        })
        .catch(() => {});
    },
    //退出项目
    quitProject(userId) {
      this.$http
        .post(
          this.apiAddress + "/project/quit-project",
          {
            userId,
            projectId: this.$route.params.id
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.getProjectUserList();
              this.$message.success("成功！~");
            }
          },
          res => {
            let response = res.body;
            this.$message.error(
              "操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },
    //设置用户对项目的读写权限
    setLeader(userId, cancel) {
      this.$http
        .post(
          this.apiAddress + "/project/set-leader",
          {
            userId,
            projectId: this.$route.params.id,
            cancel
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.getProjectUserList();
              this.$message.success("成功！~");
            }
          },
          res => {
            let response = res.body;
            this.$message.error(
              "操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },
    //设置用户对项目的读写权限
    setPermission(userId, permission) {
      this.$http
        .post(
          this.apiAddress + "/project/set-permission",
          {
            userId,
            permission,
            projectId: this.$route.params.id
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.getProjectUserList();
              this.$message.success("成功！~");
            }
          },
          res => {
            let response = res.body;
            this.$message.error(
              "操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },
    //删除项目用户
    delProjectUser(id) {
      this.$http
        .post(
          this.apiAddress + "/project/del-user",
          {
            ids: id,
            token: this.$store.state.userInfo.token
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.getProjectUserList();
              this.$message.success("成功！~");
            }
          },
          res => {
            let response = res.body;
            this.$message.error(
              "操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },
    //增加项目用户
    addProjectUser(userId) {
      this.$http
        .post(
          this.apiAddress + "/project/add-user",
          {
            user_id: userId,
            project_id: this.$route.params.id,
            token: this.$store.state.userInfo.token
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.getProjectUserList();
              this.$message.error("成功！~");
            } else {
              this.$message.error(
                "操作失败!" + !response.msg ? response.msg : ""
              );
            }
          },
          res => {
            let response = res.body;
            this.$message.error(
              "操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },
    //获取用户列表
    getUserList(keyword) {
      this.$http
        .get(this.apiAddress + "/user/list", {
          params: {
            keyword,
            token: this.$store.state.userInfo.token,
            project_id: this.$route.params.id
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.userList = response.data;
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
    //获取项目用户列表
    getProjectUserList() {
      this.$http
        .get(this.apiAddress + "/project/project-user", {
          params: {
            id: this.$route.params.id,
            token: this.$store.state.userInfo.token
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.projectUser = response.data;
            }
          },
          res => {
            let response = res.body;
            this.$message.error(
              "获取数据-操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    }
  }
};
</script>
<style scoped>
.user {
  font-size: 14px;
}

.user-tab {
  border: 1px solid gray;
  width: 600px;
  display: inline-block;
  margin: 20px 30px;
}

.user-tab-info {
  border-bottom: 1px solid gray;
  display: flex;
  padding: 2px;
}

.avatar {
  flex: 0.5;
  position: relative;
}

.avatar img {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

.info {
  flex: 2;
}

.btn {
  text-align: right;
}

.btn button {
  width: 120px;
  height: 30px;
  margin: 3px 3px 3px;
}

.user-tab table {
  width: 100%;
}

.user-tab table,
.user-tab tr,
.user-tab td,
.user-tab th {
  border: 1px solid black;
  border-collapse: collapse;
  text-align: left;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.user {
  height: 100%;
}

.user {
  height: 100%;
}

.user hr {
  margin: 20px 0;
  color: rgba(214, 211, 211, 0.424);
}

.text-box {
  margin: 20px 0;
  /* border:1px solid black; */
}

.text-box input {
  height: 30px;
  width: 15%;
  margin: 0 5px;
  padding: 0 5px;
}

.text-box button {
  height: 35px;
  width: 100px;
  font-size: 14px;
}
</style>