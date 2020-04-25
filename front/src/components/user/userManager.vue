<template>
  <div class="user">
    <div class="text-box">
      <el-input
        placeholder="请输入内容"
        v-model="keyword"
        clearable
        style="width:10%;margin-right:8px"
        @clear="getUserList();keyword=''"
      ></el-input>
      <el-button icon="el-icon-search" type="primary" plain size="small"></el-button>
      <el-button size="small">添加用户</el-button>
    </div>
    <div class="all-user" v-show="userList.count > 0" v-loading="loading">
      <el-table :data="userList.list" stripe style="width: 100%" border>
        <el-table-column prop="id" label="id" width="100"></el-table-column>
        <el-table-column prop="name" label="登录名" width="180"></el-table-column>
        <el-table-column prop="state" label="状态" width="180">
          <template slot-scope="scope">{{ transferState(scope.row.state) }}</template>
        </el-table-column>
        <el-table-column prop="type" label="类型" width="180">
          <template slot-scope="scope">{{ transferType(scope.row.type) }}</template>
        </el-table-column>
        <el-table-column prop="nick_name" label="昵称" width="180"></el-table-column>
        <el-table-column prop="email" label="邮箱"></el-table-column>
        <el-table-column prop="create_time" label="创建时间"></el-table-column>
        <el-table-column prop="last_login_time" label="最后登录时间"></el-table-column>
        <el-table-column prop="last_login_ip" label="最后登录ip"></el-table-column>
        <el-table-column fixed="right" label="操作" width="100">
          <template slot-scope="scope">
            <el-button type="text" size="small">编辑</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div class="page">
      <el-pagination
        background
        layout="prev, pager, next"
        :total=" parseInt(userList.count)"
        :page-size="ps"
        :current-page="cp"
        @prev-click="cp --; getUserList()"
        @next-click="cp ++; getUserList()"
      ></el-pagination>
    </div>
  </div>
</template>
<script>
const CODE_OK = 200;
const IS_DELETED = 1;

export default {
  name: "userManager",
  data() {
    return {
      userList: [],
      projectUser: [],
      keyword: "",
      ps: 10,
      cp: 1,
      loading: true
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
            project_id: this.$route.params.id,
            ps: this.ps,
            cp: this.cp
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.userList = response.data;
            } else {
              this.$message.error(response.msg);
            }
            this.loading = false;
          },
          () => {
            this.$message.error("获取数据-操作失败!");
          }
        );
    },
    transferState(state) {
      state = parseInt(state);
      //1正常2禁用3未激活
      switch (state) {
        case 1:
          return "正常";
          break;
        case 2:
          return "禁用";
          break;
        case 3:
          return "未激活";
          break;

        default:
          return "未知";
          break;
      }
    },
    transferType(type) {
      type = parseInt(type);
      //1普通用户2管理员
      switch (type) {
        case 1:
          return "普通用户";
          break;
        case 2:
          return "管理员";
          break;
        default:
          return "未知";
          break;
      }
    }
  }
};
</script>
<style scoped>
.user {
  font-size: 14px;
}

.user {
  height: 100%;
}

.text-box {
  padding: 10px 10px;
}

.all-user {
  padding: 0 10px;
  min-height: 600px;
}

.page {
  text-align: center;
}
</style>