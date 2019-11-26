
<template>
  <div class="login-page">
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
        <li class="li-r">
          <a href="#">注册</a>
        </li>
      </ul>
    </div>
    <div class="middle">
      <div class="login-page-content">
        <div class="title">
          <span>apiDoc 0.1</span>
        </div>
        <div class="login-box">
          <input type="text" name="username" placeholder="请输入用户名" v-model="username"/>
          <input type="password" name="pwd" placeholder="请输入密码" v-model="pwd" />
          <button @click="login()">
            <span>登陆</span>
            <em>》</em>
          </button>
        </div>
        <div class="remember">
          <input type="checkbox" name="remember" id="remember" />
          <label for="remember">记住密码</label>
        </div>
      </div>
    </div>
    <div class="bottom">
      <p>该开源网站由api doc提供技术支持，开源协议遵循MIT，如需获取最新的api doc开源版以及相关资讯，请点击这里</p>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
const CODE_OK = 200;

export default {
    name:"loginPage",
    data(){
        return {
            username:'',
            pwd:''
        };
    },
    methods:{
        login:function(){
     this.$http
        .post(
          this.apiAddress + "/user/login",
          {
            name: this.username,
            pwd: this.pwd,
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
               alert("成功！~");
          Vue.prototype.userInfo = response.data;
          // this.$userInfo = response.data;
                this.$router.push('/');
              
            }
          },
          function(res) {
            let response = res.body;
            alert("操作失败!" + !response.msg ? response.msg : "");
            return;
          }
        );
        }
    }
};
</script>
<style>
.login-page a {
  text-decoration: none;
}

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

.login-page-top span {
  float: right;
  display: block;
  margin-right: 1%;
  border: 1px solid gray;
  height: 58px;
  width: 80px;
  text-align: center;
  line-height: 60px;
}

/* 中间内容开始 */
.login-page-content {
  position: absolute;
  left: 50%;
  top: 30%;
  transform: translate(-50%);
}

.login-page-content .title {
  height: 140px;
  font-size: 50px;
  line-height: 140px;
  text-align: center;
}

.login-box {
  /* overflow: hidden; */
  height: 32px;
}

.login-box input {
  outline: none;
  height: 30px;
  width: 200px;
  border: 1px solid #ddd;
  border-radius: 3px;
  padding-left: 5px;
  margin-right: 5px;
}

.login-box input:hover {
  border-color: #43a047;
}

.login-box button {
  box-sizing: border-box;
  background-color: #4caf50;
  color: #fff;
  border: 1px solid #43a047;
  width: 225px;
  height: 32px;
  border-radius: 3px;
  text-align: left;
  text-indent: 10px;
  vertical-align: bottom;
  cursor: pointer;
  line-height: 32px;
}

.login-box button:hover {
  border: 1px solid #4caf50;
  background-color: #43a047;
  color: #fff;
}

.login-box button em {
  margin-right: 10px;
  float: right;
  font-style: normal;
}

.remember {
  text-align: right;
  margin-top: 10px;
  font-size: 14px;
  color: #666;
  height: 20px;
  line-height: 20px;
}

.remember input {
  vertical-align: middle;
}

.remember label {
  vertical-align: middle;
  cursor: pointer;
}
.remember label:hover {
  color: black;
}

/* 中间内容结束 */

/* 底部开始 */
.bottom {
  height: 50px;
  border-top: 1px solid #e5e5e5;
  background-color: #f1f1f1;
  width: 100%;
  position: fixed;
  bottom: 0;
  line-height: 50px;
}

.bottom p {
  font-size: 14px;
  text-align: center;
}
</style>
