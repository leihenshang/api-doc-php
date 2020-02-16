<template>
  <div class="user">
    <div class="text-box">
      <input type="text" v-model="keyword" />
      <button @click="userList = [];keyword=''">重置</button>
      <button @click="getUserList(keyword)">搜索用户</button>
    </div>
    <h4>搜索到的用户列表：</h4>
    <div class="all-user" v-show="userList">
      <div class="user-tab" v-for="user in userList" :key="user.id">
        <div class="user-tab-info">
          <div class="avatar">
            <img src="../../assets/logo.png" alt width="100" />
          </div>
          <div class="info">
            <table border="1">
              <tr>
                <td>用户名</td>
                <td>{{user.name}}</td>
                <td>状态</td>
                <td>{{user.state}}</td>
              </tr>
              <tr>
                <td>昵称</td>
                <td>{{user.nick_name}}</td>
                <td>类型</td>
                <td>{{user.type}}</td>
              </tr>
              <tr>
                <td>邮箱</td>
                <td colspan="3">{{user.email}}</td>
              </tr>
              <tr>
                <td>最后登录ip</td>
                <td>{{user.last_login_ip}}</td>
                <td>最后登录时间</td>
                <td>{{user.last_login_time}}</td>
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
      <div class="user-tab" v-for="user in projectUser" :key="user.id">
        <div class="user-tab-info">
          <div class="avatar">
            <img src="../../assets/logo.png" alt width="100" />
          </div>
          <div class="info">
            <table border="1">
              <tr>
                <td>用户名</td>
                <td>{{user.name}}</td>
                <td>状态</td>
                <td>{{user.state}}</td>
              </tr>
              <tr>
                <td>昵称</td>
                <td>{{user.nick_name}}</td>
                <td>类型</td>
                <td>{{user.type}}</td>
              </tr>
              <tr>
                <td>邮箱</td>
                <td colspan="3">{{user.email}}</td>
              </tr>
              <tr>
                <td>最后登录ip</td>
                <td>{{user.last_login_ip}}</td>
                <td>最后登录时间</td>
                <td>{{user.last_login_time}}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="btn">
          <button @click="delProjectUser(user.relation_id)">删除</button>
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
  },
  methods: {
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
              alert("成功！~");
            }
          },
          res => {
            let response = res.body;
            alert("操作失败!" + !response.msg ? response.msg : "");
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
              alert("成功！~");
            } else {
              alert("操作失败!" + !response.msg ? response.msg : "");
            }
          },
          res => {
            let response = res.body;
            alert("操作失败!" + !response.msg ? response.msg : "");
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
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
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
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    }
  }
};
</script>
<style scoped>
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
  width: 80px;
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