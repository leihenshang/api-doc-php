<template>


  <div class="top-bar">
    <ul class="top-bar-ul">
      <li class="t-link" @click="$router.push('/projectList')">
        <a href="javascript:void(0)">my-doc</a>
      </li>
      <li class="li-menu">

        <el-menu
          :default-active="$route.path"
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
      </li>
      <li class="t-r" style="position: relative">
        <div class="avatar"><el-avatar> user </el-avatar></div>
      </li>

      <li class="t-r">
        <em>{{ nickName ? nickName : "null" }}</em>
        <div class="user-lay" id="user-lay">
          <ul>
            <li>
              <a href="#" @click="loginOut()">退出登陆</a>
            </li>
            <li @click="goToUserCenter()">
              <a href="javascript:void(0)">个人中心</a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
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
/* <!-- 头部导航栏开始 --> */
.top-bar {
  height: 61px;
  line-height: 61px;
  font-size: 14px;
  background-color: #409eff;
}

.top-bar-ul {
  overflow: hidden;
  width: 85%;
  margin: 0 auto;
}

.top-bar li {
  float: left;
  list-style: none;
}

.top-bar li.li-menu {
  width: 800px;
}

.el-menu {
  border-right:none;
}

.top-bar .t-r {
  float: right;
  color: white;
}

.top-bar .t-r span {
  font-size: 14px;
}

.top-bar .t-link {
  padding: 0 15px;
}

.top-bar .t-link a {
  color: white;
  font-weight: 700;
}

.top-bar .name {
  width: 155px;
  padding-left: 10px;
}

.top-bar span {
  color: white;
  display: inline-block;
}

.top-bar em {
  display: inline-block;
  padding: 0 14px;
  font-style: normal;
}

.top-bar em:hover {
  color: white;
  background-color: #66b1ff;
}

.user-lay {
  border: 1px solid #e5e5e5;
  width: 200px;
  height: 200px;
  background-color: #fff;
  position: absolute;
  right: 10%;
  z-index: 9999;
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.12);
  display: none;
}

.user-lay ul {
  overflow: hidden;
}

.user-lay ul li {
  box-sizing: border-box;
  width: 100%;
  float: none;
  height: 50px;
  list-style: none;
}

.user-lay ul li a {
  display: block;
  color: black;
  padding-left: 10px;
  width: 100%;
  height: 100%;
}

.user-lay ul li a:hover {
  background-color: #f0f0f0;
}

.top .t-r:hover .user-lay {
  display: block;
}

div.avatar {
  position: absolute;
  top: 9px;
  right: 90px;
}
</style>
