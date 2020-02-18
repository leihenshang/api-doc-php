<template>
  <div class="user-center">
    <div class="user-content">
      <div class="user-return" @click="$router.push({path:'/'})">
        <p>返回首页</p>
      </div>
      <div class="avatar">
        <img src="../assets/logo.png" width="100" />
      </div>
      <div class="info">
        <ul>
          <li>
            <em>登录名：</em>
            <p>{{userInfo.name}}</p>
          </li>
          <li class="nick-name-li">
            <em>昵称：</em>
            <p v-if="editNickName === false">{{userInfo.nick_name}}</p>
            <input v-else type="text" v-model="newNickname" />
            <button
              v-if=" editNickName === false "
              @click="editNickName = !editNickName; newNickname = userInfo.nick_name "
            >修改昵称</button>
            <button v-if=" editNickName === true " @click="updateNickName()">确定</button>
            <button
              v-if=" editNickName === true "
              @click=" editNickName = !editNickName; newNickname = '' "
            >取消</button>
          </li>
          <li>
            <em>邮箱：</em>
            <p>{{userInfo.email}}</p>
          </li>
          <li>
            <em>创建时间：</em>
            <p>{{userInfo.create_time}}</p>
          </li>
          <li>
            <em>用户权限：</em>
            <p>{{userInfo.type_text}}</p>
          </li>
          <li>
            <em>用户状态：</em>
            <p>{{userInfo.state_text}}</p>
          </li>
          <li>
            <em>手机：</em>
            <p>{{userInfo.mobile_number ? userInfo.mobile_number : 'unknown'}}</p>
          </li>
        </ul>
        <div class="btn">
          <button @click="password.update = true">修改密码</button>
        </div>
      </div>
    </div>
    <div class="user-update-pwd" v-if="password.update === true ">
      <ul>
        <li>
          <em>旧密码:</em>
          <input type="password" v-model="password.old" placeholder="输入旧密码" autocomplete="off" />
        </li>
        <li>
          <em>新密码:</em>
          <input type="password" v-model="password.newFirst" placeholder="输入旧密码" />
        </li>
        <li>
          <em>新密码:</em>
          <input type="password" v-model="password.newSecond" placeholder="输入旧密码" />
        </li>
        <li>
          <em></em>
          <button @click="updatePwd()">确定</button>
          <button @click="password.update = false">取消</button>
        </li>
      </ul>
    </div>
    <div class="user-update-pwd-background" v-if="password.update === true"></div>
  </div>
</template>

<script>
const CODE_OK = 200;

export default {
  name: "userCenter",
  data() {
    return {
      userInfo: {},
      editNickName: false,
      newNickname: "",
      password: {
        old: "",
        newFirst: "",
        newSecond: "",
        update: false
      }
    };
  },
  created() {
    this.getUserInfo();
    if (!this.userInfo) {
      return alert("没有获取到用户信息");
    }
  },
  methods: {
    //获取用户信息
    getUserInfo() {
      this.$http.get(this.apiAddress + "/user/get-user-info").then(
        res => {
          let response = res.body;
          if (response.code === CODE_OK) {
            this.userInfo = response.data;
          } else {
            alert("failed:" + response.msg);
          }
        },
        () => {
          alert("获取数据失败");
        }
      );
    },
    //更新昵称
    updateNickName() {
      //验证名字是否一样
      if (this.newNickname === this.userInfo.nick_name) {
        alert("昵称没有修改");
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/user/update-nickname",
          {
            nickname: this.newNickname
          },
          { emulateJSON: true }
        )
        .then(
          res => {
            let response = res.body;
            if (response.code !== CODE_OK) {
              alert("failed:" + response.msg);
              return;
            } else {
              this.getUserInfo();
              this.userInfo.nick_name = this.newNickname;
              this.$store.commit("saveUserInfo", this.userInfo);
            }
          },
          () => {
            alert("请求发生错误");
          }
        );

      this.editNickName = !this.editNickName;
    },
    //更新密码
    updatePwd() {
      if (
        this.password.old == "" ||
        this.password.newFirst == "" ||
        this.password.newSecond == ""
      ) {
        alert("密码不能为空");
        return;
      }

      if (this.password.newFirst !== this.password.newSecond) {
        alert("新密码重复数据不一致");
        return;
      }
      if (this.password.newFirst === this.password.old) {
        alert("新旧密码不能相同");
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/user/update-pwd",
          {
            oldPwd: this.password.old,
            newPwd: this.password.newFirst,
            rePwd: this.password.newSecond
          },
          { emulateJSON: true }
        )
        .then(
          res => {
            let response = res.body;
            if (response.code !== CODE_OK) {
              alert("failed:" + response.msg);
              return;
            } else {
              alert("success");
              this.getUserInfo();
              this.password.update = !this.password.update;
            }
          },
          () => {
            alert("请求发生错误");
          }
        );
    }
  },
  computed: {}
};
</script>

<style scoped>
.user-center {
  width: 100%;
  height: 100%;
}

.user-content {
  border: 1px solid black;
  width: 40%;
  margin: 200px auto;
  padding: 50px 0;
  position: relative;
}

.user-return {
  position: absolute;
  top: 0;
  right: 0;
  border: 1px solid black;
  margin: 2px;
  padding: 4px;
}

.user-return:hover {
  background-color: rgb(13, 163, 63);
  color: #fff;
}

.avatar {
  text-align: center;
}

.info ul {
  width: 350px;
  margin: 0 auto;
}

.info ul li {
  margin: 10px 0;
  border-bottom: 1px dashed gray;
  padding-bottom: 10px;
}

.nick-name-li p {
  width: 140px;
}

.nick-name-li input {
  height: 20px;
}

.nick-name-li button {
  float: right;
}

.info ul em {
  width: 100px;
  display: inline-block;
  text-align: right;
  margin-right: 40px;
  font-style: normal;
  font-size: 14px;
}

.info ul p {
  display: inline-block;
}

.btn {
  margin: 20px 0;
  width: 350px;
  margin: 0 auto;
  text-align: right;
}

.btn button {
  display: inline-block;
}

.user-update-pwd {
  border: 1px solid black;
  width: 600px;
  height: 200px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1;
  background-color: #fff;
  padding: 40px;
  padding-bottom: 80px;
  box-shadow: 10px 10px;
  border-radius: 5px;
}

.user-update-pwd ul {
  border: 1px solid black;
}

.user-update-pwd ul li {
  margin: 20px 0;
}

.user-update-pwd ul li input {
  height: 30px;
  width: 400px;
}

.user-update-pwd ul em {
  width: 120px;
  text-align: center;
  display: inline-block;
}

.user-update-pwd button {
  width: 60px;
  height: 30px;
}

.user-update-pwd-background {
  position: absolute;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(61, 55, 55, 0.589);
}
</style>