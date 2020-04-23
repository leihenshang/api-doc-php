<template>
  <div class="project-list">
    <!-- 遮罩层 -->
    <boxShade :hide="hideShade" />

    <div class="project-list-btn">
      <el-button @click="create" v-show="$store.state.userInfo.type == 2" size="mini">+新增项目</el-button>
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
              @click="del(item.id)"
              size="mini"
            >删除</el-button>
            <el-button
              type="warning"
              plain
              @click="update(scope.row)"
              v-show="$store.state.userInfo.type == 2"
              size="mini"
            >编辑</el-button>

            <el-button type="success" plain @click="detail(scope.row.id)" size="mini">详情</el-button>

            <el-popconfirm
              title="确定要删除这个api?"
              placement="top"
              @onConfirm="delApi(scope.row.id)"
              width="200"
            ></el-popconfirm>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div class="page-wrapper">
      <page :curr="currPage" :itemCount="itemCount" :pageSize="pageSize" v-on:jump-page="jumpPage" />
    </div>
    <div class="add-wrapper">
      <add :is-show="addIsHide" :update-data="updateData" v-on:hide-box="onClickHide" />
    </div>
  </div>
</template>

<script>
import add from "./add";
import page from "../common/page";
import boxShade from "../common/boxShade";
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
      this.$http
        .get(this.apiAddress + "/project/list", {
          params: {
            cp: curr,
            ps: pageSize,
            token: this.$store.state.userInfo.token
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.projectList = response.data.res;
              this.itemCount = Number(response.data.count);
              this.hideShade = true;
            }

            this.loading = false;
          },
          () => {
            this.$message.error("获取数据-操作失败!");
            this.hideShade = true;
          }
        );
    },
    create() {
      this.addIsHide = !this.addIsHide;
    },
    onClickHide(val) {
      if (val === "flush") {
        this.currPage = 1;
        this.getProjectList(this.currPage, this.pageSize);
      }
      this.addIsHide = !this.addIsHide;
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
    update(item) {
      this.updateData = item;
      this.addIsHide = !this.addIsHide;
    },
    jumpPage(page) {
      this.currPage = page;
      this.hideShade = false;
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
      projectList: [],
      pageSize: 5,
      currPage: 1,
      addIsHide: true,
      updateData: null,
      itemCount: 0,
      hideShade: true,
      indesideRoute: [],
      loading: true
    };
  },
  components: {
    add,
    page,
    boxShade
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
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

.project-list-btn button {
  border: 1px solid #e5e5e5;
  padding: 8px 20px;
  border-radius: 3px;
  background-color: #fff;
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
