<template>
  <div class="top-bar">
    <div class="top-bar-container">
      <div class="top-bar-title">apiDoc</div>
      <div class="top-bar-nav" v-show="showInfo">
        <el-menu
          :default-active="$route.path"
          mode="horizontal"
          :router="true"
          ref="menu"
          class="el-menu"
          background-color="#409EFF"
          text-color="#d9ecff"
          active-text-color="#eeeeee"
        >
          <el-menu-item :index="item.route" v-for="item in myRoute" :key="item.id">
            <span slot="title">{{ item.title }}</span>
          </el-menu-item>
        </el-menu>
      </div>
      <div class="top-bar-user" v-show="showInfo">
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
    showInfo: function () {
      let userInfo = this.$store.state.userInfo;
      if (userInfo && userInfo.id > 0 && this.$route.name != "userLogin") {
        return true;
      }

      return false;
    },
    myRoute: function () {
      let route = [
        {
          title: "项目列表",
          route: "/projectList",
          icon: "el-icon-s-fold",
        },
      ];

      if (this.$store.state.userInfo && this.$store.state.userInfo.type > 1) {
        route.push({
          title: "用户管理",
          route: "/userManager",
          icon: "el-icon-user",
        });
      }

      return route;
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
    return {};
  },

  watch: {
   nickName:function(){
        console.log(this.$store.state.userInfo)
      }
  },
};
</script>

<style lang="scss" scoped>
.top-bar {
  width: 100%;
  height: 60px;
  background-color: #409EFF;
  border-bottom: 1px solid #409EFF;

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
      color: #eeeeee;
      font-weight: bold;
      font-size: 20px;
    }

    .top-bar-user {
      height: 61px;
      display: flex;
      align-items: center;
      position: absolute;
      right: 10px;
    }

    .el-menu.el-menu--horizontal {
      border-bottom: none;
    }
  }
}
</style>
