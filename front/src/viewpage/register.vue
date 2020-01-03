<template>
  <div class="register">
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
          <a href="javascript:void(0)">登陆</a>
        </li>
      </ul>
    </div>
    <div class="middle">
      <h4>用户注册</h4>
      <ValidationObserver ref="form" vid="form" tag="div">
        <ul>
          <li>
            <span>用户名</span>
            <validation-provider
              rules="required"
              v-slot="{ errors }"
              vid="name"
              name="name"
              tag="i"
            >
              <input type="text" name="name" v-model="userInfo.name" placeholder="请输入昵称" />
              <em>{{ errors[0] }}</em>
            </validation-provider>
          </li>
          <li>
            <span>邮箱</span>
            <validation-provider
              rules="required|email"
              v-slot="{ errors }"
              vid="email"
              name="email"
              tag="i"
            >
              <input type="email" name="email" v-model="userInfo.email" placeholder="请输入邮箱" />
              <button @click="sendCode()">发送验证码</button>
              <em>{{ errors[0] }}</em>
            </validation-provider>
          </li>
          <li>
            <span>验证码</span>
            <validation-provider
              rules="required"
              v-slot="{ errors }"
              vid="code"
              name="code"
              tag="i"
            >
              <input
                type="text"
                name="code"
                v-model="userInfo.code"
                placeholder="请输入验证码"
                autocomplete="off"
              />
              <em>{{ errors[0] }}</em>
            </validation-provider>
          </li>
          <li>
            <span>密码</span>
            <validation-provider rules="required" v-slot="{ errors }" vid="pwd" name="pwd" tag="i">
              <input
                type="password"
                name="pwd"
                v-model="userInfo.pwd"
                placeholder="请输入密码"
                autocomplete="off"
              />
              <em>{{ errors[0] }}</em>
            </validation-provider>
          </li>
          <li>
            <span>重复密码</span>
            <validation-provider
              rules="required"
              v-slot="{ errors }"
              vid="re_pwd"
              name="re_pwd"
              tag="i"
            >
              <input type="password" name="re_pwd" v-model="userInfo.re_pwd" placeholder="请重复一次密码" />
              <em>{{ errors[0] }}</em>
            </validation-provider>
          </li>

          <li>
            <span></span>
            <button @click="register()">提交注册</button>
            <button>取消</button>
          </li>
        </ul>
      </ValidationObserver>
    </div>
    <div class="bottom">
      <p>该开源网站由api doc提供技术支持，开源协议遵循MIT，如需获取最新的api doc开源版以及相关资讯，请点击这里</p>
    </div>
  </div>
</template>
<script>
const CODE_OK = 200;
export default {
  name: "register",
  data() {
    return {
      userInfo: {
        pwd: "",
        re_pwd: "",
        name: "",
        email: "",
        code: ""
      },
      userInfoDefault: {
        pwd: "",
        re_pwd: "",
        name: "",
        email: "",
        code: ""
      }
    };
  },
  created() {},
  methods: {
    //发送验证码
    sendCode: function() {
      if (!this.userInfo.email) {
        alert("邮箱不能为空");
        return;
      }

      this.$http
        .get(this.apiAddress + "/message/send", {
          params: {
            email: this.userInfo.email
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              alert("发送成功:" + JSON.stringify(response.data));
            } else {
              alert("发送失败:" + response.msg);
            }
          },
          res => {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    //用户注册
    register() {
      //执行验证
      this.$refs.form.validate().then(res => {
        if (!res) {
          return;
        }
        this.$http
          .post(
            this.apiAddress + "/user/reg",
            {
              ...this.userInfo
            },
            { emulateJSON: true }
          )
          .then(
            response => {
              response = response.body;
              if (response.code === CODE_OK) {
                alert("成功！~");
                this.userInfo = this.userInfoDefault;
                this.$router.push("/login");
              } else {
                alert("注册失败:" + response.msg);
              }
            },
            response => {
              response = response.body;
              alert("操作失败!" + !response.msg ? response.msg : "");
            }
          );
      });
    }
  }
};
</script>
<style scoped>
.register .middle {
  border: 1px solid rgb(175, 175, 175);
  width: 50%;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 750px;
  padding: 30px;
  border-radius: 10px;
  box-sizing: border-box;
}

.middle span {
  width: 100px;
  display: inline-block;
  text-align: right;
  margin-right: 10px;
}

.middle ul {
  margin: 0 0 0 50px;
}

.middle li {
  display: inline-block;
  width: auto;
  margin: 5px 0;
}
.middle input {
  width: 300px;
  height: 30px;
  margin-right: 10px;
}

.middle h4 {
  text-align: center;
  margin: 20px 0;
}

.middle button {
  height: 30px;
  width: 80px;
}

.middle em {
  color: red;
}
</style>