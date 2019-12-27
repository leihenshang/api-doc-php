<template>
  <div class="user">
    <div class="user-left">
      <div class="user-left-top">
        <div class="text-box">
          <input type="text" v-model="keyword" />
          <button @click="getUserList(keyword)">搜索</button>
        </div>
      </div>
      <div class="user-left-bottom">
        <table>
          <th>
            <span>头像</span>
          </th>
          <th>
            <span>昵称</span>
          </th>
          <th>
            <span>创建时间</span>
          </th>
          <th>
            <span>类型</span>
          </th>
          <th>
            <span>状态</span>
          </th>
          <th>
            <span>手机</span>
          </th>
          <th>
            <span>昵称</span>
          </th>
          <th>
            <span>最后登录ip</span>
          </th>
          <th>
            <span>最后登录时间</span>
          </th>
          <th>
            <span>用户操作</span>
          </th>

          <tr v-for="user in userList" :key="user.id">
            <td>
              <span>{{user.cover}}</span>
            </td>
            <td>
              <span>{{user.name}}</span>
            </td>
            <td>
              <span>{{user.create_time}}</span>
            </td>
            <td>
              <span>{{user.type}}</span>
            </td>
            <td>
              <span>{{user.state}}</span>
            </td>
            <td>
              <span>{{user.mobile_number}}</span>
            </td>
            <td>
              <span>{{user.nick_name}}</span>
            </td>
            <td>
              <span>{{user.last_login_ip}}</span>
            </td>
            <td>
              <span>{{user.last_login_time}}</span>
            </td>
            <td>
              <button @click="addProjectUser(user.id)">添加</button>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <div class="user-right">
      <table>
        <th>
          <span>头像</span>
        </th>
        <th>
          <span>昵称</span>
        </th>
        <th>
          <span>创建时间</span>
        </th>
        <th>
          <span>类型</span>
        </th>
        <th>
          <span>状态</span>
        </th>
        <th>
          <span>手机</span>
        </th>
        <th>
          <span>昵称</span>
        </th>
        <th>
          <span>最后登录ip</span>
        </th>
        <th>
          <span>最后登录时间</span>
        </th>
        <th>
          <span>用户操作</span>
        </th>

        <tr v-for="user in projectUser" :key="user.id">
          <td>
            <span>{{user.cover}}</span>
          </td>
          <td>
            <span>{{user.name}}</span>
          </td>
          <td>
            <span>{{user.create_time}}</span>
          </td>
          <td>
            <span>{{user.type}}</span>
          </td>
          <td>
            <span>{{user.state}}</span>
          </td>
          <td>
            <span>{{user.mobile_number}}</span>
          </td>
          <td>
            <span>{{user.nick_name}}</span>
          </td>
          <td>
            <span>{{user.last_login_ip}}</span>
          </td>
          <td>
            <span>{{user.last_login_time}}</span>
          </td>
          <td>
            <button @click="delProjectUser(user.relation_id)">删除</button>
          </td>
        </tr>
      </table>
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
    this.getUserList();
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
          function(res) {
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
          function(res) {
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
            token: this.$store.state.userInfo.token
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.userList = response.data;
            }
          },
          function(res) {
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
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    }
  }
};
</script>
<style scoped>
.user {
  display: flex;
  height: 100%;
}

.user-left,
.user-right {
  flex: 1;
}

.user-left {
  border-right: 1px solid rgb(212, 211, 211);
}

.user-left-top {
  border-bottom: 1px solid rgb(212, 211, 211);
}

.user table,
tr,
td,
th {
  border: 1px solid black;
  border-collapse: collapse;
}
</style>