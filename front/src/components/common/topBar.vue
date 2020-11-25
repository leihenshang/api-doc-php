<template>
  <div class="top-bar">
    <div class="top-bar-title">api-doc</div>
    <div class="top-bar-nav">
      <el-menu
        :default-active="$route.path"
        mode="horizontal"
        :router="true"
        ref="menu"
        class="el-menu"
        background-color="#409eff"
        text-color="#fff"
        active-text-color="#ffd04b"
      >
        <el-menu-item
          :index="item.route"
          v-for="item in insideRoute"
          :key="item.id"
        >
          <!-- <i :class="item.icon ? item.icon : 'el-icon-setting'"></i> -->
          <span slot="title">{{ item.title }}</span>
        </el-menu-item>
      </el-menu>
    </div>
    <div class="top-bar-avatar">
      <div class="avatar"><el-avatar> user </el-avatar></div>
      <el-dropdown @command="handleCommand">
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
</template>

<script>
export default {
  name: "topBar",
  created() {},
  props: {},
  computed: {
    showTitle: function () {
      if (this.$route.fullPath === "/projectList") {
        return;
      }

      let routerStr = "";
      if (this.$store.state.project.title) {
        routerStr = " > " + this.$store.state.project.title;
        if (this.$route.name == "apiList") {
          routerStr += " > api";
        } else if (this.$route.name == "docList") {
          routerStr += " > 文档";
        }
      }
      return routerStr;
    },
    nickName: function () {
      return this.$store.state.userInfo.nick_name;
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
      // {
      //   title: "个人中心",
      //   route: "/myCenter",
      //   icon: "el-icon-s-operation",
      // },
    ];

    if (this.$store.state.userInfo.type == 2) {
      route.push({
        title: "用户管理",
        route: "/userManager",
        icon: "el-icon-user",
      });
    }

    return {
      insideRoute: route,
    };
  },
};
</script>

<style scoped>
.top-bar {
  display: flex;
  width: 85%;
  margin: 0 auto;
  position: relative;
}
.top-bar .top-bar-title {
  margin: 0 20px 0 10px;
  display: flex;
  align-items: center;
}

.top-bar-title{
  color:#fff;
  font-weight: bold;
}

.top-bar .top-bar-avatar {
  height: 61px;
  display: flex;
  align-items: center;
  position: absolute;
  right: 10px;
}
</style>
