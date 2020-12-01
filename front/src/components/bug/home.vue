<template>
  <div class="bug-home">
    <div class="bar">
      <el-form ref="contentFilterRef" :model="contentFilter" :inline="true">
        <el-form-item label="处理者" prop="toUserId">
          <el-select v-model="contentFilter.toUserId" clearable placeholder="请选择">
            <el-option key="1" label="小白" value="1"></el-option>
            <el-option key="2" label="小花" value="2"></el-option>
            <el-option key="3" label="小红" value="3"></el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="状态" prop="status">
          <el-select v-model="contentFilter.status" clearable placeholder="请选择">
            <el-option key="1" label="待处理" value="1"></el-option>
            <el-option key="2" label="已解决" value="2"></el-option>
            <el-option key="3" label="不处理" value="3"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="等级" prop="level">
          <el-select v-model="contentFilter.level" clearable placeholder="请选择">
            <el-option key="1" label="低" value="1"></el-option>
            <el-option key="2" label="中" value="2"></el-option>
            <el-option key="3" label="高" value="3"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="searchBug()">查询?</el-button>
          <el-button type="primary" @click="searchBug('contentFilterRef')">重置x</el-button>
          <el-button type="primary" @click="dialogFormVisible = true">新增+</el-button>
        </el-form-item>
      </el-form>
    </div>
    <div class="dialog">
      <el-dialog title="新建bug" :visible.sync="dialogFormVisible">
        <el-form :model="form" ref="bugForm" :rules="rules">
          <el-form-item label="标题" :label-width="formLabelWidth" prop="title">
            <el-input v-model="form.title" autocomplete="off"></el-input>
          </el-form-item>

          <el-form-item label="状态" :label-width="formLabelWidth" prop="status">
            <el-select v-model="form.status" placeholder="请选择状态">
              <el-option label="待处理" value="1"></el-option>
              <el-option label="已处理" value="2"></el-option>
              <el-option label="不处理" value="3"></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="等级" :label-width="formLabelWidth" prop="level">
            <el-select v-model="form.level" placeholder="请选择等级">
              <el-option label="低" value="1"></el-option>
              <el-option label="中" value="2"></el-option>
              <el-option label="高" value="3"></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="描述" :label-width="formLabelWidth" prop="content">
            <el-input type="textarea" :rows="5" v-model="form.content" autocomplete="off"></el-input>
          </el-form-item>

          <el-form-item label="备注" :label-width="formLabelWidth" prop="comment">
            <el-input type="textarea" :rows="5" v-model="form.comment" autocomplete="off"></el-input>
          </el-form-item>

          <el-form-item label="指派至:" :label-width="formLabelWidth" prop="to_user_id">
            <el-select v-model="form.to_user_id" placeholder="请选择用户">
              <el-option label="xiaobai" value="1"></el-option>
              <el-option label="xiaoxi" value="2"></el-option>
              <el-option label="xiaohua" value="3"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button
            @click="
              resetForm('bugForm');
              dialogFormVisible = false;
            "
          >取 消</el-button>
          <el-button type="primary" @click="createBug('bugForm')">确 定</el-button>
        </div>
      </el-dialog>
    </div>

    <div class="content" v-loading="loading">
      <el-table :data="tableData.res" border stripe style="width: 100%" @cell-click="rowClick">
        <el-table-column prop="title" label="标题"></el-table-column>
        <el-table-column prop="to_user_id" label="处理者"></el-table-column>
        <el-table-column prop="status" label="状态"></el-table-column>
        <el-table-column prop="level" label="等级"></el-table-column>
        <el-table-column prop="create_time" label="创建时间"></el-table-column>
        <el-table-column prop label="操作">
          <template slot-scope="scope">
            <el-button @click.stop="updateBug('edit', scope.row.id)" size="small">编 辑</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <div class="content-page">
      <el-pagination
        background
        layout="total,prev, pager, next"
        :total="parseInt(tableData.count)"
        :page-size="ps"
        :current-page="cp"
        @current-change="changePage($event)"
      ></el-pagination>
    </div>
    <div class="dialog-content">
      <el-dialog title="bug详情" :visible.sync="dialogContentFormVisible">
        <div class="dialog-content-handle">
          <el-dialog title="bug处理" :visible.sync="dialogHandleFormVisible" append-to-body>
            <el-form :model="form" ref="bugForm" :rules="rules">
              <el-form-item label="状态" :label-width="formLabelWidth" prop="status">
                <el-select v-model="form.status" placeholder="请选择状态">
                  <el-option label="待处理" value="1"></el-option>
                  <el-option label="已处理" value="2"></el-option>
                  <el-option label="不处理" value="3"></el-option>
                </el-select>
              </el-form-item>

              <el-form-item label="备注" :label-width="formLabelWidth" prop="comment">
                <el-input type="textarea" :rows="5" v-model="form.comment" autocomplete="off"></el-input>
              </el-form-item>

              <el-form-item label="指派至:" :label-width="formLabelWidth" prop="to_user_id">
                <el-select v-model="form.to_user_id" placeholder="请选择用户">
                  <el-option label="xiaobai" value="1"></el-option>
                  <el-option label="xiaoxi" value="2"></el-option>
                  <el-option label="xiaohua" value="3"></el-option>
                </el-select>
              </el-form-item>
            </el-form>
            <div class="detail-btn">
              <el-button type="primary">确 认</el-button>
              <el-button type="primary" @click="dialogHandleFormVisible = false">取 消</el-button>
            </div>
          </el-dialog>
        </div>

        <ul>
          <li>
            <em>bugId:</em>
            <span>{{ currentRow.id }}</span>
          </li>
          <li>
            <em>处理者:</em>
            <span>{{ currentRow.to_user_id }}</span>
          </li>
          <li>
            <em>标题:</em>
            <span>{{ currentRow.title }}</span>
          </li>
          <li>
            <em>描述:</em>
            <span>{{ currentRow.content }}</span>
          </li>
          <li>
            <em>备注:</em>
            <span>{{ currentRow.comment }}</span>
          </li>
          <li>
            <em>状态:</em>
            <span>{{ currentRow.status }}</span>
          </li>
          <li>
            <em>等级:</em>
            <span>{{ currentRow.level }}</span>
          </li>
          <li>
            <em>创建时间:</em>
            <span>{{ currentRow.create_time }}</span>
          </li>
          <li>
            <em>最后更新:</em>
            <span>{{ currentRow.update_time }}</span>
          </li>
        </ul>
        <div class="detail-btn">
          <el-button type="primary" @click="dialogHandleFormVisible = true">处 理</el-button>
          <el-button type="primary" @click="dialogContentFormVisible = false">取消</el-button>
        </div>
      </el-dialog>
    </div>
  </div>
</template>

<script>
export default {
  name: "bugHome",
  props: {
    id: String,
  },
  data() {
    return {
      loading: false,
      ps: 10,
      cp: 1,
      tableData: {
        count: 0,
        res: [],
      },
      projectId: 0,
      dialogFormVisible: false,
      dialogContentFormVisible: false,
      dialogHandleFormVisible: false,
      form: {
        project_id: this.$route.params.id,
        to_user_id: null,
        title: "",
        content: "",
        comment: "",
        status: null,
        level: null,
      },
      detailForm: null,
      formLabelWidth: "140px",
      currentRow: {},
      rules: {
        to_user_id: [
          {
            required: true,
            message: "请选择指派",
            trigger: "blur",
          },
        ],
        title: [
          {
            required: true,
            message: "请填入标题",
            trigger: "blur",
          },
        ],
        content: [
          {
            required: true,
            message: "请填入描述",
            trigger: "blur",
          },
        ],
        comment: [],
        status: [
          {
            required: true,
            message: "请选择状态",
            trigger: "blur",
          },
        ],
        level: [
          {
            required: true,
            message: "请选择等级",
            trigger: "blur",
          },
        ],
      },
      contentFilter: {
        toUserId: null,
        status: null,
        level: null,
      },
    };
  },
  created() {
    this.bugList(this.$route.params.id, this.ps, this.cp);
  },

  methods: {
    bugList(projectId, ps = 10, cp = 1, toUserId, status, level) {
      this.loading = true;
      this.$http
        .get("bug/list", {
          params: {
            cp,
            ps,
            projectId,
            toUserId,
            status,
            level,
          },
        })
        .then((response) => {
          let data = response.data.data;
          this.tableData.count = data.resCount;
          this.tableData.res = data.resItem;
          this.loading = false;
        });
    },
    rowClick(row) {
      this.dialogContentFormVisible = true;
      this.currentRow = row;
    },
    createBug(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.$http
            .post("bug/create", {
              ...this.form,
            })
            .then((response) => {
              let data = response.data;
              if (data.code === 200) {
                this.$message.success("保存成功");
                this.resetForm("bugForm");
                this.bugList(this.$route.params.id, this.ps, this.cp);
              } else {
                this.$message.error(data.msg);
              }
            });
          this.dialogFormVisible = false;
        } else {
          return false;
        }
      });
    },
    searchBug(resetFilter = "") {
      if (resetFilter) {
        this.$refs[resetFilter].resetFields();
      }
      this.bugList(
        this.$route.params.id,
        this.ps,
        this.cp,
        this.contentFilter.toUserId,
        this.contentFilter.status,
        this.contentFilter.level
      );
    },
    resetForm(formName) {
      this.$nextTick(() => {
        this.$refs[formName].resetFields();
      });
    },
    changePage(event) {
      this.cp = event;
      this.bugList(this.$route.params.id, this.ps, this.cp);
    },
    handleBug() {},
    updateBug(type,id) {
      console.log(type,id)
    }
  },
};
</script>

<style lang="scss" scoped>
.bug-home {
  .content {
    min-height: 650px;
  }

  .content-page {
    text-align: center;
  }

  .dialog-content {
    ul {
      list-style: none;

      li {
        margin: 10px 0;

        em {
          font-style: normal;
          padding-right: 10px;
          font-weight: bold;
        }
      }
    }
  }

  .bar {
    margin: 10px 0 0 0;
  }
}
</style>
