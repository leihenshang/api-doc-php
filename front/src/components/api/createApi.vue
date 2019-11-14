<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="create-api">
    <div class="box1">
      <div class="btn-group-1">
        <button @click="returnApiPage">↩ 接口列表</button>
        <button @click="box2=0" v-bind:class="{ 'btn-group-1-btn-change' : box2==0}">基础信息</button>
        <button @click="box2=1" v-bind:class="{ 'btn-group-1-btn-change' : box2==1}">详细说明</button>
        <!-- <button>高级mock</button> -->
      </div>
      <div class="btn-group-2">
        <button>继续添加</button>
        <button @click="createApi()">保存</button>
      </div>
    </div>
    <div class="box2">
      <div class="box2one" v-show="box2==0">
        <dl>
          <dd>
            <span>分组:</span>
            <select name id v-model="apiData.group">
              <option value="1">历史记录</option>
              <option value="2">订单</option>
            </select>
            <!-- <select name="" id="">
              <option value="1">可选（二级菜单）</option>
            </select>-->
            <!-- <em>状态:</em>
            <select name="" id="">
              <option value="1">启用</option>
              <option value="2">禁用</option>
            </select>-->
            <em>请求协议:</em>
            <select name id v-model="apiData.protocol">
              <option disabled value>请选择</option>
              <option value="HTTP">HTTP</option>
              <option value="HTTPS">HTTPS</option>
            </select>
            <em>请求方式:</em>
            <select name id v-model="apiData.requestMethod">
              <option value="POST">POST</option>
              <option value="GET">GET</option>
            </select>
            <em>返回情况:</em>
            <select name id v-model="apiData.returnDataType">
              <option value="无返回值（比如增删改查）">无返回值（比如增删改查）</option>
              <option value="列表">列表</option>
            </select>
          </dd>
          <dd>
            <span>URL:</span>
            <input type="text" v-model="apiData.url" />
          </dd>
          <dd>
            <span>名称:</span>
            <input type="text" v-model="apiData.name" />
          </dd>
          <dd>
            <span>根对象名:</span>
            <input type="text" v-model="apiData.objectName" />
          </dd>
          <dd>
            <span>方法:</span>
            <input type="text" v-model="apiData.functionName" />
          </dd>
          <dd>
            <span>接口语言:</span>
            <select name id v-model="apiData.developmentLanguage">
              <option value="PHP">PHP</option>
              <option value=".NET">.NET</option>
            </select>
          </dd>
        </dl>
      </div>
      <div class="box2two" v-show="box2==1">
        <textarea name id cols="30" rows="10" v-model="apiData.description"></textarea>
      </div>
    </div>

    <div class="box3">
      <div class="item-head">
        <ul>
          <li>
            <button @click="box3=0" :class="{'tab-change-btn-bg' : box3==0}">请求头部</button>
          </li>
          <li>
            <button @click="box3=1" :class="{'tab-change-btn-bg' : box3==1}">请求参数</button>
          </li>
          <!-- <li><button>inject</button></li> -->
        </ul>
      </div>
      <table v-show="box3==0">
        <header>
          <!-- <button>导入头部</button> -->
        </header>
        <tr>
          <th>请求头名</th>
          <th>说明</th>
          <th>必填</th>
          <th>类型</th>
          <th>示例</th>
          <th>操作</th>
        </tr>
        <tr>
          <td>
            <input type="text" placeholder="参数名" />
          </td>
          <td>
            <input type="text" placeholder="参数名" />
          </td>
          <td>
            <input type="checkbox" name id />
          </td>
          <td>
            <input type="text" placeholder="参数名" />
          </td>
          <td>
            <input type="text" placeholder="参数示例" />
          </td>
          <td></td>
        </tr>
      </table>
      <table v-show="box3==1">
        <header>
          <!-- <button>导入头部</button> -->
        </header>
        <tr>
          <th>参数名</th>
          <th>说明</th>
          <th>必填</th>
          <th>类型</th>
          <th>示例</th>
          <th>操作</th>
        </tr>
        <tr v-for="(item,index) in box3Item" :key="item.id">
          <td>
            <input
              type="text"
              placeholder="参数名"
              v-on:input="box3Input(index,$event)"
              v-model="item.name"
            />
          </td>
          <td>
            <input type="text" placeholder v-model="item.desc" />
          </td>
          <td>
            <input type="checkbox" name id v-model="item.required" />
          </td>
          <td>
            <select style="width:90%;text-align:center;margin:0 10px;" v-model="item.type">
              <option value="int">int</option>
              <option value="array">array</option>
              <option value="object">object</option>
              <option value="long">long</option>
              <option value="string">string</option>
            </select>
          </td>
          <td>
            <input type="text" placeholder="参数示例" v-model="item.example" />
          </td>
          <td>
            <div v-show="item.name.length >= 1">
              <button @click="box3delete(index)">×</button>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div class="box4">
      <header>
        <span>返回参数</span>
      </header>
      <header>
        <span>导入json</span>
      </header>
      <table>
        <tr>
          <th>字段名</th>
          <th>相关类名</th>
          <th>说明</th>
          <th>必含</th>
          <th>类型</th>
          <th>操作</th>
        </tr>
        <tr v-for="(item,index) in box4Item" :key="item.id">
          <td>
            <input
              type="text"
              placeholder="字段名"
              v-model="item.fieldName"
              v-on:input="box4Input(index,$event)"
            />
          </td>
          <td>
            <input type="text" placeholder v-model="item.objectName" />
          </td>
          <td>
            <input type="text" placeholder="参数名" v-model="item.decription" />
          </td>
          <td>
            <input type="checkbox" name id v-model="item.required" />
          </td>
          <td>
            <select style="width:90%;text-align:center;margin:0 10px;" v-model="item.type">
              <option value="int">int</option>
              <option value="array">array</option>
              <option value="object">object</option>
              <option value="long">long</option>
              <option value="string">string</option>
            </select>
          </td>
          <td>
            <div v-show="item.fieldName.length >= 1">
              <button @click="box4delete(index)">×</button>
            </div>
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
      <textarea name id v-model="apiData.returnDataSuccess" v-show="box5==0" placeholder="成功的返回"></textarea>
      <textarea name id v-model="apiData.returnDataFailed" v-show="box5==1" placeholder="失败的返回"></textarea>
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "createApi",
  props: {
    id: String,
    apiList: Array
  },
  created() {},
  data() {
    return {
      apiData: {
        group: "", //分组
        protocol: "http", //协议
        description: "", //说明和备注
        requestMethod: "GET", //http请求方法
        returnDataType: 1, //返回值类型
        url: "", //http请求URL
        name: "", //接口名称
        objectName: "", //根对象名
        functionName: "", //程序内部方法名
        developmentLanguage: "", //接口开发语言
        requestHeader: [], //请求头
        requestParams: [], //请求参数
        returnData: [], //返回参数
        returnDataSuccess: "", //返回数据成功
        returnDataFailed: "" //返回数据失败
      },
      box2: 0,
      box3: 1,
      box3Item: [
        {
          name: "",
          desc: "",
          required: false,
          type: "string",
          example: "",
          handle: true,
          isAdd: false
        }
      ],
      box4Item: [
        {
          fieldName: "",
          objectName: "",
          description: "",
          required: false,
          type: "string",
          handle: true,
          isAdd: false
        }
      ],
      box5: 0
    };
  },
  methods: {
    returnApiPage() {
      this.$router.go(-1);
    },
    createApi() {
      this.apiData.returnData = this.box4Item.splice(
        0,
        this.box4Item.length - 1
      );
      this.apiData.requestParams = this.box3Item.splice(
        0,
        this.box3Item.length - 1
      );

      this.$http
        .post(
          this.apiAddress + "/api/create",
          {
            group_id: this.apiData.group,
            project_id: this.$route.params.id,
            data: JSON.stringify(this.apiData)
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              alert("成功！~");
            }
          },
          function(res) {
            let response = res.body;
            alert("操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    box3Input(index, event) {
      if (event) {
        // alert(index);
        let txt = event.target.value;
        if (txt.length >= 1 && this.box3Item[index].isAdd === false) {
          this.box3Item.push({
            name: "",
            desc: "",
            required: false,
            type: "string",
            example: "",
            handle: true,
            isAdd: false
          });
          this.box3Item[index].isAdd = true;
        }
      }
    },
    box4Input(index, event) {
      if (event) {
        // alert(index);
        let txt = event.target.value;
        if (txt.length >= 1 && this.box4Item[index].isAdd === false) {
          this.box4Item.push({
            fieldName: "",
            objectName: "",
            description: "",
            required: false,
            type: "string",
            handle: true,
            isAdd: false
          });
          this.box4Item[index].isAdd = true;
        }
      }
    },
    box3delete(key) {
      this.box3Item.splice(key, 1);
    },
    box4delete(key) {
      this.box4Item.splice(key, 1);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.create-api {
  padding: 10px;
  background-color: #f8f8f8;
}

/* 第一行按钮 */
.box1 {
  margin: 5px 0;
  display: flex;
  justify-content: space-between;
}

button {
  background-color: #fff;
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

/* 第一行结束 */
/* 第二行开始 */
.box2 {
  border: 1px solid #dddddd;
  padding: 0 10px;
  position: relative;
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
  text-align: left;
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

.box2two textarea {
  width: 100%;
  height: 100%;
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
  border-top: 1px solid #ddd;
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
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

.box4 header span {
  margin-left: 5px;
  font-weight: 700;
}

.box4 table {
  width: 100%;
  background-color: #fff;
}

.box4 header {
  background-color: #fff;
  border-top: 1px solid #ddd;
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
  display: flex;
  justify-content: flex-start;
  align-items: center;
}

.box4 header button {
  margin-left: 5px;
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

.box4 table tr,
.box4 header {
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

.box4 header:nth-child(1) span {
  margin-left: 12px;
}

.box4 header:nth-child(2) span {
  border: 1px solid #bcdffb;
  padding: 5px 7px;
  border-radius: 3px;
  background-color: #e3f7ff;
  color: #3692ed;
  font-weight: 500;
}

.box5 {
  margin-top: 10px;
}

.box5 textarea {
  width: 100%;
  min-height: 120px;
  outline: none;
  border: 1px solid #ddd;
  padding: 5px;
  resize: none;
  box-sizing: border-box;
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

.btn-wrap {
  display: inline-block;
  position: absolute;
  left: 0;
}

/* tab切换按钮颜色 */
.tab-change-btn-bg {
  background-color: #efefef;
}
</style>
