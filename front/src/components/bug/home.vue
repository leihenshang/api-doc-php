<template>
  <div class="bug-home">
    <div class="bar">
      <el-button type="primary" size="small" @click="dialogFormVisible = true"
        >新增+</el-button
      >
    </div>
    <div class="dialog">
      <el-dialog title="新建bug" :visible.sync="dialogFormVisible">
        <el-form :model="form" ref="bugForm" :rules="rules">
          <el-form-item label="标题" :label-width="formLabelWidth" prop="title">
            <el-input v-model="form.title" autocomplete="off"></el-input>
          </el-form-item>

          <el-form-item
            label="状态"
            :label-width="formLabelWidth"
            prop="status"
          >
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

          <el-form-item
            label="描述"
            :label-width="formLabelWidth"
            prop="content"
          >
            <el-input
              type="textarea"
              :rows="5"
              v-model="form.content"
              autocomplete="off"
            ></el-input>
          </el-form-item>

          <el-form-item
            label="备注"
            :label-width="formLabelWidth"
            prop="comment"
          >
            <el-input
              type="textarea"
              :rows="5"
              v-model="form.comment"
              autocomplete="off"
            ></el-input>
          </el-form-item>

          <el-form-item
            label="指派至:"
            :label-width="formLabelWidth"
            prop="to_user_id"
          >
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
            >取 消</el-button
          >
          <el-button type="primary" @click="createBug('bugForm')"
            >确 定</el-button
          >
        </div>
      </el-dialog>
    </div>
    <div class="content"   v-loading="loading">
      <el-table
        :data="tableData.res"
        border
        stripe
        style="width: 100%"
        @cell-click="rowClick"
      >
        <el-table-column prop="title" label="标题"> </el-table-column>
        <el-table-column prop="to_user_id" label="处理者"> </el-table-column>
        <el-table-column prop="status" label="状态"> </el-table-column>
        <el-table-column prop="level" label="等级"> </el-table-column>
        <el-table-column prop="create_time" label="创建时间"> </el-table-column>
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
      >
      </el-pagination>
    </div>
    <div class="dialog-content">
      <el-dialog title="bug详情" :visible.sync="dialogContentFormVisible">
        <ul>
        <li><span>{{ currentRow.id }}</span></li>
        <li><span>{{ currentRow.to_user_id }}</span></li>
        <li><span>{{ currentRow.title }}</span></li>
        <li><span>{{ currentRow.content }}</span></li>
        <li><span>{{ currentRow.comment }}</span></li>
        <li><span>{{ currentRow.status }}</span></li>
        <li><span>{{ currentRow.level }}</span></li>
        <li><span>{{ currentRow.create_time }}</span></li>
        <li><span>{{ currentRow.update_time }}</span></li>
          </ul>
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
      loading:false,
      ps: 10,
      cp: 1,
      tableData: {
        count: 0,
        res: [],
      },
      projectId: 0,
      dialogFormVisible: false,
      dialogContentFormVisible: false,
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
          { required: true, message: "请选择指派", trigger: "blur" },
        ],
        title: [{ required: true, message: "请填入标题", trigger: "blur" }],
        content: [{ required: true, message: "请填入描述", trigger: "blur" }],
        comment: [],
        status: [{ required: true, message: "请选择状态", trigger: "blur" }],
        level: [{ required: true, message: "请选择等级", trigger: "blur" }],
      },
    };
  },
  created() {
    this.bugList(this.$route.params.id, this.ps, this.cp);
  },

  methods: {
    bugList(projectId, ps = 10, cp = 1) {
      this.loading = true;
      this.$http
        .get("bug/list", {
          params: {
            cp: cp,
            ps: ps,
            projectId,
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
    resetForm(formName) {
      this.$nextTick(() => {
        this.$refs[formName].resetFields();
      });
    },
    changePage(event) {
      this.cp = event;
      this.bugList(this.$route.params.id, this.ps, this.cp);
    },
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

  .bar {
    margin: 10px 0;
  }
}
</style>
