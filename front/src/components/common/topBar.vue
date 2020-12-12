<template>
  <div class="top-bar">
    <div class="top-bar-container">
      <div class="top-bar-title">{{projectName ? projectName : 'apiDoc'}}</div>
      <el-button v-show="showHomeBtn" @click="$router.push('/')" type="text" style="color:#fff">返回首页</el-button>
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
    projectName: function () {
      if (
        this.$route.params.projectId &&
        this.$route.params.projectId == this.$store.state.project.id
      ) {
        return this.$store.state.project.title;
      }

      return "";
    },
    showHomeBtn: function () {
      if (
        this.$route.params.projectId &&
        this.$route.params.projectId == this.$store.state.project.id
      ) {
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
    return {};
  },

  watch: {
    nickName: function () {
      console.log(this.$store.state.userInfo);
    },
  },
};
</script>

<style lang="scss" scoped>
.top-bar {
  width: 100%;
  height: 60px;
  background-color: #409eff;
  border-bottom: 1px solid #409eff;

  .top-bar-container {
    display: flex;
    width: 100%;
    height: 100%;
    margin: 0 auto;
    position: relative;
    .top-bar-title {
      margin: 0 20px 0 40px;
      display: flex;
      align-items: center;
      color: #eeeeee;
      font-size: 20px;
    }

    .top-bar-user {
      height: 61px;
      display: flex;
      align-items: center;
      position: absolute;
      right: 40px;
    }
  }
}
</style>
