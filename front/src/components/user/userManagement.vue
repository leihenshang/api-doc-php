<template>
  <div class="user">
    <div class="text-box">
      <input type="text" v-model="keyword" />
      <button @click="getUserList();keyword=''">重置</button>
      <button @click="getUserList(keyword)">搜索用户</button>
    </div>
    <div class="all-user" v-show="userList[0]">
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
        <div class="btn" v-if="user.type != 2">
          <button @click="delUser(user.id)">踢出项目</button>
          <button @click="enableOrdisabledUser(user.id,2)" v-if="user.state == 1">禁用</button>
          <button @click="enableOrdisabledUser(user.id,1)" v-if="user.state == 2">启用</button>
        </div>
        <div class="btn" v-else></div>
      </div>
    </div>
  </div>
</template>
<script>
import "../../static/css/table.css";

const CODE_OK = 200;
const IS_DELETED = 1;

export default {
  name: "userManagement",
  data() {
    return {
      userList: [],
      projectUser: [],
      keyword: ""
    };
  },
  created() {
    this.getUserList();
  },
  methods: {
    createUser() {},
    //计算用户类型
    userType(val) {
      let str;
      switch (val) {
        case 1:
          str = "普通用户";
          break;
        case 2:
          str = "管理员";
          break;

        default:
          str = "未知";
          break;
      }
      return str;
    },
    //匹配用户状态
    userState(val) {
      let str;
      switch (val) {
        case 1:
          str = "正常";
          break;
        case 2:
          str = "禁用";
          break;

        case 3:
          str = "未激活";
          break;
        default:
          str = "未知";
          break;
      }
      return str;
    },
    //删除项目用户
    delUser(id) {
      if (!window.confirm("确认删除用户?")) {
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/user/update-status",
          {
            is_deleted: IS_DELETED,
            userId: id,
            token: this.$store.state.userInfo.token
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.getUserList();
              this.$message.error("成功！~");
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
    //启用/禁用用户
    enableOrdisabledUser(id, state) {
      if (!window.confirm("确认修改用户状态?")) {
        return;
      }

      if ([2, 1].indexOf(state) === -1) {
        this.$message.error("参数错误");
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/user/update-status",
          {
            state: state,
            userId: id,
            token: this.$store.state.userInfo.token
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.getUserList();
              this.$message.error("成功！~");
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
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}

.user {
  height: 100%;
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

.all-user {
  float: left;
}
</style>