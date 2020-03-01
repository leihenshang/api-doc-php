<template>
  <div class="api-info-box">
    <div class="info">
      <div class="box2one" v-show="show==0">
        <dl>
          <dd>
            <span>分组:</span>

            <select v-model="apiInfo.group_id">
              <option disabled>请选择</option>
              <option v-for="item in groupList" :key="item.id" :value="item.id">{{item.title}}</option>
            </select>
            <em>请求协议:</em>

            <select name id v-model="apiInfo.protocol_type" v-if="propertyList.http_protocol">
              <option disabled value>请选择</option>
              <option
                v-for="item in propertyList.http_protocol"
                :key="item.id"
                :value="item.tag_name"
              >{{item.tag_name}}</option>
            </select>
            <em>请求方式:</em>

            <select name id v-model="apiInfo.http_method_type" v-if="propertyList.http_method">
              <option disabled value>请选择</option>
              <option
                v-for="item in propertyList.http_method"
                :key="item.id"
                :value="item.tag_name"
              >{{item.tag_name}}</option>
            </select>
            <em>返回情况:</em>

            <select name id v-model="apiInfo.http_return_type" v-if="propertyList.http_return">
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

            <input type="text" v-model="apiInfo.url" />
          </dd>
          <dd>
            <span>名称:</span>

            <input type="text" v-model="apiInfo.api_name" />
          </dd>
          <dd>
            <span>根对象名:</span>

            <input type="text" v-model="apiInfo.object_name" />
          </dd>
          <dd>
            <span>方法:</span>

            <input type="text" v-model="apiInfo.function_name" />
          </dd>
          <dd>
            <span>接口语言:</span>

            <select v-model="apiInfo.develop_language" v-if="propertyList.api_language">
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
    </div>
  </div>
</template>

<script>
export default {
  name: "apiInfo",
  props: {
    groupList: Array,
    propertyList: [Array, Object],
    apiData: Object
  },
  data() {
    return {
      apiInfo: {
        group_id: 0, //分组
        project_id: 0, //项目Id
        protocol_type: "", //协议
        requestMethod: "", //http请求方法
        http_return_type: "", //返回值类型
        url: "", //http请求URL
        api_name: "", //接口名称
        object_name: "", //根对象名
        function_name: "", //程序内部方法名
        develop_language: "" //接口开发语言
      },
      show: 0
    };
  },
  watch: {
    apiData: function() {
      this.apiInfo = this.apiData;
    },
    apiInfoNew: function(val) {
      this.$emit("update:apiInfo", val);
    }
  },
  computed: {
    //由于watch无法监听对象的改变，所以使用计算方法来代替
    apiInfoNew() {
      return JSON.parse(JSON.stringify(this.apiInfo));
    }
  }
};
</script>

<style scoped>
dl dd div {
  display: inline-block;
  width: 88%;
}

.info {
  border: 1px solid #dddddd;
  padding: 10px 10px 30px 10px;
  position: relative;
  background-color: #fff;
}

.info em {
  font-style: normal;
  font-size: 12px;
  font-weight: 700;
  margin-right: 5px;
}

.info span {
  font-style: normal;
  font-size: 12px;
  font-weight: 700;
  display: inline-block;
  text-align: left;
  width: 4%;
}

.info dl dd {
  margin: 10px 0;
}

.info input,
select {
  padding: 0;
  outline: none;
  border: 1px solid #ddd;
  height: 28px;
  border-radius: 3px;
}

.info input {
  width: 80%;
  box-sizing: border-box;
  padding-left: 10px;
}

.info dl dd {
  font-size: 0;
  text-align: left;
}

.info dl dd select {
  font-size: 12px;
  margin: 0 5px;
}

.info dl dd:first-child select {
  margin-left: 0;
}
</style>