<template>
  <div class="bug-home">
    <!-- 表格筛选-开始 -->
    <div class="bar">
      <el-form ref="contentFilterRef" :model="contentFilter" :inline="true">
        <el-form-item label="处理者" prop="toUserId">
          <user-search-select
            :myTargetObject="contentFilter"
            :userFilterOptions="userFilterOptions"
          ></user-search-select>
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
          <el-button
            type="primary"
            @click="dialogFormVisible = true;"
            :disabled="!controlShow()"
          >新增+</el-button>
        </el-form-item>
      </el-form>
    </div>
    <!-- 表格筛选-结束 -->

    <!-- 创建bug-开始 -->
    <div class="dialog-create-bug">
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
            <user-search-select :myTargetObject="form" :userFilterOptions="userFilterOptions"></user-search-select>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button
            @click="
              resetForm('bugForm');
              dialogFormVisible = false;
            "
          >取 消</el-button>
          <el-button type="primary" @click="saveBug('bugForm')">确 定</el-button>
        </div>
      </el-dialog>
    </div>
    <!-- 创建bug-结束 -->
    <!-- 更新bug-开始 -->
    <div class="dialog-update-bug">
      <el-dialog title="编辑bug" :visible.sync="dialogFormUpdateVisible">
        <el-form :model="formUpdate" ref="bugFormUpdate" :rules="rules">
          <el-form-item label="标题" :label-width="formLabelWidth" prop="title">
            <el-input v-model="formUpdate.title" autocomplete="off"></el-input>
          </el-form-item>

          <el-form-item label="状态" :label-width="formLabelWidth" prop="status">
            <el-select v-model="formUpdate.status" placeholder="请选择状态">
              <el-option label="待处理" value="1"></el-option>
              <el-option label="已处理" value="2"></el-option>
              <el-option label="不处理" value="3"></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="等级" :label-width="formLabelWidth" prop="level">
            <el-select v-model="formUpdate.level" placeholder="请选择等级">
              <el-option label="低" value="1"></el-option>
              <el-option label="中" value="2"></el-option>
              <el-option label="高" value="3"></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="描述" :label-width="formLabelWidth" prop="content">
            <el-input type="textarea" :rows="5" v-model="formUpdate.content" autocomplete="off"></el-input>
          </el-form-item>

          <el-form-item label="备注" :label-width="formLabelWidth" prop="comment">
            <el-input type="textarea" :rows="5" v-model="formUpdate.comment" autocomplete="off"></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="
              dialogFormUpdateVisible = false;
            ">取 消</el-button>
          <el-button type="primary" @click="saveBug('bugFormUpdate')">确 定</el-button>
        </div>
      </el-dialog>
    </div>
    <!-- 更新BUG-结束 -->
    <!-- 表格-开始 -->
    <div class="content" v-loading="loading">
      <el-table :data="tableData.res" border stripe style="width: 100%" @cell-click="rowClick">
        <el-table-column prop="title" label="标题"></el-table-column>
        <el-table-column label="处理者">
          <template slot-scope="scope">
            <span>{{ scope.row.to_user_info ? scope.row.to_user_info.nick_name : 'unknown'}}</span>
          </template>
        </el-table-column>
        <el-table-column label="状态">
          <template slot-scope="scope">
            <span>{{ convertStatus(scope.row.status) }}</span>
          </template>
        </el-table-column>
        <el-table-column label="等级">
          <template slot-scope="scope">
            <span>{{ convertLevel(scope.row.level) }}</span>
          </template>
        </el-table-column>
        <el-table-column prop="create_time" label="创建时间"></el-table-column>
        <el-table-column label="操作" align="center">
          <template slot-scope="scope">
            <el-button
              @click.stop="updateBug(scope.row)"
              size="medium"
              style="margin-right:10px;"
              :disabled="!controlShow()"
            >编 辑</el-button>

            <el-popconfirm title="确定要删除这个bug?" placement="top" @confirm="deleteBug(scope.row)">
              <el-button slot="reference" size="medium" @click.stop :disabled="!controlShow()">删 除</el-button>
            </el-popconfirm>
          </template>
        </el-table-column>
      </el-table>
    </div>
    <!-- 表格-结束 -->
    <!-- 表格分页-开始 -->
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
    <!-- 表格分页-结束 -->
    <!-- bug详情-开始 -->
    <div class="dialog-bug-detail">
      <el-dialog title="bug详情" :visible.sync="dialogContentFormVisible" width="70%">
        <div class="dialog-bug-detail-handle">
          <!-- 嵌套表单-处理-开始 -->
          <el-dialog title="bug处理" :visible.sync="dialogHandleFormVisible" append-to-body>
            <el-form :model="formHandle" ref="bugFormHandle" :rules="handleRules">
              <el-form-item label="状态" :label-width="formLabelWidth" prop="status">
                <el-select v-model="formHandle.status" placeholder="请选择状态">
                  <el-option label="待处理" value="1"></el-option>
                  <el-option label="已处理" value="2"></el-option>
                  <el-option label="不处理" value="3"></el-option>
                </el-select>
              </el-form-item>

              <el-form-item label="备注" :label-width="formLabelWidth" prop="comment">
                <el-input type="textarea" :rows="5" v-model="formHandle.comment" autocomplete="off"></el-input>
              </el-form-item>
              <el-form-item label="指派至:" :label-width="formLabelWidth" prop="to_user_id">
                <user-search-select
                  :myTargetObject="formHandle"
                  :userFilterOptions="userFilterOptions"
                ></user-search-select>
              </el-form-item>
            </el-form>

            <div class="detail-btn">
              <el-button type="primary" @click="bugAssign('bugFormHandle')">确 认</el-button>
              <el-button type="primary" @click="dialogHandleFormVisible = false">取 消</el-button>
            </div>
          </el-dialog>
          <!-- 嵌套表单-结束 -->
        </div>

        <!-- bug详情展示-开始 -->
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
            <span>{{ convertStatus(currentRow.status) }}</span>
          </li>
          <li>
            <em>等级:</em>
            <span>{{ convertLevel(currentRow.level) }}</span>
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
        <!-- bug详情展示-结束 -->
        <div class="detail-btn">
          <el-button
            type="primary"
            @click="dialogHandleFormVisible = true"
            :disabled="!controlShow()"
          >处 理</el-button>
          <!-- <el-button type="primary" @click="dialogContentFormVisible = false">取 消</el-button> -->
        </div>
        <!-- 指派列表-开始 -->
        <div class="dialog-bug-detail-assign" style="margin-top:10px;">
          <el-table :data="assignListData.res" border stripe style="width: 100%">
            <el-table-column label="指派者">
              <template slot-scope="scope">
                <span>{{ scope.row.from_user_info ? scope.row.from_user_info.nick_name : 'unknown'}}</span>
              </template>
            </el-table-column>
            <el-table-column label="处理者">
              <template slot-scope="scope">
                <span>{{ scope.row.to_user_info ? scope.row.to_user_info.nick_name : 'unknown'}}</span>
              </template>
            </el-table-column>
            <el-table-column label="状态">
              <template slot-scope="scope">
                <span>{{ convertStatus(scope.row.status) }}</span>
              </template>
            </el-table-column>
            <el-table-column prop="comment" label="备注"></el-table-column>
            <el-table-column prop="create_time" label="创建时间"></el-table-column>
          </el-table>
          <!-- 指派列表-结束 -->
        </div>
      </el-dialog>
    </div>
    <!-- bug详情-结束 -->
  </div>
</template>

<script>
import UserSearchSelect from  "../../components/bug/userSearchSelect.vue";
import controlShow from "../../mixins/controlShow";

export default {
  name: "bug",
  props: {
    id: String,
  },
  data() {
    return {
      userFilterOptions: [],
      userFilterLoading: false,
      loading: false,
      ps: 10,
      cp: 1,
      tableData: {
        count: 0,
        res: [],
      },
      projectId: 0,
      dialogFormVisible: false,
      dialogFormUpdateVisible: false,
      dialogContentFormVisible: false,
      dialogHandleFormVisible: false,
      formHandle: {
        to_user_id: null,
        comment: "",
        status: null,
      },
      formUpdate: {},
      form: {
        project_id: this.$route.params.projectId,
        to_user_id: null,
        title: "",
        content: "",
        comment: "",
        status: null,
        level: null,
        id: null,
      },
      detailForm: null,
      formLabelWidth: "140px",
      currentRow: {},
      rules: {
        to_user_id: [
          {
            required: false,
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
      handleRules: {
        to_user_id: [
          {
            required: false,
            message: "请选择指派",
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
      },
      contentFilter: {
        to_user_id: null,
        status: null,
        level: null,
      },
      assignListData: {
        count: 0,
        res: [],
      },
    };
  },
  created() {
    this.bugList(this.$route.params.projectId, this.ps, this.cp);
    this.formBak = JSON.parse(JSON.stringify(this.form));
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
          this.tableData.count = data.count;
          this.tableData.res = data.items;
          this.loading = false;
        });
    },
    rowClick(row) {
      this.dialogContentFormVisible = true;
      this.currentRow = row;
      this.assignList(this.currentRow.id);
    },
    saveBug(formName) {
      let url = "bug/create";
      let data = this.form;
      if (this.formUpdate.id) {
        url = "bug/update";
        data = this.formUpdate;
      }
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.$http
            .post(url, {
              ...data,
            })
            .then((response) => {
              let data = response.data;
              if (data.code === 200) {
                this.$message.success("保存成功");
                this.resetForm(formName);
                this.bugList(this.$route.params.projectId, this.ps, this.cp);
              } else {
                this.$message.error(data.msg);
              }
            });
          this.dialogFormVisible = false;
          this.dialogFormUpdateVisible = false;
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
        this.$route.params.projectId,
        this.ps,
        this.cp,
        this.contentFilter.toUserId,
        this.contentFilter.status,
        this.contentFilter.level
      );
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    },
    changePage(event) {
      this.cp = event;
      this.bugList(
        this.$route.params.projectId,
        this.ps,
        this.cp,
        this.contentFilter.toUserId,
        this.contentFilter.status,
        this.contentFilter.level
      );
    },
    bugAssign(formName) {
      this.$refs[formName].validate((valid) => {
        if (valid) {
          this.$http
            .post("bug/assign", {
              ...this.formHandle,
              bug_id: this.currentRow.id,
            })
            .then((response) => {
              let data = response.data;
              if (data.code === 200) {
                this.$message.success("指派成功");
                this.dialogContentFormVisible = false;
                this.resetForm(formName);
                this.bugList(
                  this.$route.params.projectId,
                  this.ps,
                  this.cp,
                  this.contentFilter.toUserId,
                  this.contentFilter.status,
                  this.contentFilter.level
                );
              } else {
                this.$message.error(data.msg);
              }
            });

          this.dialogHandleFormVisible = false;
        } else {
          return false;
        }
      });
    },
    updateBug(old) {
      this.dialogFormUpdateVisible = true;
      this.formUpdate = old;
    },
    deleteBug(old) {
      if (!old.id) {
        this.$message.error("操作失败");
        return;
      }

      this.$http
        .post("bug/delete", {
          id: old.id,
        })
        .then((response) => {
          let data = response.data;
          if (data.code === 200) {
            this.$message.success("操作成功");
            this.bugList(this.$route.params.projectId, this.ps, this.cp);
          } else {
            this.$message.error(data.msg);
          }
        });
    },
    convertStatus(status) {
      let convertStatus = "";
      switch (parseInt(status)) {
        case 1:
          convertStatus = "待解决";
          break;
        case 2:
          convertStatus = "已解决";
          break;
        case 3:
          convertStatus = "不处理";
          break;

        default:
          convertStatus = "unknown";
          break;
      }
      return convertStatus;
    },
    convertLevel(level) {
      let convertLevel = "";
      switch (parseInt(level)) {
        case 1:
          convertLevel = "低";
          break;
        case 2:
          convertLevel = "中";
          break;
        case 3:
          convertLevel = "高";
          break;

        default:
          convertLevel = "unknown";
          break;
      }
      return convertLevel;
    },
    assignList(bugId) {
      if (!bugId) {
        return;
      }

      this.$http
        .get("bug/assign-list", {
          params: {
            bugId,
            ps: 1000,
          },
        })
        .then((response) => {
          let data = response.data.data;
          this.assignListData.count = data.count;
          this.assignListData.res = data.items;
        });
    },
    userFilterSearch(query) {
      if (query !== "") {
        this.userFilterLoading = true;
        this.$http
          .get("/user/list", {
            params: {
              query,
              projectId: this.$route.params.projectId,
            },
          })
          .then((response) => {
            response = response.data;
            if (response.code === 200) {
              this.userFilterOptions = response.data.items;
            }
            this.userFilterLoading = false;
          });
      } else {
        this.userFilterOptions = [];
      }
    },
  },
  computed: {},
  mixins: [controlShow],
  components: {
    UserSearchSelect,
  },
};
</script>

<style lang="scss" scoped>
.bug-home {
  .content {
    min-height: 650px;
  }

  .content-page {
    text-align: right;
  }

  .dialog-bug-detail {
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
