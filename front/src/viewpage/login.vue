
<template>
  <div class="login-page">
    <homeHeader />
    <div class="middle">
      <div class="login-page-content">
        <div class="title">
          <span>apiDoc 0.1</span>
        </div>
        <div class="login-box">
          <ValidationObserver ref="form" vid="form">
            <validation-provider
              rules="required"
              v-slot="{ errors }"
              vid="username"
              name="username"
            >
              <input type="text" name="username" placeholder="请输入用户名" v-model="username" />
              <span>{{ errors[0] }}</span>
            </validation-provider>
            <validation-provider rules="required" v-slot="{ errors }" vid="pwd" name="pwd">
              <input type="password" name="pwd" placeholder="请输入密码" v-model="pwd" />
              <span>{{ errors[0] }}</span>
            </validation-provider>
            <button @click="login()">
              <span class="login-text">登陆</span>
              <em>〉</em>
            </button>
          </ValidationObserver>
        </div>
        <div class="remember">
          <input type="checkbox" name="remember" id="remember" />
          <label for="remember">记住密码</label>
        </div>
      </div>
    </div>
    <homeFooter />
  </div>
</template>

<script>
import Vue from "vue";
import homeHeader from "../components/common/units/homeHeader";
import homeFooter from "../components/common/units/homeFooter";

const CODE_OK = 200;
const NO_ACTIVATE = 3;

export default {
  name: "loginPage",
  created() {
    this.loginByLocalStorage();
  },
  data() {
    return {
      username: "",
      pwd: ""
    };
  },
  methods: {
    //用户登录
    login() {
      this.$refs.form.validate().then(res => {
        if (!res) {
          return;
        }

        this.$http
          .post(
            this.apiAddress + "/user/login",
            {
              name: this.username,
              pwd: this.pwd
            },
            { emulateJSON: true }
          )
          .then(
            response => {
              response = response.body;
              if (response.code === CODE_OK) {
                let userInfo = response.data;
                Vue.prototype.userInfo = userInfo;
                this.$store.commit("saveUserInfo", userInfo);
                localStorage.setItem("userInfo", JSON.stringify(userInfo));
                if (userInfo.state == NO_ACTIVATE) {
                  this.$router.push({ name: "activate" });
                } else {
                  this.$router.push("/");
                }
              } else {
                this.$message.error("登录错误！" + response.msg);
                localStorage.removeItem("userInfo");
                Vue.prototype.userInfo = null;
                this.$router.push("/login");
              }
            },
            res => {
              let response = res.body;
              this.$message.error(
                "操作失败!" + !response.msg ? response.msg : ""
              );
              return;
            }
          );
      });
    },
    //通过localStorage登录
    loginByLocalStorage() {
      let userInfo1 = JSON.parse(localStorage.getItem("userInfo"));
      if (userInfo1) {
        let currDate = new Date();
        let expireTime = new Date(Date.parse(userInfo1.token_expire_time));
        if (expireTime > currDate) {
          this.$store.commit("saveUserInfo", userInfo1);
          Vue.prototype.userInfo = userInfo1;
          this.$router.push("/");
        } else {
          localStorage.removeItem("userInfo");
        }
      }
    }
  },
  components: {
    homeHeader,
    homeFooter
  }
};
</script>
<style>
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

.login-box span {
  color: red;
}

span.login-text {
  color: white;
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
</style>
