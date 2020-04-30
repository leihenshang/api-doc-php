<template>
  <div class="create-api">
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
      <div class="btn-group-1">
        <!-- <button>继续添加</button> -->
        <button @click="createApi()">保存</button>
      </div>
    </div>
    <detailDescription
      v-if="showDescription"
      :description="description"
      v-on:update="description=$event"
    />
    <apiInfo
      v-if="showDescription === false"
      :groupList="groupList"
      :propertyList="propertyList"
      :groupId="groupId"
      v-on:update:apiInfo="apiInfo = $event"
      ref="apiInfo"
    />
    <requestParams
      :propertyList="propertyList"
      v-on:update:header="apiData.http_request_header=$event"
      v-on:update:param="apiData.http_request_params=$event"
    />
    <returnParams :propertyList="propertyList" v-on:update="apiData.http_return_params=$event" />
    <textBox
      v-on:update:success="apiData.http_return_sample.returnDataSuccess = $event"
      v-on:update:failed="apiData.http_return_sample.returnDataFailed = $event"
    />
  </div>
</template>

<script>
import textBox from "./units/returnDataTextBox.vue";
import returnParams from "./units/returnDataParams.vue";
import requestParams from "./units/requestDataParams.vue";
import apiInfo from "./units/apiInfo.vue";
import detailDescription from "./units/detailDescription.vue";

const CODE_OK = 200;
export default {
  name: "apiCreate",
  props: {
    groupId: [Number, String]
  },
  created() {
    this.getGroup();
    this.getProperty();
  },
  data() {
    return {
      //分组列表
      groupList: [],
      //api属性列表
      propertyList: [],
      //说明和备注
      description: "",
      apiInfo: {},
      apiData: {
        http_request_header: [], //请求头
        http_request_params: [], //请求参数
        http_return_params: [], //返回参数
        http_return_sample: {
          returnDataSuccess: "", //返回数据成功
          returnDataFailed: "" //返回数据失败
        }
      },
      finalData: {},
      showDescription: false,
      errors: "信息填写错误"
    };
  },
  methods: {
    errorHanle(val) {
      this.errors = val;
    },
    //返回api页面
    returnApiPage() {
      this.$router.go(-1);
    },
    //创建api
    createApi() {
     this.$refs.apiInfo.$refs.form.validate(validate => {
        if (validate) {
          //loading
          let loadingInstance = this.$loading({ fullscreen: true });
          let data = Object.assign(this.finalData, this.apiInfo);
          data = Object.assign(data, this.apiData);

          this.$http
            .post(
              this.apiAddress + "/api/create",
              {
                group_id: data.group_id,
                project_id: this.$route.params.id,
                data: JSON.stringify(data)
              },
              { emulateJSON: true }
            )
            .then(
              response => {
                response = response.body;
                if (response.code === CODE_OK) {
                  this.$message.success("保存api成功!");
                  //跳转携带分组参数
                  this.$router.push({
                    name: "apiList",
                    params: { groupId: this.groupId }
                  });
                } else {
                  this.$message.error("  保存api失败 ： " + response.msg);
                }
                this.$nextTick(() => {
                  loadingInstance.close();
                });
              },
              () => {
                this.$message.error("操作失败");
                this.$nextTick(() => {
                  loadingInstance.close();
                });
              }
            );
        } else {
          return false;
        }
      });
    },

    //获取分组信息
    getGroup() {
      this.$http
        .get(this.apiAddress + "/group/list", {
          params: {
            projectId: this.$route.params.id
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.groupList = response.data;
            }
          },
          () => {
            this.$message.error("获取数据失败");
          }
        );
    },
    //获取创建api的默认属性
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

.btn-group-1 button {
  border: 1px solid #dddddd;
  width: 90px;
  height: 30px;
  font-size: 12px;
  margin: 0;
  padding: 0;
  outline: none;
  border-right: none;
  border-left: none;
  border-radius: 3px;
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
