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
          <p>
            <el-link type="danger">点击查看详情</el-link>
          </p>
        </li>
      </ul>
      <div class="user-wrapper">
        <div class="user-search">
          <el-select
            v-model="keyword"
            filterable
            remote
            placeholder="输入昵称或邮箱添加成员"
            :remote-method="getUserList"
            :loading="loading"
            size="small"
            @change="addProjectUser($event)"
          >
            <el-option
              v-for="item in searchUserList.list"
              :key="item.id"
              :label="item.nick_name"
              :value="item"
            ></el-option>
          </el-select>
        </div>
        <div class="user-count">共计{{userList.length}}位成员</div>
        <div class="user-box">
          <div v-for="item in userList" :key="item.id" class="user-item">
            <div class="avatar">
              <el-avatar>{{item.nick_name[0].toUpperCase()+item.nick_name[1].toUpperCase()}}</el-avatar>
            </div>
            <div class="info">
              <p>{{item.nick_name}}</p>
              <p>{{item.is_leader == 1 ? '管理员' : '普通用户' }}({{item.permission == 6 ? '读/写':'只读'}})</p>
              <p>{{item.email}}</p>
            </div>

            <el-dropdown
              size="small"
              placement="bottom"
              trigger="click"
              @command="handleCommand"
              v-show="$store.state.projectPermission == 6"
            >
              <i class="el-icon-s-unfold"></i>
              <el-dropdown-menu slot="dropdown">
                <el-dropdown-item
                  :command="{action:'setLeader',data:item}"
                >设为{{item.is_leader == 0 ? '管理员' : '普通用户' }}</el-dropdown-item>
                <el-dropdown-item :command="{action:'updateNickname',data:item}">修改昵称</el-dropdown-item>
                <el-dropdown-item :command="{action:'quit',data:item}">移出项目</el-dropdown-item>
                <el-dropdown-item
                  :command="{action:'setPermission',data:item}"
                >设置{{item.permission == 4 ? '读/写':'只读'}}</el-dropdown-item>
              </el-dropdown-menu>
            </el-dropdown>
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
    this.getProjectUserList();
  },
  data() {
    return {
      loading: false,
      keyword: "",
      projectData: {},
      indesideRoute: [
        { title: "项目概况", route: "detail", child: "detailPage" },
        { title: "API接口", route: "detail", child: "apiPage" }
      ],
      userList: [],
      searchUserList: []
    };
  },
  methods: {
    handleCommand(val) {
      switch (val.action) {
        case "updateNickname":
          this.updateNickname(val.data);
          break;
        case "setLeader":
          this.setLeader(val.data);
          break;
        case "quit":
          this.quitProject(val.data);
          break;

        case "setPermission":
          this.setPermission(val.data);
          break;

        default:
          break;
      }
    },
    //获取项目用户列表
    getProjectUserList() {
      this.$http
        .get(this.apiAddress + "/project/project-user", {
          params: {
            id: this.$route.params.id
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.userList = response.data;
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
    //增加项目用户
    addProjectUser(val) {
      this.$confirm(
        "将用户" + val.nick_name + "加入该项目, 是否继续?",
        "提示",
        {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning"
        }
      )
        .then(() => {
          this.$http
            .post(
              this.apiAddress + "/project/add-user",
              {
                user_id: val.id,
                project_id: this.$route.params.id
              },
              { emulateJSON: true }
            )
            .then(
              response => {
                response = response.body;
                if (response.code === CODE_OK) {
                  this.getProjectUserList();
                  this.$message.success("操作成功");
                } else {
                  this.$message.error(response.msg);
                }
              },
              () => {
                this.$message.error("操作失败!");
              }
            );
        })
        .catch(() => {});
    },
    //设置用户对项目的读写权限
    setPermission(val) {
      let userPermission = val.permission == 4 ? 6 : 4;
      userPermission = Number.parseInt(userPermission);
      // let oldPermission = Number.parseInt(val.permission);
      this.$confirm("将用户" + val.nick_name + "修改权限, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$http
            .post(
              this.apiAddress + "/project/set-permission",
              {
                userId: val.id,
                permission: userPermission,
                projectId: this.$route.params.id
              },
              { emulateJSON: true }
            )
            .then(
              response => {
                response = response.body;
                if (response.code === CODE_OK) {
                  this.getProjectUserList();
                  this.$message.success("操作成功!");
                } else {
                  this.$message.error("操作失败!");
                }
              },
              () => {
                this.$message.error("操作失败!");
              }
            );
        })
        .catch(() => {});
    },
    //设置项目管理员
    setLeader(val) {
      this.$confirm(
        "将用户" + val.nick_name + "设置为项目管理员, 是否继续?",
        "提示",
        {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning"
        }
      )
        .then(() => {
          this.$http
            .post(
              this.apiAddress + "/project/set-leader",
              {
                userId: val.id,
                projectId: this.$route.params.id,
                cancel: val.is_leader == 1 ? 1 : 0
              },
              { emulateJSON: true }
            )
            .then(
              response => {
                response = response.body;
                if (response.code === CODE_OK) {
                  this.getProjectUserList();
                  this.$message.success("成功!");
                } else {
                  this.$message.error("操作失败");
                }
              },
              () => {
                this.$message.error("请求失败");
              }
            );
        })
        .catch(() => {});
    },
    //修改昵称弹出框
    updateNickname(val) {
      this.$prompt("请输入新昵称", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        inputPattern: /.{2,20}/,
        inputErrorMessage: "昵称不正确",
        inputValue: val.nick_name
      })
        .then(({ value }) => {
          this.$http
            .post(
              this.apiAddress + "/user/update-nickname",
              {
                userId: val.id,
                nickname: value
              },
              { emulateJSON: true }
            )
            .then(response => {
              response = response.body;
              if (response.code === CODE_OK) {
                this.$message.success("操作成功!");
                this.getProjectUserList();
              } else {
                this.$message.error(response.msg);
              }
            });
        })
        .catch(() => {});
    },
    //移除出项目
    quitProject(val) {
      this.$confirm(
        "将用户" + val.nick_name + "移出该项目, 是否继续?",
        "提示",
        {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning"
        }
      )
        .then(() => {
          this.$http
            .post(
              this.apiAddress + "/project/quit-project",
              {
                userId: val.id,
                projectId: this.$route.params.id
              },
              { emulateJSON: true }
            )
            .then(
              response => {
                response = response.body;
                if (response.code === CODE_OK) {
                  this.getProjectUserList();
                  this.$message.success("成功!");
                } else {
                  this.$message.faild(response.msg);
                }
              },
              () => {
                this.$message.error("操作失败!");
              }
            );
        })
        .catch(() => {});
    },
    handleSelect(val) {
      this.$confirm(
        "将用户" + val.nick_name + "加入该项目, 是否继续?",
        "提示",
        {
          confirmButtonText: "确定",
          cancelButtonText: "取消",
          type: "warning"
        }
      )
        .then(() => {
          this.$message({
            type: "success",
            message: "删除成功!"
          });
        })
        .catch(() => {});
    },
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
      if (keyword && keyword.length < 2) {
        return;
      }

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
            this.searchUserList = response.data;
          }
        });
    },
    jump() {
      this.$router.push({
        name: "apiPage",
        params: { projectId: this.id, groupId: 0 }
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

.user-count {
  margin: 8px 0;
  font-size: 14px;
  color: #909399;
}

.user-box {
  background-color: #fff;
  margin-top: 8px;
  /* border: 1px solid #e5e5e5; */
  display: flex;
}

.user-box .el-dropdown {
  float: right;
  position: absolute;
  right: 0;
  bottom: 0;
  padding: 10px;
}

.user-item {
  flex: 0.33;
  position: relative;
  /* border-right: 1px solid #e5e5e5; */
  border: 1px solid #e5e5e5;
  padding: 10px;
  box-sizing: border-box;
}

/* .user-item:last-child {
  border: none;
} */

.user-item .info {
  float: left;
  font-size: 14px;
  margin-left: 10px;
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
  background-color: #fff;
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

.right-r {
  width: 50%;
  height: 100%;
  border-left: solid 1px #e6e6e6;
  box-sizing: border-box;
  padding-left: 5px;
  overflow-y: scroll;
}

.right-l ul li.api-detail p:last-child {
  color: red;
}
</style>
