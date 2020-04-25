<template>
  <div class="login-page-top">
    <ul>
      <li>
        <a href="#" style="color:#4caf50">首页</a>
      </li>
      <li>
        <a href="#">官方网站</a>
      </li>
      <li>
        <a href="#">官方社区</a>
      </li>
      <li>
        <a href="#">关于apidoc</a>
      </li>
      <li>
        <a href="#">用户讨论群</a>
      </li>
      <li class="li-r" @click="toLogin()" v-if="$route.name == 'register'">
        <a href="javascript:void(0)">登陆</a>
      </li>
        <li class="li-r" @click="jumpRegister()" v-else-if="$route.name == 'userLogin'">
        <!-- <a href="javascript:void(0)">注册</a> -->
      </li>
    </ul>
  </div>
</template>

<script>

export default {
  name: "homeHeader",
  methods: {
    toLogin() {
      this.$router.push({ name: "userLogin" });
    },
    //跳转注册页
    jumpRegister() {
      this.$router.push({name:"register"});
    }
  },
  created(){
  }
};
</script>

<style scoped>

.login-page-top {
  height: 60px;
  border-bottom: 1px solid #ededed;
}

.login-page-top ul {
  overflow: hidden;
  height: 100%;
  line-height: 60px;
}

.login-page-top ul li {
  list-style: none;
  float: left;
  margin-left: 2%;
}

.login-page-top ul li a {
  font-size: 14px;
  color: #777777;
}

.login-page-top ul li a:hover {
  color: #4caf50;
}

.login-page-top .li-r {
  float: right;
  margin-right: 2%;
}

.login-page-top .li-r a {
  border: 1px solid #4caf50;
  padding: 7px 20px;
  border-radius: 3px;
  color: #4caf50;
}

.login-page-top .li-r a:hover {
  background-color: #4caf50;
  color: #ffffff;
}

.login-page-top em:first-child {
  float: right;
  display: block;
  margin-right: 1%;
  border: 1px solid gray;
  height: 58px;
  width: 80px;
  text-align: center;
  line-height: 60px;
}



</style>