<template>
  <div class="project-list">
    <div class="project-list-btn">
      <el-button
        @click="dialogFormVisible = true; "
        v-show="$store.state.userInfo.type == 2"
        size="mini"
      >+新增项目</el-button>
    </div>
    <!-- 项目列表-开始 -->
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
              @click="updateData = scope.row;dialogFormVisibleUpdate = true; "
              v-show="$store.state.userInfo.type == 2"
              size="mini"
            >编辑</el-button>
            <el-button type="success" plain @click="detail(scope.row.id)" size="mini">详情</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!-- 项目列表-结束 -->
    <div class="page-wrapper">
      <el-pagination
        background
        layout="total,prev, pager, next"
        :total="parseInt(itemCount)"
        :page-size="pageSize"
        :current-page="currPage"
        @current-change="jumpPage($event)"
      ></el-pagination>
    </div>
    <!-- 添加项目-开始 -->
    <el-dialog title="添加项目" :visible.sync="dialogFormVisible" width="40%">
      <el-form :model="form" label-width="80px" ref="form" :rules="rules" size="small">
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
    <!-- 添加项目-结束 -->
    <!-- 编辑项目-开始 -->
    <el-dialog title="编辑项目" :visible.sync="dialogFormVisibleUpdate" width="40%">
      <el-form :model="updateData" label-width="80px" ref="updateData" :rules="rules" size="small">
        <el-form-item label="项目名称" prop="title">
          <el-input v-model="updateData.title" autocomplete="off" placeholder="项目名称"></el-input>
        </el-form-item>
        <el-form-item label="版本号" prop="version">
          <el-input v-model="updateData.version" autocomplete="off" placeholder="版本号"></el-input>
        </el-form-item>
        <el-form-item label="项目类型" prop="type">
          <el-select v-model="updateData.type" placeholder="请选择">
            <el-option label="pc" value="pc"></el-option>
            <el-option label="web" value="web"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="项目描述" prop="description">
          <el-input type="textarea" :rows="4" placeholder="请输入内容" v-model="updateData.description"></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisibleUpdate = false;$refs.updateData.resetFields()">取 消</el-button>
        <el-button type="primary" @click="update()">确 定</el-button>
      </div>
    </el-dialog>
    <!-- 编辑项目-结束 -->
  </div>
</template>

<script>
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
        .get("/project/list", {
          params: {
            cp: curr,
            ps: pageSize,
          },
        })
        .then(
          (response) => {
            response = response.data;
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
      this.$refs.form.validate((valid) => {
        if (valid) {
          this.$http
            .post("/project/create", {
              ...this.form,
            })
            .then(
              (res) => {
                let response = res.data;
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
        type: "warning",
      })
        .then(() => {
          this.$http
            .post("/project/del", {
              id,
            })
            .then(
              (res) => {
                let response = res.data;
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
      this.$refs.updateData.validate((valid) => {
        if (valid) {
          this.$http
            .post("/project/update", {
              id: this.updateData.id,
              ...this.updateData,
            })
            .then(
              (res) => {
                let response = res.data;
                if (response.code === CODE_OK) {
                  this.$message.success("成功!");
                  this.dialogFormVisibleUpdate = false;
                  this.$refs.updateData.resetFields();
                  this.getProjectList(this.currPage, this.pageSize);
                } else {
                  this.$message.error("失败!" + response.msg);
                }
              },
              () => {
                this.$message.error("操作失败!");
              }
            );
        } else {
          return false;
        }
      });
    },
    jumpPage(page) {
      this.currPage = page;
      this.getProjectList(page, PAGE_SIZE);
    },
    detail(id) {
      this.$router.push("/detail/" + id);
    },
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
      loading: true,
      dialogFormVisible: false,
      dialogFormVisibleUpdate: false,
      updateData: {},
      form: {
        title: "",
        version: "",
        type: "",
        description: "",
      },
      rules: {
        title: [
          { required: true, message: "请输入名称", trigger: "blur" },
          {
            min: 2,
            max: 50,
            message: "长度在 2 到 50 个字符",
            trigger: "blur",
          },
        ],
        type: [{ required: true, message: "请选择类型", trigger: "blur" }],
        description: [
          {
            min: 2,
            max: 50,
            message: "长度在 2 到 50 个字符",
            trigger: "blur",
          },
        ],
        version: [
          { required: true, message: "请输入版本号", trigger: "blur" },
          {
            min: 1,
            max: 50,
            message: "长度在 6 到 50 个字符",
            trigger: "blur",
          },
        ],
      },
    };
  },
  components: {},
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
  text-align: center;
  margin: 10px 0;
}
</style>
