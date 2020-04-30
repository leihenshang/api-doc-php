<template>
  <div class="create-api" v-loading="loading">
    <div class="box1">
      <div class="btn-group-1">
        <button @click="returnApiPage">↩ 接口列表</button>
        <button
          @click="showDescription=false"
          v-bind:class="{ 'btn-group-1-btn-change' : showDescription==false}"
        >基础信息</button>
        <button
          @click="showDescription=true"
          v-bind:class="{ 'btn-group-1-btn-change' : showDescription==true}"
        >详细说明</button>
      </div>
      <!-- 保存按钮 -->
      <div class="btn-group-2">
        <button style="float:right;" @click="updateApi()">保存</button>
      </div>
    </div>
    <!-- 详细说明 -->
    <detailDescription
      v-if="showDescription"
      :description="apiData.description"
      v-on:update="apiData.description=$event"
    />
    <!-- api信息 -->
    <apiInfo
      v-if="showDescription === false"
      :groupList="groupList"
      :propertyList="propertyList"
      :apiData="apiData"
      ref="apiInfo"
    />

    <!-- 请求参数 -->
    <requestParams
      :propertyList="propertyList"
      v-on:update:header="apiData.http_request_header=$event"
      v-on:update:param="apiData.http_request_params=$event"
      :header="http_request_header"
      :params="http_request_params"
    />

    <!-- 响应参数 -->
    <returnParams
      :propertyList="propertyList"
      v-on:update="apiData.http_return_params=$event"
      :returnData="http_return_params"
    />

    <!-- 响应模板数据 -->
    <textBox
      v-on:update:success="apiData.http_return_sample.returnDataSuccess = $event"
      v-on:update:failed="apiData.http_return_sample.returnDataFailed = $event"
      :originSuccess="apiData.http_return_sample.returnDataSuccess"
      :originFailed="apiData.http_return_sample.returnDataFailed"
    />
  </div>
</template>

<script>
import returnParams from "./units/returnDataParams.vue";
import requestParams from "./units/requestDataParams.vue";
import apiInfo from "./units/apiInfo.vue";
import detailDescription from "./units/detailDescription.vue";
import textBox from "./units/returnDataTextBox.vue";
const CODE_OK = 200;
export default {
  name: "apiEdit",
  props: {
    apiId: [Number, String]
  },
  created() {
    this.getApiDetail();
    this.getGroup();
    this.getProperty();
  },
  data() {
    return {
      showDescription: false,
      loading: true,
      //说明和备注
      groupList: [],
      propertyList: [],
      apiData: {
        group_id: 0, //分组
        project_id: 0, //项目Id
        protocol_type: "HTTP", //协议
        description: "", //说明和备注
        requestMethod: "GET", //http请求方法
        http_return_type: 1, //返回值类型
        url: "", //http请求URL
        api_name: "", //接口名称
        object_name: "", //根对象名
        function_name: "", //程序内部方法名
        develop_language: "", //接口开发语言
        http_request_header: [], //请求头
        http_request_params: [], //请求参数
        http_return_params: [], //返回参数
        http_return_sample: {
          returnDataSuccess: "", //返回数据成功
          returnDataFailed: "" //返回数据失败
        }
      },
      http_request_header: [],
      http_request_params: [],
      http_return_params: []
    };
  },
  methods: {
    //获取api详情
    getApiDetail() {
      this.$http
        .get(this.apiAddress + "/api/detail", {
          params: {
            id: this.apiId
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.apiData = response.data;
              this.http_request_params = this.apiData.http_request_params;
              this.http_request_header = this.apiData.http_request_header;
              this.http_return_params = this.apiData.http_return_params;
            } else {
              this.$message.error("获取数据失败");
            }

            this.loading = false;
          },
          () => {
            this.$message.error("获取数据失败");
          }
        );
    },
    //返回api列表页面
    returnApiPage() {
      this.$router.go(-1);
    },
    //更新api
    updateApi() {
      this.$refs.apiInfo.$refs.form.validate(validate => {
        if (validate) {
          this.$http
            .post(
              this.apiAddress + "/api/update",
              {
                id: this.apiId,
                group_id: this.apiData.group_id,
                project_id: this.$route.params.id,
                data: JSON.stringify(this.apiData)
              },
              { emulateJSON: true }
            )
            .then(
              response => {
                response = response.body;
                if (response.code === CODE_OK) {
                  this.$message({
                    message: "更新数据成功！",
                    type: "success"
                  });
                  this.$router.go(-1);
                } else {
                  this.$message({
                    message: !response.msg ? response.msg : "",
                    type: "error"
                  });
                }
              },
              () => {
                this.$message.error("保存失败!");
              }
            );
        } else {
          return false;
        }
      });
    },
    //获取分组数据
    getGroup() {
      this.$http
        .get(this.apiAddress + "/group/list", {
          params: {
            projectId: this.$route.params.id,
            token: this.$store.state.userInfo.token
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.groupList = response.data;
            } else {
              this.$message.error("获取数据失败");
            }
          },
          () => {
            this.$message.error("获取数据失败");
          }
        );
    },
    //获取通用属性
    getProperty() {
      this.$http
        .get(this.apiAddress + "/property/list", {
          params: {}
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.propertyList = response.data;
            } else {
              this.$message.error("获取数据失败");
            }
          },
          () => {
            this.$message.error("获取数据失败");
          }
        );
    }
  },
  components: {
    textBox,
    returnParams,
    requestParams,
    apiInfo,
    detailDescription
  },
  watch: {
    apiId: function() {
      this.getApiDetail();
    }
  }
};
</script>

<style scoped>
.create-api {
  background-color: #f8f8f8;
}

/* 第一行按钮 */
.box1 {
  margin: 5px 0;
  display: flex;
  justify-content: space-between;
}

.btn-group-1 button,
.btn-group-2 button {
  border: 1px solid #dddddd;
  width: 90px;
  height: 30px;
  font-size: 12px;
  margin: 0;
  padding: 0;
  outline: none;
  border-radius: 3px;
}

.btn-group-1 button {
  border-right: none;
  border-left: none;
}

.btn-group-1-btn-change {
  background-color: #efefef;
}

.btn-group-1 button:first-child {
  margin: 0 10px 0 0;
  border-right: 1px solid #dddddd;
  border-left: 1px solid #dddddd;
}

.btn-group-1 button:nth-child(2) {
  border-left: 1px solid #dddddd;

  border-radius: 3px 0 0 3px;
}

.btn-group-1-btn-change {
  background-color: #4caf50;
  color: #fff;
}

.btn-group-1 button:nth-last-child(1) {
  border-right: 1px solid #dddddd;
  border-radius: 0 3px 3px 0;
}
</style>
