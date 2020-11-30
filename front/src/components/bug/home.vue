<template>
  <div class="bug-home">
    <div class="bar">
      <el-button type="primary" size="small" @click="dialogFormVisible = true"
        >新增+</el-button
      >
    </div>
    <div class="dialog">
      <el-dialog title="新建bug" :visible.sync="dialogFormVisible">
        <el-form :model="form" ref="bugForm">
          <el-form-item label="标题" :label-width="formLabelWidth">
            <el-input v-model="form.title" autocomplete="off"></el-input>
          </el-form-item>

          <el-form-item label="状态" :label-width="formLabelWidth">
            <el-select v-model="form.status" placeholder="请选择状态">
              <el-option label="待处理" value="1"></el-option>
              <el-option label="已处理" value="2"></el-option>
              <el-option label="不处理" value="3"></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="等级" :label-width="formLabelWidth">
            <el-select v-model="form.level" placeholder="请选择等级">
              <el-option label="低" value="1"></el-option>
              <el-option label="中" value="2"></el-option>
              <el-option label="高" value="3"></el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="描述" :label-width="formLabelWidth">
            <el-input
              type="textarea"
              :rows="5"
              v-model="form.content"
              autocomplete="off"
            ></el-input>
          </el-form-item>

          <el-form-item label="备注" :label-width="formLabelWidth">
            <el-input
              type="textarea"
              :rows="5"
              v-model="form.comment"
              autocomplete="off"
            ></el-input>
          </el-form-item>

          <el-form-item label="指派至:" :label-width="formLabelWidth">
            <el-select v-model="form.to_user_id" placeholder="请选择用户">
              <el-option label="xiaobai" value="1"></el-option>
              <el-option label="xiaoxi" value="2"></el-option>
              <el-option label="xiaohua" value="3"></el-option>
            </el-select>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="resetForm('bugForm');dialogFormVisible = false;">取 消</el-button>
          <el-button
            type="primary"
            @click="
              dialogFormVisible = false;
              createBug();
            "
            >确 定</el-button
          >
        </div>
      </el-dialog>
    </div>
    <div class="content">
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
    <div class="dialog-content">
  
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
      detailForm:null,
      formLabelWidth: "140px",
    };
  },
  created() {
    this.bugList(this.$route.params.id, 10, 1);
  },

  methods: {
    bugList(projectId, ps = 10, cp = 1) {
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
        });
    },
    rowClick(row, column, event) {
      this.dialogContentFormVisible = true;
      console.log(row, column, event);
    },
    createBug() {
      this.$http
        .post("bug/create", {
          ...this.form,
        })
        .then((response) => {
          let data = response.data;
          if (data.code === 200) {
            this.$message.success("保存成功");
            this.resetForm("bugForm");
            this.bugList(this.$route.params.id, 10, 1);
          }else {
             this.$message.error(data.msg);
          }
        });
    },
      resetForm(formName) {
        this.$nextTick(() => {
        this.$refs[formName].resetFields();
        });
      }
  },
};
</script>

<style lang="scss" scoped>
.bug-home {
  .content {
    .left {
      border: 1px solid black;
    }

    .right {
      border: 1px solid black;
    }
  }

  .bar {
    margin: 10px 0;
  }
}
</style>
