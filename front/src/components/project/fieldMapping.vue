<template>
  <div class="field-wrapper">
    <div class="btn-wrapper">
      <el-button  @click="showAddWindow = true">新增</el-button>
      <el-dialog title="添加映射字段" :visible.sync="showAddWindow" :show-close="false">
        <el-form :model="fieldMapping" label-width="80px" ref="form" :rules="rules" >
          <el-form-item label="字段名" prop="field">
            <el-input v-model="fieldMapping.field" autocomplete="off" placeholder="字段名"></el-input>
          </el-form-item>
          <el-form-item label="类型" prop="type">
            <el-select
              v-model="fieldMapping.type"
              placeholder="请选择类型"
              
              v-if="propertyList.var_type"
            >
              <el-option-group
                v-for="(group,index) in propertyList.var_type"
                :key="group.label"
                :label="index"
              >
                <el-option
                  v-for="item in group"
                  :key="item.tag_name"
                  :label="item.tag_name"
                  :value="item.tag_name"
                ></el-option>
              </el-option-group>
            </el-select>
          </el-form-item>
          <el-form-item label="描述" prop="description">
            <el-input
              type="textarea"
              :rows="4"
              v-model="fieldMapping.description"
              autocomplete="off"
              placeholder="版本号"
            ></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="showAddWindow = false" >取 消</el-button>
          <el-button type="primary" @click="saveFieldMapping()" >确 定</el-button>
        </div>
      </el-dialog>

      <el-dialog title="修改映射字段" :visible.sync="dialogFormVisibleUpdate" :show-close="false">
        <el-form
          :model="updateData"
          label-width="80px"
          ref="formUpdate"
          :rules="rules"
          
        >
          <el-form-item label="字段名" prop="field">
            <el-input v-model="updateData.field" autocomplete="off" placeholder="字段名"></el-input>
          </el-form-item>
          <el-form-item label="类型" prop="type">
            <el-select
              v-model="updateData.type"
              placeholder="请选择类型"
              
              v-if="propertyList.var_type"
            >
              <el-option-group
                v-for="(group,index) in propertyList.var_type"
                :key="group.label"
                :label="index"
              >
                <el-option
                  v-for="item in group"
                  :key="item.tag_name"
                  :label="item.tag_name"
                  :value="item.tag_name"
                ></el-option>
              </el-option-group>
            </el-select>
          </el-form-item>
          <el-form-item label="描述" prop="description">
            <el-input
              type="textarea"
              :rows="4"
              v-model="updateData.description"
              autocomplete="off"
              placeholder="版本号"
            ></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisibleUpdate = false" >取 消</el-button>
          <el-button type="primary" @click="updateFieldMapping()" >确 定</el-button>
        </div>
      </el-dialog>
    </div>
    <div class="table-wrapper">
      <el-table :data="fieldList" stripe v-loading="loading" border>
        <el-table-column prop="field" label="字段名" width="180"></el-table-column>
        <el-table-column prop="type" label="类型"></el-table-column>
        <el-table-column prop="description" label="描述"></el-table-column>
        <el-table-column prop="create_time" label="创建时间"></el-table-column>
        <el-table-column prop label="操作">
          <template slot-scope="scope">
            <el-button
              slot="reference"
              v-show="$store.state.userInfo.type == 2"
              @click="del(scope.row.id)"
              
            >删除</el-button>
            <el-button
              type="warning"
              plain
              @click="updateData = scope.row;dialogFormVisibleUpdate = true; "
              v-show="$store.state.userInfo.type == 2"
              
            >编辑</el-button>
          </template>
        </el-table-column>
      </el-table>
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;

export default {
  name: "fieldMapping",
  props: {
    id: [Number, String]
  },
  created() {
    this.loading = true;
    this.getFieldList();
    this.getProperty();
  },
  data() {
    return {
      propertyList: [],
      loadding: false,
      showAddWindow: false,
      fieldList: [],
      dialogFormVisibleUpdate: false,
      updateData: {},
      fieldMapping: {
        field: "",
        type: "",
        description: ""
      },
      rules: {
        field: [
          { required: true, message: "请输入字段名", trigger: "blur" },
          { min: 1, max: 50, message: "长度在 1 到 50 个字符", trigger: "blur" }
        ],
        type: [{ required: true, message: "请选择类型", trigger: "blur" }],
        description: [
          { min: 2, max: 50, message: "长度在 2 到 50 个字符", trigger: "blur" }
        ]
      }
    };
  },
  methods: {
    //保存映射字段
    del(id) {
      if (!id) {
        this.$message.error("获取id失败");
        return;
      }

      this.$confirm("此操作将删除该记录, 是否继续?", "提示", {
        confirmButtonText: "确定",
        cancelButtonText: "取消",
        type: "warning"
      })
        .then(() => {
          this.$http
            .post( "/field-mapping/delete", {
              id
            })
            .then(
              res => {
                let response = res.data;
                if (response.code === CODE_OK) {
                  this.$message.success("成功!");
                  this.getFieldList();
                } else {
                  this.$message.error(response.msg);
                }
              },
              () => {
                this.$message.error("请求失败!");
              }
            );
        })
        .catch(() => {});
    },
    updateFieldMapping() {
      this.$refs.formUpdate.validate(valid => {
        if (valid) {
          this.$http
            .post( "/field-mapping/update", {
              ...this.updateData
            })
            .then(
              res => {
                let response = res.data;
                if (response.code === CODE_OK) {
                  this.$message.success("成功!");
                  this.getFieldList();
                  this.dialogFormVisibleUpdate = false;
                  this.$refs.formUpdate.resetFields();
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
    //保存字段
    saveFieldMapping() {
      this.$refs.form.validate(valid => {
        if (valid) {
          this.$http
            .post( "/field-mapping/create", {
              ...this.fieldMapping,
              project_id: this.id
            })
            .then(
              res => {
                let response = res.data;
                if (response.code === CODE_OK) {
                  this.$message.success("成功!");
                  this.getFieldList();
                  this.showAddWindow = false;
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
    //获取字段列表
    getFieldList() {
      this.loading = true;
      this.$http
        .get( "/field-mapping/list", {
          params: {}
        })
        .then(
          response => {
            response = response.data;
            if (response.code === CODE_OK) {
              this.fieldList = response.data;
            }

            this.loading = false;
          },
          () => {
            this.$message.error("获取数据-操作失败!");
          }
        );
    },
    //获取创建api的默认属性
    getProperty() {
      this.$http
        .get( "/property/list", {
          params: {}
        })
        .then(
          response => {
            response = response.data;
            if (response.code === CODE_OK) {
              this.propertyList = response.data;
            }
          },
          () => {
            this.$message.error("获取数据失败");
          }
        );
    }
  }
};
</script>

<style lang="scss" scoped>
.btn-wrapper {
  padding: 10px 0;
}

.table-wrapper {
  padding: 0 0;
}

.field-wrapper {
  box-sizing: border-box;
  padding-right: 10px;
}
</style>