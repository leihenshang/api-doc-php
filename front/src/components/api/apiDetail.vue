<template>
  <div class="api-detail" v-loading="loading">
    <div class="btn-group">
      <el-button @click="returnApiPage">↩ 接口列表</el-button>
      <el-button @click="updateApi()" v-show="$store.state.projectPermission == 6" type="primary">编辑</el-button>
    </div>
    <!-- api信息 -->
    <div class="api-detail-info">
      <i>{{apiData.url ? apiData.url : 'unknown'}}</i>
      <el-divider direction="vertical"></el-divider>

      <i>{{apiData.api_name ? apiData.api_name : 'unknown'}}</i>
      <el-divider direction="vertical"></el-divider>
      <em>
        分组:
        <i>{{groupName ? groupName : 'unknown'}}</i>
      </em>
      <el-divider direction="vertical"></el-divider>
      <em>
        请求协议:
        <i>{{apiData.protocol_type ? apiData.protocol_type : 'unknown'}}</i>
      </em>
      <el-divider direction="vertical"></el-divider>
      <em>
        请求方式:
        <i>{{apiData.http_method_type ? apiData.http_method_type : 'unknown'}}</i>
      </em>
      <el-divider content-position="left">备注</el-divider>
      <p style="font-size:14px;">{{apiData.description ? apiData.description :"无" }}</p>
    </div>
    <!-- api信息-结束 -->
    <el-divider content-position="center">请求头</el-divider>
    <!-- 请求头信息 -->
    <div class="content-item" v-show="apiData.http_request_header">
      <el-table :data="apiData.http_request_header" style="width: 100%" border stripe>
        <el-table-column prop="name" label="请求头"></el-table-column>
        <el-table-column prop="content" label="值"></el-table-column>
      </el-table>
    </div>
    <!-- 请求头信息-结束 -->
    <el-divider content-position="center">参数</el-divider>
    <!-- 参数 -->
    <div class="content-item">
      <div @click="copyAsPostman()" style="margin:5px 0;">
        <el-button size="mini">生成调试参数</el-button>
      </div>

      <el-dialog title="复制到剪贴板" :visible.sync="dialogFormVisible" width="30%">
        <el-form>
          <el-form-item label="分隔符">
            <el-select v-model="delimiter" @change="generateStrParams()">
              <el-option label="冒号(:)" value=":"></el-option>
              <el-option label="逗号(,)" value=","></el-option>
              <el-option label="空格( )" value=" "></el-option>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-input type="textarea" v-model="copyStr" :rows="8"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button @click="copyToClipboard()">复制</el-button>
          </el-form-item>
        </el-form>
      </el-dialog>

      <el-table :data="apiData.http_request_params" style="width: 100%" stripe border>
        <el-table-column prop="name" label="参数" width="180"></el-table-column>
        <el-table-column prop="desc" label="说明" width="180"></el-table-column>
        <el-table-column prop="required" label="必填"></el-table-column>
        <el-table-column prop="type" label="类型"></el-table-column>
        <el-table-column prop="example" label="示例"></el-table-column>
      </el-table>
    </div>
    <!-- 参数-结束 -->
    <el-divider content-position="center">响应</el-divider>
    <!-- 响应 -->
    <div class="content-item" v-show="apiData.http_return_params ">
      <el-table :data="apiData.http_return_params" style="width: 100%" stripe border>
        <el-table-column prop="fieldName" label="字段" width="180"></el-table-column>
        <el-table-column prop="objectName" label="类名" width="180"></el-table-column>
        <el-table-column prop="description" label="说明"></el-table-column>
        <el-table-column prop="required" label="必含"></el-table-column>
        <el-table-column prop="type" label="类型"></el-table-column>
      </el-table>
    </div>
    <!-- 响应-结束 -->
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "apiDetail",
  props: {
    apiId: [Number, String],
  },
  created() {
    this.getApiDetail();
    this.getGroup();
  },
  data() {
    return {
      delimiter: ":",
      dialogFormVisible: false,
      copyStr: "",
      loading: true,
      groupList: [],
      apiData: {},
    };
  },
  methods: {
    copyToClipboard() {
      if (this.$clipboard(this.copyStr) === true) {
        this.$message.success("复制成功，使用ctrl + v粘贴");
        this.dialogFormVisible = !this.dialogFormVisible;
      }
    },
    //复制为postman参数
    copyAsPostman() {
      this.generateStrParams();
      this.dialogFormVisible = true;
    },
    //生成参数字符串
    generateStrParams() {
      this.copyStr = "";
      for (let value of this.apiData.http_request_params) {
        this.copyStr +=
          value.name +
          this.delimiter +
          (value.example ? value.example : "unknown") +
          "\r\n";
      }
    },
    updateApi() {
      this.$router.push({ name: "apiEdit", params: { apiId: this.apiId } });
    },
    returnApiPage() {
      this.$router.go(-1);
    },
    //获取api详情
    getApiDetail() {
      this.$http
        .get("/api/detail", {
          params: {
            id: this.apiId,
          },
        })
        .then(
          (response) => {
            response = response.data;
            if (response.code === CODE_OK) {
              this.apiData = response.data;
              this.loading = false;
            } else {
              this.$message({
                message: "failed:" + response.msg,
                type: "error",
              });
            }
          },
          () => {
            this.$message({
              message: "获取数据-操作失败",
              type: "error",
            });
          }
        );
    },
    //获取分组信息
    getGroup() {
      this.$http
        .get("/group/list", {
          params: {
            projectId: this.$route.params.id,
          },
        })
        .then(
          (response) => {
            response = response.data;
            if (response.code === CODE_OK) {
              this.groupList = response.data;
            }
          },
          () => {
            this.$message.error("获取数据失败");
          }
        );
    },
  },
  computed: {
    groupName() {
      let groupName = "unknown";
      for (let item of this.groupList) {
        if (item.id == this.apiData.group_id) {
          groupName = item.title;
        }
      }

      return groupName;
    },
  },
  watch: {
    apiId: function () {
      this.loading = true;
      this.getApiDetail();
    },
  },
  components: {},
};
</script>

<style lang="scss" scoped>
.api-detail {
  padding-left: 10px;
  
  .btn-group {
    display: flex;
    justify-content: space-between;
  }

  .api-detail-info {
    padding: 10px;
    position: relative;
    background-color: #fff;
    margin: 10px 0;
    border-radius: 2px;
    em i {
      font-style: normal;
      background-color: #4caf4fc7;
      color: white;
      padding: 5px 6px;
      margin-left: 5px;
      border-radius: 4px;
      display: inline-block;
      text-align: center;
    }

    i {
      font-style: normal;
      font-weight: bold;
    }

    em {
      font-style: normal;
      font-size: 12px;
      font-weight: 700;
      margin-right: 5px;
    }

    span {
      font-style: normal;
      font-size: 12px;
      font-weight: 700;
      display: inline-block;
      text-align: center;
      width: 5%;
    }

    .api-detail-comment {
      width: 100%;
      height: 150px;
      border-radius: 4px;
      box-sizing: border-box;
      padding: 8px;
      font-size: 14px;
    }
  }

  .content-item {
    margin: 10px 0;
    padding: 10px 8px;
    box-sizing: border-box;
    background-color: #f5f6f7;
  }
}
</style>
