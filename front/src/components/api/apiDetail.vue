<template>
  <div class="create-api" v-loading="loading">
    <div class="box1">
      <div class="btn-group-1">
        <button @click="returnApiPage">↩ 接口列表</button>
      </div>
      <div class="btn-group-2">
        <button @click="updateApi()">编辑</button>
      </div>
    </div>
    <div class="box2">
      <div class="box2one" v-show="box2==0">
        <dl>
          <dd>
            <span></span>
            <em>
              分组:
              <i>{{groupName ? groupName : 'unknown'}}</i>
            </em>
            <em>
              请求协议:
              <i>{{apiData.protocol_type ? apiData.protocol_type : 'unknown'}}</i>
            </em>
            <em>
              请求方式:
              <i>{{apiData.http_method_type ? apiData.http_method_type : 'unknown'}}</i>
            </em>
          </dd>
          <dd>
            <span>URL:</span>
            <input type="text" v-model="apiData.url" readonly />
          </dd>
          <dd>
            <span>名称:</span>
            <input type="text" v-model="apiData.api_name" readonly />
          </dd>
        </dl>
      </div>
    </div>

    <div class="box2" v-show="apiData.description">
      <div class="box2two">
        <div class="description">{{apiData.description}}</div>
      </div>
    </div>

    <div class="box3" v-show="apiData.http_request_header.length > 0">
      <div class="item-head">
        <ul>
          <li>
            <button>请求头部</button>
          </li>
        </ul>
      </div>
      <table>
        <tr>
          <th>请求头名</th>
          <th>值</th>
        </tr>
        <tr v-for="item in apiData.http_request_header" :key="item.id">
          <td>
            <input type="text" placeholder="参数名" v-model="item.name" readonly />
          </td>
          <td>
            <input type="text" placeholder="值" v-model="item.content" readonly />
          </td>
        </tr>
      </table>
    </div>
    <div class="box3">
      <div class="item-head">
        <ul>
          <li>
            <button>请求参数</button>
          </li>
        </ul>
      </div>

      <table v-if="apiData.http_request_params">
        <tr>
          <th>参数名</th>
          <th>说明</th>
          <th>必填</th>
          <th>类型</th>
          <th>示例</th>
        </tr>
        <tr v-for="item in apiData.http_request_params" :key="item.id">
          <td>
            <input type="text" placeholder="参数名" v-model="item.name" readonly />
          </td>
          <td>
            <input type="text" placeholder v-model="item.desc" readonly />
          </td>
          <td>
            <em v-if="item.required" style="font-style:normal;">是</em>
            <em v-else style="font-style:normal;">否</em>
          </td>
          <td>
            <span>{{item.type}}</span>
          </td>
          <td>
            <input type="text" placeholder="参数示例" v-model="item.example" readonly />
          </td>
        </tr>
      </table>
      <table v-else>
        <tr>
          <th>参数名</th>
          <th>说明</th>
          <th>必填</th>
          <th>类型</th>
          <th>示例</th>
        </tr>
        <tr>
          <td colspan="5">无</td>
        </tr>
      </table>
    </div>
    <div class="box4" v-show="apiData.http_return_params[0]">
      <div class="item-head">
        <ul>
          <li>
            <button>返回参数</button>
          </li>
        </ul>
      </div>

      <table>
        <tr>
          <th>字段名</th>
          <th>相关类名</th>
          <th>说明</th>
          <th>必含</th>
          <th>类型</th>
        </tr>
        <tr v-for="item in apiData.http_return_params" :key="item.id">
          <td>
            <input type="text" placeholder="字段名" v-model="item.fieldName" readonly />
          </td>
          <td>
            <input type="text" placeholder v-model="item.objectName" readonly />
          </td>
          <td>
            <input type="text" placeholder="参数名" v-model="item.decription" readonly />
          </td>
          <td>
            <em v-if="item.required">是</em>
            <em v-else>否</em>
          </td>
          <td>
            <span>{{item.type}}</span>
          </td>
        </tr>
      </table>
    </div>
    <div class="box5">
      <div class="res-btn">
        <div class="btn-wrap">
          <button @click="box5=0" :class="{'tab-change-btn-bg' : box5==0}">成功</button>
          <button @click="box5=1" :class="{'tab-change-btn-bg' : box5==1}">失败</button>
        </div>
      </div>
      <div class="box5-show">
        <json-viewer
          v-show="box5==0"
          :value=" apiData.http_return_sample.returnDataSuccess ? JSON.parse(apiData.http_return_sample.returnDataSuccess) : {}"
          :expand-depth="4"
          copyable
        ></json-viewer>

        <json-viewer
          v-show="box5==1"
          :value="apiData.http_return_sample.returnDataFailed ? JSON.parse(apiData.http_return_sample.returnDataFailed) : {}"
        ></json-viewer>
      </div>
    </div>
  </div>
</template>

<script>
import JsonViewer from "vue-json-viewer";

const CODE_OK = 200;
export default {
  name: "apiDetail",
  props: {
    apiId: [Number, String]
  },
  created() {
    this.getApiDetail();
    this.getGroup();
  },
  data() {
    return {
      loading: true,
      groupList: [],
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
      box2: 0,
      box5: 0
    };
  },
  methods: {
    updateApi() {
      this.$router.push({ name: "apiEdit", params: { apiId: this.apiId } });
    },
    returnApiPage() {
      this.$router.go(-1);
    },
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
              this.loading = false;
            } else {
              this.$message({
                message: "failed:" + response.msg,
                type: "error"
              });
            }
          },
          () => {
            this.$message({
              message: "获取数据-操作失败",
              type: "error"
            });
          }
        );
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
    }
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
    }
  },
  watch: {
    apiId: function() {
      this.loading = true;
      this.getApiDetail();
    }
  },
  components: { JsonViewer }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
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

.box2 {
  border: 1px solid #dddddd;
  padding: 10px 10px 10px 10px;
  position: relative;
  background-color: #fff;
  margin: 10px 0;
  border-radius: 2px;
}

.box2one {
  padding-bottom: 20px;
}

.box2 em {
  font-style: normal;
  font-size: 12px;
  font-weight: 700;
  margin-right: 5px;
}

.box2 span {
  font-style: normal;
  font-size: 12px;
  font-weight: 700;
  display: inline-block;
  text-align: center;
  width: 5%;
}

.box2 dl dd {
  margin: 10px 0;
}

.box2 input,
select {
  padding: 0;
  outline: none;
  border: 1px solid #ddd;
  height: 28px;
  border-radius: 3px;
}

.box2 input {
  width: 94%;
  box-sizing: border-box;
  padding-left: 10px;
}

.box2 dl dd {
  font-size: 0;
  text-align: left;
}

.box2 dl dd select {
  font-size: 12px;
  margin: 0 5px;
}

.box2 dl dd:first-child select {
  margin-left: 0;
}

.box2two .description {
  width: 100%;
  height: 150px;
  border-radius: 4px;
  box-sizing: border-box;
  padding: 8px;
  font-size: 14px;
}

.box2twoIsShow {
  display: none;
}

/* 第三行开始 */
.box3 {
  margin-top: 10px;
  font-size: 14px;
}

.box3 ul {
  overflow: hidden;
}

.box3 ul li {
  float: left;
}

.box3 table {
  width: 100%;
  background-color: #fff;
}

.box3 header {
  background-color: #fff;
  border-left: 1px solid #ddd;
  display: flex;
  justify-content: flex-start;
  align-items: center;
}

.box3 header button {
  margin-left: 5px;
}

.box3 table,
.box3 td,
.box3 th {
  border: 1px solid #ddd;
  border-collapse: collapse;
}

.box3 th {
  background-color: #fafafa;
}

.box3 table tr,
.box3 header {
  height: 40px;
}

.box3 input[type="text"] {
  border: none;
  height: 40px;
  width: 100%;
  padding: 0 10px;
  box-sizing: border-box;
  /* outline: none; */
}

.box3 td {
  text-align: center;
}

.box3 input[type="checkbox"] {
  width: 80%;
}

.item-head {
  position: relative;
  height: 31px;
}

.item-head ul {
  position: absolute;
  bottom: -1px;
}

.item-head ul li {
  list-style: none;
}

.item-head ul button {
  border-radius: 3px;
}

.item-head li:nth-child(even) button {
  border-right: 1;
  border-left: none;
  border-bottom: none;
}

/* //第四行开始 */
.box4 {
  font-size: 14px;
  margin-top: 10px;
}

.box4 table {
  width: 100%;
  background-color: #fff;
}

.box4 table,
.box4 td,
.box4 th {
  border: 1px solid #ddd;
  border-collapse: collapse;
}

.box4 th {
  background-color: #fafafa;
}

.box4 table tr {
  height: 40px;
}

.box4 input[type="text"] {
  border: none;
  height: 40px;
  width: 100%;
  padding: 0 10px;
  box-sizing: border-box;
  outline: none;
}

.box4 td {
  text-align: center;
}

.box5 {
  margin-top: 40px;
}

.box5 .res-btn {
  position: relative;
  height: 30px;
}

.box5 .res-btn button {
  border-bottom: none;
  border-radius: 3px;
  height: 30px;
}

.box5 .res-btn button:nth-child(1) {
  border-right: none;
}

.box5-show {
  border: 1px solid #ddd;
  border-radius: 1px;
  background-color: #fff;
}

.btn-wrap {
  display: inline-block;
  position: absolute;
  left: 0;
}

/* tab切换按钮颜色 */
.tab-change-btn-bg {
  background-color: #fff;
}

em i {
  font-style: normal;
  border: 1px solid rgb(64, 165, 110);
  background-color: #4caf4f96;
  color: white;
  padding: 4px 5px;
  margin-left: 5px;
  border-radius: 4px;
  width: 50px;
  display: inline-block;
  text-align: center;
}

.create-api table tr:hover td,
.create-api table tr:hover input {
  background-color: rgba(164, 219, 132, 0.103);
}
</style>
