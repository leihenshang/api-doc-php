<template>
  <div class="user">
    <div class="text-box">
      <input type="text" v-model="keyword" />
      <button @click="getUserList();keyword=''">重置</button>
      <button @click="getUserList(keyword)">搜索用户</button>
    </div>
    <div class="all-user common-table" v-show="userList[0]">
      <h4>用户列表：</h4>
      <table>
        <th>
          <span>头像</span>
        </th>
        <th>
          <span>用户名</span>
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
            <span>{{userType(user.type)}}</span>
          </td>
          <td>
            <span>{{userState(user.state)}}</span>
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
            <button @click="delUser(user.id)">删除</button>
            <button @click="enableOrdisabledUser(user.id,2)" v-if="user.state == 1">禁用</button>
            <button @click="enableOrdisabledUser(user.id,1)" v-if="user.state == 2">启用</button>
          </td>
        </tr>
      </table>
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
              alert("成功！~");
            }
          },
          res => {
            let response = res.body;
            alert("操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    //启用/禁用用户
    enableOrdisabledUser(id, state) {
      if (!window.confirm("确认修改用户状态?")) {
        return;
      }

      if ([2, 1].indexOf(state) === -1) {
        alert("参数错误");
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
              alert("成功！~");
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