<template>
  <div class="user">
    <div class="text-box">
      <input type="text" v-model="keyword" />
      <button @click="userList = [];keyword=''">重置</button>
      <button @click="getUserList(keyword)">搜索用户</button>
    </div>
    <div class="all-user common-table" v-show="userList[0]">
      <h4>搜索到的用户列表：</h4>
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
    <hr />
    <h4>项目组成员：</h4>
    <div class="common-table">
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
import "../../static/css/table.css";

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