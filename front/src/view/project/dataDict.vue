<template>
  <div class="dataDict">
    <el-button @click="showAddWindow = !showAddWindow">
      <i class="el-icon-plus"></i>新增
    </el-button>
    <el-divider></el-divider>
    <!-- 数据-开始 -->
    <el-table :data="dataArr" stripe style="width: 100%" border v-loading="loading">
      <el-table-column prop="type" label="类型" width="180"></el-table-column>
      <el-table-column prop="address" label="地址" width="180"></el-table-column>
      <el-table-column prop="port" label="端口" width="180"></el-table-column>
      <el-table-column prop="username" label="用户名"></el-table-column>
      <el-table-column prop="database_name" label="数据库名"></el-table-column>
      <el-table-column prop="create_time" label="创建时间"></el-table-column>
      <el-table-column prop="create_user" label="创建者"></el-table-column>
      <el-table-column align="center" label="操作">
        <template slot-scope="scope">
          <el-button type="text" @click="deleteData(scope.row)">删除</el-button>
          <el-divider direction="vertical"></el-divider>
          <el-button type="text" @click="updateData(scope.row)">编辑</el-button>
          <el-divider direction="vertical"></el-divider>
          <el-button type="text" @click="showDictWindow = true">字典</el-button>
          <el-divider direction="vertical"></el-divider>
          <el-button type="text">导出</el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- 数据-结束 -->

    <!-- 表单-开始 -->
    <el-dialog
      :title=" dataConnForm.id ? '修改数据库连接' : '新增数据库连接'"
      :visible.sync="showAddWindow"
      :show-close="false"
      width="40%"
      @close="formCancel"
    >
      <el-form :model="dataConnForm" label-width="80px" ref="form" :rules="rules">
        <el-form-item label="地址" prop="address">
          <el-input v-model="dataConnForm.address" autocomplete="off" placeholder="地址"></el-input>
        </el-form-item>
        <el-form-item label="端口" prop="port">
          <el-input v-model.number="dataConnForm.port" autocomplete="off" placeholder="端口"></el-input>
        </el-form-item>
        <el-form-item label="用户名" prop="username">
          <el-input v-model="dataConnForm.username" autocomplete="off" placeholder="用户名"></el-input>
        </el-form-item>
        <el-form-item label="密码" prop="password">
          <el-input
            v-model="dataConnForm.password"
            autocomplete="off"
            placeholder="密码"
            type="password"
          ></el-input>
        </el-form-item>
        <el-form-item label="数据库名" prop="database_name">
          <el-input v-model="dataConnForm.database_name" autocomplete="off" placeholder="数据库名"></el-input>
        </el-form-item>
        <el-form-item label="描述" prop="description">
          <el-input
            type="textarea"
            :rows="4"
            v-model="dataConnForm.description"
            autocomplete="off"
            placeholder="输入描述"
          ></el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="formCancel">取 消</el-button>
        <el-button type="primary" @click="saveDataConnForm()">确 定</el-button>
      </div>
    </el-dialog>
    <!-- 表单-结束 -->

    <!-- 字典-开始 -->
    <el-dialog title="数据字典" :visible.sync="showDictWindow">
      <div class="dictItem">
        <h4>user_info(用户表)</h4>
        <p>用于记录用户信息,用于记录用户信息</p>
        <table class="dictTable">
          <tr>
            <th>字段名</th>
            <th>类型</th>
            <th>非空</th>
            <th>自增</th>
            <th>主键</th>
            <th>描述</th>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
        </table>
        <hr />
      </div>
      <div class="dictItem">
        <h4>user_info(用户表)</h4>
        <p>用于记录用户信息,用于记录用户信息</p>
        <table class="dictTable">
          <tr>
            <th>字段名</th>
            <th>类型</th>
            <th>非空</th>
            <th>自增</th>
            <th>主键</th>
            <th>描述</th>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
        </table>
        <hr />
      </div>

      <div class="dictItem">
        <h4>user_info(用户表)</h4>
        <p>用于记录用户信息,用于记录用户信息</p>
        <table class="dictTable">
          <tr>
            <th>字段名</th>
            <th>类型</th>
            <th>非空</th>
            <th>自增</th>
            <th>主键</th>
            <th>描述</th>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
        </table>
        <hr />
      </div>

      <div class="dictItem">
        <h4>user_info(用户表)</h4>
        <p>用于记录用户信息,用于记录用户信息</p>
        <table class="dictTable">
          <tr>
            <th>字段名</th>
            <th>类型</th>
            <th>非空</th>
            <th>自增</th>
            <th>主键</th>
            <th>描述</th>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
        </table>
        <hr />
      </div>

      <div class="dictItem">
        <h4>user_info(用户表)</h4>
        <p>用于记录用户信息,用于记录用户信息</p>
        <table class="dictTable">
          <tr>
            <th>字段名</th>
            <th>类型</th>
            <th>非空</th>
            <th>自增</th>
            <th>主键</th>
            <th>描述</th>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
        </table>
        <hr />
      </div>

      <div class="dictItem">
        <h4>user_info(用户表)</h4>
        <p>用于记录用户信息,用于记录用户信息</p>
        <table class="dictTable">
          <tr>
            <th>字段名</th>
            <th>类型</th>
            <th>非空</th>
            <th>自增</th>
            <th>主键</th>
            <th>描述</th>
          </tr>
          <tr>
            <td>id</td>
            <td>int</td>
            <td>true</td>
            <td>true</td>
            <td>true</td>
            <td>用户id是用于记录一个流水号的</td>
          </tr>
        </table>
        <hr />
      </div>
    </el-dialog>
    <!-- 字典-结束 -->
  </div>
</template>

<script>
const CODE_OK = 200;

export default {
  name: "dataDict",
  props: {
    projectId: 0,
  },
  data() {
    return {
      loading: false,
      showAddWindow: false,
      showDictWindow: false,
      rules: {
        address: [
          { required: true, message: "请输入数据库地址", trigger: "blur" },
          {
            min: 1,
            max: 500,
            message: "长度在 1 到 500 个字符",
            trigger: "blur",
          },
        ],
        port: [
          {
            required: true,
            message: "请输入端口",
            trigger: "blur",
          },
          { type: "number", message: "端口必须为数字" },
        ],

        username: [
          {
            required: true,
            message: "请输入用户名",
            trigger: "blur",
          },
        ],

        password: [
          {
            required: true,
            message: "请输入密码",
            trigger: "blur",
          },
        ],

        database_name: [
          {
            required: true,
            message: "请输入数据库名",
            trigger: "blur",
          },
        ],

        description: [
          {
            min: 1,
            max: 200,
            message: "长度在 1 到 200 个字符",
            trigger: "blur",
          },
        ],
      },
      dataConnForm: {
        // username:'',
        // port:0,
        // password:'',
        // description:'',
        // database_name:'',
        // address:'',
      },
      dataArr: [
        {
          id: 3,
          address: "测试地址",
          type: "mysql",
          port: 1000,
          username: "测试用户1",
          password: "*********",
          database_name: "test1",
          create_time: "2020-20-20",
          create_user: "tangzq",
        },
        {
          id: 1,
          address: "测试地址2",
          type: "mysql",
          port: 1000,
          username: "测试用户1",
          password: "*********",
          database_name: "test1",
          create_time: "2020-20-20",
          create_user: "tangzq",
        },
        {
          id: 2,
          address: "测试地址",
          type: "mysql",
          port: 1000,
          username: "测试用户1",
          password: "*********",
          database_name: "test1",
          create_time: "2020-20-20",
          create_user: "tangzq",
        },
      ],
    };
  },
  created() {},
  methods: {
    deleteData(data) {
      console.log(data);
    },
    updateData(data) {
      this.dataConnForm = data;
      this.showAddWindow = true;
    },
    formCancel() {
      this.showAddWindow = false;
      this.dataConnForm = {};
    },
    saveDataConnForm() {
      let url = this.dataConnForm.id
        ? "/data-base/update"
        : "/data-base/create";

      this.$refs.form.validate((valid) => {
        if (!valid) {
          console.log(valid);
          return;
        }

        this.$http
          .post(url, {
            ...this.dataConnForm,
            project_id: this.projectId,
          })
          .then((res) => {
            let response = res.data;
            if (response.code === CODE_OK) {
              this.$message.success("操作成功!");
              this.formCancel();
              this.$refs.form.resetFields();
            } else {
              this.$message.error(response.msg);
              this.formCancel();
            }
          });
      });
    },
  },
};
</script>

<style lang="scss" scope>
.dictItem {
  h4,
  p {
    margin: 10px 0;
    padding: 0;
  }

  .dictTable {
    border: 1px solid black;
    border-collapse: collapse;
    td,
    th {
      border: 1px solid black;
      padding: 5px 10px;
      font-size: 14px;
    }
  }
}
</style>