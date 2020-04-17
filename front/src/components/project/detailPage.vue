<template>
  <div class="detailPage">
    <div class="right-l">
      <div class="title">
        <span>{{projectData.title}}</span>
      </div>
      <div class="desc">
        <p>{{projectData.description}}</p>
      </div>
      <ul>
        <li>
          <p>项目类型</p>
          <p>{{projectData.type}}</p>
        </li>
        <li>
          <p>项目版本</p>
          <p>{{projectData.version}}</p>
        </li>
        <li>
          <p>创建时间</p>
          <p>{{projectData.create_time}}</p>
        </li>
        <li @click="jump()" class="api-detail">
          <p>api接口</p>
          <p>点击查看详情</p>
        </li>
      </ul>
      <div class="user-wrapper">
        <div class="user-search">
          <el-input
            placeholder="请输入用户名或邮箱"
            v-model="keyword"
            class="input-with-select"
            size="small"
            maxlength="30"
          >
            <el-button slot="append" icon="el-icon-search"></el-button>
          </el-input>
        </div>
        <div class="user-box">
          <div v-for="item in userList" :key="item.id" class="user-item">
            <div class="avatar">
              <el-avatar>{{item.nick_name[0].toUpperCase()}}</el-avatar>
            </div>
            <div class="info">
              <p>{{item.nick_name}}</p>
              <p>{{item.type == 1 ? '普通用户' : '管理员' }}</p>
              <p>{{item.email}}</p>
            </div>
          </div>
        </div>
      </div>
      <!-- 右侧内容结束 -->
    </div>
    <div class="right-r">
      <message />
    </div>
  </div>
</template>

<script>
import Message from "./message";

const CODE_OK = 200;
export default {
  name: "detailPage",
  props: {
    id: String
  },
  created() {
    this.getDetail();
    this.getUserList();
  },
  data() {
    return {
      keyword: "",
      projectData: {},
      indesideRoute: [
        { title: "项目概况", route: "detail", child: "detailPage" },
        { title: "API接口", route: "detail", child: "apiPage" }
      ],
      userList: []
    };
  },
  methods: {
    //获取项目详情
    getDetail() {
      this.$http
        .get(this.apiAddress + "/project/detail", {
          params: {
            id: this.$route.params.id,
            token: this.$store.state.userInfo.token
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.projectData = response.data;
              this.$store.commit("saveProject", response.data);
            } else {
              this.$message.error("failed:" + response.msg);
            }
          },
          res => {
            let response = res.body;
            this.$message.error(
              "获取数据-操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },
    //获取用户列表
    getUserList(keyword) {
      this.$http
        .get(this.apiAddress + "/user/list", {
          params: {
            keyword,
            project_id: this.$route.params.id
          }
        })
        .then(response => {
          response = response.body;
          if (response.code === CODE_OK) {
            this.userList = response.data;
          }
        });
    },
    jump() {
      this.$router.push({
        name: "apiPage",
        params: { projectId: this.id }
      });
    }
  },
  components: {
    message: Message
  }
};
</script>

<style scoped>
.detailPage {
  display: flex;
  width: 100%;
  height: 100%;
}

.user-search {
  margin-top: 15px;
}

.user-search .el-input {
  width: 50%;
}

.user-box {
  background-color: #fff;
  margin-top: 15px;
  border: 1px solid #e5e5e5;
  display: flex;
}

.user-item {
  flex: 1;
  position: relative;
  border-right: 1px solid #e5e5e5;
  padding: 10px;
  box-sizing: border-box;
}

.user-item:last-child {
  border: none;
}

.user-item .info {
  float: left;
  font-size: 14px;
}

.user-item .avatar {
  float: left;
  width: 20%;
  text-align: center;
  margin-top: 10px;
}

.user-item .avatar .el-avatar {
  background-color: #409eff;
}

.right-l {
  width: 50%;
  height: 100%;
  padding: 5px;
  box-sizing: border-box;
  border-radius: 3px;
  overflow: hidden;
}

.right-l .title {
  height: 100px;
  border-top: 1px solid #e5e5e5;
  border-left: 1px solid #e5e5e5;
  border-right: 1px solid #e5e5e5;
  line-height: 100px;
  padding-left: 20px;
  font-weight: 700;
  font-size: 2em;
  color: #4caf50;
  background-color: #fff;
}

.desc {
  border-bottom: 1px solid #e5e5e5;
  border-left: 1px solid #e5e5e5;
  border-right: 1px solid #e5e5e5;
  padding: 0 0 10px 20px;
  font-size: 18px;
  color: #7e7d7d;
  background-color: #fff;
}

.right-l ul {
  width: 100%;
  display: flex;
  background-color: #fff;
}

.right-l ul.two {
  margin: 20px 0;
  border-top: 1px solid #e5e5e5;
}

.right-l ul li {
  flex: 1;
  height: 80px;
  border-right: 1px solid #e5e5e5;
  border-bottom: 1px solid #e5e5e5;
  list-style: none;
}

.right-l ul li:first-child {
  border-left: 1px solid #e5e5e5;
}

.right-l ul li p:first-child {
  font-size: 18px;
  margin: 10px 15px;
}

.right-l ul li p:last-child {
  font-size: 12px;
  color: gray;
  margin: 10px 15px;
}

ul:nth-child(5) {
  margin-top: 20px;
  border-top: 1px solid #e5e5e5;
}

.right-r {
  width: 50%;
  height: 100%;
  background-color: #f3f3f3;
}

.api-detail {
  background-color: #5ace5e6e;
}

.api-detail:hover {
  background-color: #5ace5e;
}
</style>
