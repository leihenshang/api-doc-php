<template>
  <div class="project-list">
    <div class="project-list-btn">
      <el-button
        @click="dialogFormVisible = true;action='create' "
        v-show="$store.state.userInfo.type == 2"
        size="mini"
      >+新增项目</el-button>
      <!-- <button>+导入项目</button>
      <button>+开启SDK提交项目</button>-->
    </div>
    <div class="project-list-content">
      <el-table :data="projectList" stripe style="width: 100%" v-loading="loading" height="650">
        <el-table-column prop="title" label="项目名称" width="180"></el-table-column>
        <el-table-column prop="version" label="版本号" width="180"></el-table-column>
        <el-table-column prop="type" label="类型"></el-table-column>
        <el-table-column prop="create_time" label="创建时间"></el-table-column>
        <el-table-column prop label="操作">
          <template slot-scope="scope">
            <el-button
              slot="reference"
              v-show="$store.state.userInfo.type == 2"
              @click="del(scope.row.id)"
              size="mini"
            >删除</el-button>
            <el-button
              type="warning"
              plain
              @click="action='update';  updateData =  scope.row;  dialogFormVisible = true;  "
              v-show="$store.state.userInfo.type == 2"
              size="mini"
            >编辑</el-button>
            <el-button type="success" plain @click="detail(scope.row.id)" size="mini">详情</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div class="page-wrapper">
      <page :curr="currPage" :itemCount="itemCount" :pageSize="pageSize" v-on:jump-page="jumpPage" />
    </div>
    <el-dialog
      :title=" action=='create' ? '添加项目' : '修改项目'"
      :visible.sync="dialogFormVisible"
      width="40%"
    >
      <el-form
        :model=" action == 'create' ? form : updateData"
        label-width="80px"
        ref="form"
        :rules="rules"
        size="small"
      >
        <el-form-item label="项目名称" prop="title">
          <el-input v-model="form.title" autocomplete="off" placeholder="项目名称"></el-input>
        </el-form-item>
        <el-form-item label="版本号" prop="version">
          <el-input v-model="form.version" autocomplete="off" placeholder="版本号"></el-input>
        </el-form-item>
        <el-form-item label="项目类型" prop="type">
          <el-select v-model="form.type" placeholder="请选择">
            <el-option label="pc" value="pc"></el-option>
            <el-option label="web" value="web"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="项目描述" prop="description">
          <el-input type="textarea" :rows="4" placeholder="请输入内容" v-model="form.description"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false;$refs.form.resetFields()">取 消</el-button>
        <el-button type="primary" @click=" action=='create' ? create() : update()">确 定</el-button>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import page from "../common/page";
const CODE_OK = 200;
const PAGE_SIZE = 5;

export default {
  name: "projectList",
  methods: {
    jump(route) {
      this.$router.push({ path: "/" + route });
    },
    //获取项目列表
    getProjectList(curr, pageSize) {
      this.loading = true;
      this.$http
        .get(this.apiAddress + "/project/list", {
          params: {
            cp: curr,
            ps: pageSize
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.projectList = response.data.res;
              this.itemCount = Number(response.data.count);
            }

            this.loading = false;
          },
          () => {
            this.$message.error("获取数据-操作失败!");
          }
        );
    },
    //创建项目
    create() {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.$http
            .post(this.apiAddress + "/project/create", {
              ...this.form
            })
            .then(
              res => {
                let response = res.body;
                if (response.code === CODE_OK) {
                  this.$message.success("成功!");
                  this.getProjectList(this.currPage, this.pageSize);
                  this.dialogFormVisible = false;
                  this.$refs.form.resetFields();
                } else {
                  this.$message.error(response.msg);
                }
              },
              () => {
                this.$message.error("请求失败!");
              }
            );
        } else {
          return false;
        }
      });
    },
    //删除数据
    del(id) {
      if (!id) {
        this.$message.error("id错误");
        return;
      }

      this.$confirm("此操作将删除该分组, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$http
            .post(
              this.apiAddress + "/project/del",
              {
                id
              },
              { emulateJSON: true }
            )
            .then(
              res => {
                let response = res.body;
                if (response.code === CODE_OK) {
                  this.$message.success("成功!" + response.msg);
                  this.getProjectList(this.currPage, this.pageSize);
                } else {
                  this.$message.error("失败!" + response.msg);
                }
              },
              () => {
                this.$message.error("操作失败!");
              }
            );
        })
        .catch(() => {});
    },

    //更新
    update() {
      this.form = {};
      this.$refs.form.resetFields();
      console.log("test", this.form);
      return;
      this.$http
        .post(
          this.apiAddress + "/project/update",
          {
            id: this.updateData.id,
            ...this.form
          },
          { emulateJSON: true }
        )
        .then(
          res => {
            let response = res.body;
            if (response.code === CODE_OK) {
              this.$message.success("成功!");
              this.dialogFormVisible = false;
              this.$refs.form.resetFields();
              this.getProjectList(this.currPage, this.pageSize);
            } else {
              this.$message.error("失败!" + response.msg);
            }
          },
          () => {
            this.$message.error("操作失败!");
          }
        );
    },
    jumpPage(page) {
      this.currPage = page;
      this.getProjectList(page, PAGE_SIZE);
    },
    detail(id) {
      this.$router.push("/detail/" + id);
    }
  },
  created() {
    this.getProjectList(this.currPage, this.pageSize);
  },
  data() {
    return {
      action: "create",
      projectList: [],
      pageSize: 5,
      currPage: 1,
      itemCount: 0,
      indesideRoute: [],
      loading: true,
      dialogFormVisible: false,
      updateData: {},
      form: {
        title: "",
        version: "",
        type: "",
        description: ""
      },

      rules: {}
    };
  },
  components: {
    page
  }
};
</script>

<style scoped>
.isHide {
  display: none;
}

.project-list {
  width: 100%;
  height: auto;
}

.project-list-btn {
  margin: 10px;
  text-align: left;
}

.project-list-content {
  border: 1px solid #e5e5e5;
  margin: 10px;
  min-height: 600px;
  background-color: #fff;
}

.page-wrapper {
  margin: 20px 0;
}
</style>
