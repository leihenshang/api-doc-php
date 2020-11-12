<template>
  <div class="user-center">
    <div class="user-content">
      <div class="avatar">
        <img src="../../assets/logo.png" width="100" />
      </div>
      <div class="info">
        <ul>
          <li>
            <em>登录名：</em>
            <p>{{userInfo.name}}</p>
          </li>
          <li class="nick-name-li">
            <em>昵称：</em>
            <p>{{userInfo.nick_name}}</p>
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
          <el-button @click="dialogFormVisible = true" type="primary" size="small">修改密码</el-button>
          <el-button size="small"  type="primary" @click="updateNickName()">修改昵称</el-button>
        </div>
      </div>
    </div>
    <el-dialog title="新建用户" :visible.sync="dialogFormVisible" width="30%">
      <el-form :model="form" label-width="80px" ref="form" :rules="rules">
        <el-form-item label="旧密码" prop="old_pwd">
          <el-input v-model="form.old_pwd" autocomplete="off" type="password" placeholder="旧密码"></el-input>
        </el-form-item>
        <el-form-item label="密码" prop="pwd">
          <el-input v-model="form.pwd" autocomplete="off" type="password" placeholder="密码"></el-input>
        </el-form-item>
        <el-form-item label="重复密码" prop="re_pwd">
          <el-input v-model="form.re_pwd" autocomplete="off" type="password" placeholder="重复密码"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" @click="updatePwd()">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
const CODE_OK = 200;

export default {
  name: "userCenter",
  data() {
    //自定义的 密码验证，判断两次密码是否一致
    var validatePass = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请输入密码"));
      } else {
        if (this.form.pwd !== "") {
          this.$refs.form.validateField("re_pwd");
        }
        callback();
      }
    };
    var reValidatePass = (rule, value, callback) => {
      if (value === "") {
        callback(new Error("请再次输入密码"));
      } else if (value !== this.form.pwd) {
        callback(new Error("两次输入密码不一致!"));
      } else {
        callback();
      }
    };

    return {
      userInfo: {},
      editNickName: false,
      form: {
        old_pwd: "",
        pwd: "",
        re_pwd: ""
      },
      dialogFormVisible: false,
      rules: {
        old_pwd: [
          { required: true, message: "请输入密码", trigger: "blur" },
          {
            min: 6,
            max: 50,
            message: "长度在 6 到 50 个字符",
            trigger: "blur"
          }
        ],
        pwd: [
          { required: true, message: "请输入密码", trigger: "blur" },
          {
            min: 6,
            max: 50,
            message: "长度在 6 到 50 个字符",
            trigger: "blur"
          },
          { validator: validatePass, trigger: "blur" }
        ],
        re_pwd: [
          { required: true, message: "请再次输入密码", trigger: "blur" },
          {
            min: 6,
            max: 50,
            message: "长度在 6 到 50 个字符",
            trigger: "blur"
          },
          { validator: reValidatePass, trigger: "blur" }
        ]
      }
    };
  },
  created() {
    this.getUserInfo();
    if (!this.userInfo) {
      return this.$message.error("没有获取到用户信息");
    }
  },
  methods: {
    //获取用户信息
    getUserInfo() {
      this.$http.get(this.apiAddress + "/user/get-user-info").then(
        res => {
          let response = res.data;
          if (response.code === CODE_OK) {
            this.userInfo = response.data;
          } else {
            this.$message.error("failed:" + response.msg);
          }
        },
        () => {
          this.$message.error("获取数据失败");
        }
      );
    },
    //更新密码
    updatePwd() {
      this.$refs.form.validate(valid => {
        if (valid) {
          if (this.form.pwd === this.form.old_pwd) {
            this.$message.error("新旧密码不能相同");
            return;
          }

          this.$http
            .post(
              this.apiAddress + "/user/update-pwd",
              {
                oldPwd: this.form.old_pwd,
                newPwd: this.form.pwd,
                rePwd: this.form.re_pwd
              },
             
            )
            .then(
              res => {
                let response = res.data;
                if (response.code !== CODE_OK) {
                  this.$message.error(response.msg);
                } else {
                  this.$message.success("success");
                  this.getUserInfo();
                  this.dialogFormVisible = false;
                  this.$refs.form.resetFields();
                }
              },
              () => {
                this.$message.error("请求发生错误");
              }
            );
        } else {
          return false;
        }
      });
    },
    updateNickName() {
      this.$prompt("请修改昵称", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        inputValue: this.userInfo.nick_name,
        inputPattern: /.{1,50}/,
        inputErrorMessage: "昵称不正确"
      })
        .then(({ value }) => {
          //验证名字是否一样
          if (value === this.userInfo.nick_name) {
            this.$message.error("昵称没有修改");
            return;
          }

          this.$http
            .post(
              this.apiAddress + "/user/update-nickname",
              {
                nickname: value
              },
             
            )
            .then(
              res => {
                let response = res.data;
                if (response.code !== CODE_OK) {
                  this.$message.error("failed:" + response.msg);
                  return;
                } else {
                  this.getUserInfo();
                  this.userInfo.nick_name = value;
                  this.$store.commit("saveUserInfo", this.userInfo);
                  this.$message({
                    type: "success",
                    message: "你的新昵称是: " + value
                  });
                }
              },
              () => {
                this.$message.error("请求发生错误");
              }
            );
        })
        .catch(() => {
          this.$message({
            type: "info",
            message: "取消输入"
          });
        });
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
  border: 1px solid rgb(195, 195, 195);
  width: 40%;
  margin: 100px auto;
  padding: 50px 0;
  position: relative;
  background-color: #fff;
  border-radius: 10px;
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
</style>