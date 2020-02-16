<template>
  <div class="top-bar">
    <ul>
      <li class="t-link">
        <a href="#">(●'◡'●)</a>
      </li>
      <li class="name">
        <span>apiDoc开源版本</span>
      </li>
      <li>
        <!-- <span>API接口>电子社-工信书院>项目概况</span> -->
        <span>{{showTitle}}</span>
      </li>
      <li class="t-r">
        <em>hello, {{nickName}}</em>
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
import Vue from "vue";

export default {
  name: "topBar",
  created() {},
  props: {},
  computed: {
    showTitle: function() {
      if (this.$route.path === "/") {
        return "首页";
      } else {
        if (this.$store.state.project.title) {
          return "首页>项目详情-" + this.$store.state.project.title;
        }

        return "";
      }
    },
    nickName: function() {
      return this.$store.state.userInfo.nick_name;
    }
  },
  methods: {
    //退出登录
    loginOut() {
      localStorage.removeItem("userInfo");
      Vue.prototype.userInfo = null;
      this.$store.commit("saveUserInfo", {});
      this.$router.push("/login");
    },
    //到个人中心
    goToUserCenter() {
      this.$router.push({ name: "userCenter" });
    }
  },
  data: function() {
    return {};
  }
};
</script>

<style scoped>
/* <!-- 头部导航栏开始 --> */
.top-bar {
  height: 50px;
  line-height: 50px;
  border-bottom: 1px solid #e5e5e5;
  font-size: 14px;
}

.top-bar ul {
  overflow: hidden;
  /* width: 100%; */
}

.top-bar li {
  float: left;
}

.top-bar .t-r {
  float: right;
  border-left: 1px solid #e5e5e5;
}

.top-bar .t-r span {
  font-size: 14px;
}

.top-bar .t-link {
  padding: 0 15px;
  border-right: 1px solid #e5e5e5;
}

.top-bar .t-link a {
  color: #999;
}

.top-bar .name {
  width: 155px;
  padding-left: 10px;
}

.top-bar span {
  color: #999;
}

.top-bar em {
  display: block;
  padding: 0 14px;
  font-style: normal;
}

.top-bar em:hover {
  color: white;
  background-color: #4caf50;
}

.user-lay {
  border: 1px solid #e5e5e5;
  width: 200px;
  height: 200px;
  background-color: #fff;
  position: absolute;
  right: 0;
  /* margin: 5px 0; */
  z-index: 1;
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
</style>
