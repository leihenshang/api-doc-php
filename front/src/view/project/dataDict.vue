<template>
  <div class="dataDict">
    <el-button>
      <i class="el-icon-plus"></i>新增
    </el-button>
    <el-divider></el-divider>
    <!-- 数据-开始 -->
    <el-table :data="dataArr" stripe style="width: 100%" border v-loading="loading">
      <el-table-column prop="address" label="地址" width="180"></el-table-column>
      <el-table-column prop="port" label="端口" width="180"></el-table-column>
      <el-table-column prop="username" label="用户名"></el-table-column>
      <el-table-column prop="password" label="密码"></el-table-column>
      <el-table-column prop="database_name" label="数据库名"></el-table-column>
      <el-table-column prop="create_time" label="创建时间"></el-table-column>
      <el-table-column prop="create_user" label="创建者"></el-table-column>
      <el-table-column align="center" label="操作">
        <template slot-scope="scope">
          <el-button type="text">删除</el-button>
          <el-divider direction="vertical"></el-divider>
          <el-button type="text">编辑</el-button>
          <el-divider direction="vertical"></el-divider>
          <el-button type="text">字典</el-button>
        </template>
      </el-table-column>
    </el-table>
    <!-- 数据-结束 -->
  </div>
</template>

<script>
const CODE_OK = 200;

export default {
  name: "dataDict",
  data() {
    return {
      loading: false,
      dataArr: [
        {
          address: "测试地址",
          port: 1000,
          username: "测试用户1",
          password: "*********",
          database_name: "test1",
          create_time: "2020-20-20",
          create_user: "tangzq",
        },
        {
          address: "测试地址",
          port: 1000,
          username: "测试用户1",
          password: "*********",
          database_name: "test1",
          create_time: "2020-20-20",
          create_user: "tangzq",
        },
        {
          address: "测试地址",
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
    handleCommand(val) {
      switch (val.action) {
        case "setPermission":
          this.setPermission(val.data);
          break;

        default:
          break;
      }
    },
  },
};
</script>

<style lang="scss" scope>
.user-search {
  margin: 10px 0;
}
</style>