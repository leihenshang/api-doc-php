
<template>
  <div class="group">
    <h4>
      <span>分组</span>
    </h4>
    <ul v-show="group">
      <li>
        <a href="javascript:;" @click="clientBtn(null,null)">
          <i class="el-icon-s-order"></i>
          <slot>全部条目</slot>
        </a>
      </li>
      <li class="last-item">
        <a href="javascript:;" @click="clientBtn(-1,null)">
          <i class="el-icon-delete"></i> 回收站
        </a>
      </li>
      <li v-for="(item,index) in group" :key="item.id" :class="{'li-click' : item.isClick }">
        <a href="javascript:;" @click="clientBtn(item.id,index)">{{item.title}}</a>
        <div class="btn-group" v-show="showIsEdit === true">
          <el-dropdown size="small" placement="left-start" @command="handleCommand" trigger="click">
            <span class="el-icon-s-unfold"></span>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item :command="{action:'del',data:item}">删除</el-dropdown-item>
              <el-dropdown-item :command="{action:'edit',data:item}">编辑</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "group",
  props: {
    showCreateGroup: Boolean,
    showIsEdit: {
      type: Boolean,
      default: false
    },
    type: {
      type: Number,
      default: 0
    }
  },
  created() {
    if (this.group.length < 1) {
      this.getGroup(this.pageSize, this.curr, this.$route.params.id);
    }
  },
  data() {
    return {
      newGroup: "",
      group: [],
      isEdit: false,
      visible: false,
      curr: 1,
      pageSize: 100
    };
  },
  methods: {
    handleCommand(command) {
      if (command.action === "del") {
        this.del(command.data.id);
      } else if (command.action === "edit") {
        this.editGroup(command.data);
      }
    },
    //获取分组列表
    getGroup(pageSize, curr, projectId) {
      this.$http
        .get(this.apiAddress + "/group/list", {
          params: {
            cp: curr,
            type: this.type,
            ps: pageSize,
            projectId: projectId ? projectId : 0
          }
        })
        .then(
          response => {
            response = response.data;
            if (response.code === CODE_OK) {
              if (response.data) {
                for (const key in response.data) {
                  response.data[key].isClick = false;
                }
                this.group = response.data;
              }
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
    //删除分组
    del(id) {
      if (!id) {
        this.$message.error("id错误");
        return;
      }

      this.$confirm("该分组将被删除, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$http
            .post(
              this.apiAddress + "/group/del",
              {
                id: id,
                token: this.$store.state.userInfo.token
              },
             
            )
            .then(response => {
              response = response.data;
              if (response.code === CODE_OK) {
                this.$message.success("成功!");
              } else {
                this.$message.error("操作失败");
              }
              this.getGroup(this.pageSize, this.curr, this.$route.params.id);
            });
        })
        .catch(() => {});
    },
    //点击分组
    clientBtn(id, index) {
      for (const key in this.group) {
        this.group[key].isClick = false;
      }
      if (index !== null) {
        this.group[index].isClick = true;
      }

      this.$emit("change-group", id);
    },
    //更新数据
    editGroup(data) {
      this.$prompt("请修改分组名", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        inputPattern: /.{2,100}/,
        inputValue: data.title,
        inputErrorMessage: "组名格式不正确"
      })
        .then(({ value }) => {
          this.$http
            .post(
              this.apiAddress + "/group/update",
              {
                title: value,
                id: data.id,
                type: this.type
              },
             
            )
            .then(
              response => {
                response = response.data;
                if (response.code === CODE_OK) {
                  this.$message.success("更新成功!");
                } else {
                  this.$message.error(response.msg);
                }

                this.getGroup(this.pageSize, this.curr, this.$route.params.id);
              },
              res => {
                let response = res.body;
                this.$message.error(
                  "获取数据-操作失败!" + !response.msg ? response.msg : ""
                );
              }
            );
        })
        .catch(() => {});
    }
  },
  watch: {
    showCreateGroup: function() {
      this.$prompt("请输入分组名", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        inputPattern: /.{2,100}/,
        inputErrorMessage: "组名格式不正确"
      })
        .then(({ value }) => {
          this.$http
            .post(
              this.apiAddress + "/group/create",
              {
                title: value,
                project_id: this.$route.params.id,
                type: this.type
              },
             
            )
            .then(
              response => {
                response = response.data;
                if (response.code === CODE_OK) {
                  this.$message.success("创建成功!");
                } else {
                  this.$message.error(response.msg);
                }

                this.getGroup(this.pageSize, this.curr, this.$route.params.id);
                // this.showCreateGroup =
              },
              res => {
                let response = res.body;
                this.$message.error(
                  "获取数据-操作失败!" + !response.msg ? response.msg : ""
                );
              }
            );
        })
        .catch(() => {
          this.getGroup(this.pageSize, this.curr, this.$route.params.id);
        });
    },
    $route: function(to) {
      if (to.params.groupId == 0) {
        this.getGroup(this.pageSize, this.curr, this.$route.params.id);
      }
    }
  },
  components: {}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.group {
  width: 100%;
  height: 100%;
  box-sizing: border-box;
  padding: 2px;
  background-color: #fff;
  overflow-y: auto;
}

.group h4 {
  font-size: 14px;
  padding: 5px 0 0 15px;
  position: relative;
}

.group h4 span {
  display: inline-block;
}

.group ul li {
  width: 100%;
  overflow: hidden;
  display: flex;
  margin: 8px 0;
  height: 32px;
  line-height: 32px;
}

.group ul li.last-item {
  border-bottom: 1px solid rgb(228, 219, 219);
  padding-bottom: 6px;
}

.btn-group {
  overflow: hidden;
  width: 120px;
  line-height: 32px;
  text-align: center;
}

.group ul li a {
  display: inline-block;
  width: 100%;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  font-size: 14px;
  height: 28px;
  color: rgb(75, 74, 74);
  margin-left: 8px;
  padding-left: 10px;
  height: 100%;
}

.group ul li i {
  margin-right: 5px;
}

.group ul li:hover {
  background-color: #e3f1e5;
}

.group ul li:hover a {
  color: black;
}

.li-click {
  background-color: rgba(24, 173, 49, 0.603);
}

ul li.li-click a {
  color: #fff;
}
</style>
