<template>
  <div class="top-bar">
    <div class="top-bar-container">
      <div class="top-bar-title">api-doc</div>
      <div class="top-bar-nav" v-show="showInfo">
        <el-menu
          :default-active="$route.path"
          mode="horizontal"
          :router="true"
          ref="menu"
          class="el-menu"
          background-color="#409eff"
          text-color="#fff"
        >
          <el-menu-item :index="item.route" v-for="item in insideRoute" :key="item.id">
            <span slot="title">{{ item.title }}</span>
          </el-menu-item>
        </el-menu>
      </div>
      <div class="top-bar-avatar" v-show="showInfo">
        <div class="avatar">
          <el-avatar :src="avatarUrl" :size="40"></el-avatar>
        </div>
        <el-dropdown @command="handleCommand" style="color:#fff">
          <span class="el-dropdown-link">
            {{ nickName ? nickName : "null" }}
            <i class="el-icon-arrow-down el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item command="logout">退出登陆</el-dropdown-item>
            <el-dropdown-item command="myCenter">个人中心</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "topBar",
  created() {},
  props: {},
  computed: {
    nickName: function () {
      return this.$store.state.userInfo.nick_name;
    },
    avatarUrl: function () {
      return this.BASE_URL + "/" + this.$store.state.userInfo.user_face;
    },
    showInfo() {
      let userInfo = this.$store.state.userInfo;
      if (userInfo && userInfo.id > 0 && this.$route.name != "userLogin") {
        return true;
      }

      return false;
    },
  },
  methods: {
    //退出登录
    loginOut() {
      localStorage.removeItem("userInfo");
      this.$store.commit("saveUserInfo", {});
      this.$router.push("/login");
    },
    //到个人中心
    goToUserCenter() {
      this.$router.push({ name: "myCenter" }).catch(() => {});
    },
    handleCommand(command) {
      if (command == "logout") {
        this.loginOut();
        return;
      }

      if (command == "myCenter") {
        this.goToUserCenter();
        return;
      }
    },
  },
  data: function () {
    let route = [
      {
        title: "项目列表",
        route: "/projectList",
        icon: "el-icon-s-fold",
      },
      {
        title: "用户管理",
        route: "/userManager",
        icon: "el-icon-user",
      },
    ];

    return {
      insideRoute: route,
    };
  },
};
</script>

<style lang="scss" scoped>
.top-bar {
  width: 100%;
  height: 60px;
  background-color: rgb(64, 158, 255);
  .top-bar-container {
    display: flex;
    width: 85%;
    height: 100%;
    margin: 0 auto;
    position: relative;
    .top-bar-title {
      margin: 0 20px 0 10px;
      display: flex;
      align-items: center;
    }

    .top-bar-title {
      color: #fff;
      font-weight: bold;
    }

    .top-bar-avatar {
      height: 61px;
      display: flex;
      align-items: center;
      position: absolute;
      right: 10px;
    }

    .top-bar-avatar .avatar {
      margin-right: 10px;
    }

    .el-menu.el-menu--horizontal {
      border-bottom: none;
    }
  }
}
</style>
