<template>
  <div class="api-info-box">
    <div class="box2">
      <div class="box2one" v-show="box2==0">
        <dl>
          <dd>
            <span>分组:</span>

            <select v-model="apiData.group_id">
              <option disabled>请选择</option>
              <option v-for="item in groupList" :key="item.id" :value="item.id">{{item.title}}</option>
            </select>
            <em>请求协议:</em>

            <select name id v-model="apiData.protocol_type" v-if="propertyList.http_protocol">
              <option disabled value>请选择</option>
              <option
                v-for="item in propertyList.http_protocol"
                :key="item.id"
                :value="item.tag_name"
              >{{item.tag_name}}</option>
            </select>
            <em>请求方式:</em>

            <select name id v-model="apiData.http_method_type" v-if="propertyList.http_method">
              <option disabled value>请选择</option>
              <option
                v-for="item in propertyList.http_method"
                :key="item.id"
                :value="item.tag_name"
              >{{item.tag_name}}</option>
            </select>
            <em>返回情况:</em>

            <select name id v-model="apiData.http_return_type" v-if="propertyList.http_return">
              <option disabled value>请选择</option>
              <option
                v-for="item in propertyList.http_return"
                :key="item.id"
                :value="item.tag_name"
              >{{item.description}}</option>
            </select>
          </dd>
          <dd>
            <span>URL:</span>

            <input type="text" v-model="apiData.url" />
          </dd>
          <dd>
            <span>名称:</span>

            <input type="text" v-model="apiData.api_name" />
          </dd>
          <dd>
            <span>根对象名:</span>

            <input type="text" v-model="apiData.object_name" />
          </dd>
          <dd>
            <span>方法:</span>

            <input type="text" v-model="apiData.function_name" />
          </dd>
          <dd>
            <span>接口语言:</span>

            <select v-model="apiData.develop_language" v-if="propertyList.api_language">
              <option disabled value>请选择</option>
              <option
                v-for="item in propertyList.api_language"
                :key="item.id"
                :value="item.tag_name"
              >{{item.tag_name}}</option>
            </select>
          </dd>
        </dl>
      </div>
      <div class="box2two" v-show="box2==1">
        <textarea name id cols="30" rows="10" v-model="apiData.description"></textarea>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "apiInfo",
  props: {
    groupList: Array,
    propertyList: [Array, Object]
  },
  data() {
    return {
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
  }
};
</script>

<style scoped>
dl dd div {
  display: inline-block;
  width: 88%;
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


.box2 {
  border: 1px solid #dddddd;
  padding: 10px 10px 30px 10px;
  position: relative;
  background-color: #fff;
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
  width: 4%;
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
  width: 100%;
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
  border-radius: 5px;
  resize: none;
  outline: none;
  border: 1px solid rgb(204, 203, 203);
}

.box2twoIsShow {
  display: none;
}
</style>