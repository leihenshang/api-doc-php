<template>
  <div class="create-api">
    <div class="box1">
      <div class="btn-group-1">
        <button @click="returnApiPage">↩ 接口列表</button>
        <button @click="box2=0" v-bind:class="{ 'btn-group-1-btn-change' : box2==0}">基础信息</button>
        <button @click="box2=1" v-bind:class="{ 'btn-group-1-btn-change' : box2==1}">详细说明</button>
      </div>
      <div class="btn-group-2">
        <button>继续添加</button>
        <button @click="createApi()">保存</button>
      </div>
    </div>
    <apiInfo :groupList="groupList" :propertyList="propertyList" />
    <requestParams :propertyList="propertyList" />
    <returnParams :propertyList="propertyList" v-on:update="apiData.http_return_params = $event" />
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

const CODE_OK = 200;
export default {
  name: "createApi",
  props: {
    id: String,
    apiList: Array
  },
  created() {
    this.getGroup();
    this.getProperty();
  },
  data() {
    return {
      groupList: [],
      propertyList: [],
      apiData: {
        group_id: 0, //分组
        project_id: 0, //项目Id
        protocol_type: "HTTP", //协议
        description: "", //说明和备注
        requestMethod: "GET", //http请求方法
        http_return_type: "", //返回值类型
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
      box2: 0
    };
  },
  methods: {
    parseJson(jsonObj, data = [], sparator = "") {
      //数组的处理
      if (Array.isArray(jsonObj)) {
        this.parseJson(jsonObj[0], data);
      }

      //处理对象
      if (Object.prototype.toString.call(jsonObj) === "[object Object]") {
        for (let v in jsonObj) {
          data.push(sparator + v);
          let element = jsonObj[v];
          //v是键， element是值
          if (Object.prototype.toString.call(element) === "[object Object]") {
            this.parseJson(element, data, sparator + ">");
          }

          if (Array.isArray(element)) {
            this.parseJson(element[0], data, sparator + ">");
          }
        }
      }
    },
    //返回api页面
    returnApiPage() {
      this.$router.go(-1);
    },
    //创建api
    createApi() {
      //数据验证
      this.$refs.form.validate().then(res => {
        if (!res) {
          alert(JSON.stringify(this.$refs.form.errors));
          return;
        }

        let data = this.apiData;
        let box4 = JSON.parse(JSON.stringify(this.box4Item));
        let box3 = JSON.parse(JSON.stringify(this.box3Item));
        let box3Header = JSON.parse(JSON.stringify(this.box3HeaderItem));
        data.http_return_params = box4.splice(0, this.box4Item.length - 1);
        data.http_request_params = box3.splice(0, this.box3Item.length - 1);
        data.http_request_header = box3Header.splice(
          0,
          this.box3HeaderItem.length - 1
        );

        this.$http
          .post(
            this.apiAddress + "/api/create",
            {
              group_id: this.apiData.group_id,
              project_id: this.$route.params.id,
              data: JSON.stringify(data),
              token: this.$store.state.userInfo.token
            },
            { emulateJSON: true }
          )
          .then(
            response => {
              response = response.body;
              if (response.code === CODE_OK) {
                alert("成功！~");
                return;
              } else {
                alert("失败!" + response.msg);
                return;
              }
            },
            res => {
              let response = res.body;
              alert("操作失败!" + !response.msg ? response.msg : "");
              return;
            }
          );
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
          res => {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
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
          res => {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    }
  },
  components: {
    textBox,
    returnParams,
    requestParams,
    apiInfo
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

button {
  background-color: #efefef;
  border: 1px solid #dddddd;
  width: 90px;
  height: 30px;
  font-size: 12px;
  margin: 0;
  padding: 0;
  outline: none;
}

.btn-group-1 {
  font-size: 0;
}

.btn-group-1 button {
  border-right: none;
  border-left: none;
  border-radius: 3px;
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
