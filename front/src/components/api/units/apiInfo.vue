<template>
  <div class="api-info-box">
    <div class="info">
      <ValidationObserver ref="form" tag="div">
        <dl>
          <dd>
            <span></span>
            <i>分组:</i>
            <ValidationProvider rules="required" v-slot="{ errors }" name="分组" tag="p">
              <select v-model="apiInfo.group_id">
                <option disabled>请选择</option>
                <option v-for="item in groupList" :key="item.id" :value="item.id">{{item.title}}</option>
              </select>
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
            <i>请求协议:</i>

            <ValidationProvider rules="required" v-slot="{ errors }" name="请求协议" tag="p">
              <select v-model="apiInfo.protocol_type" v-if="propertyList.http_protocol">
                <option disabled>请选择</option>
                <option
                  v-for="item in propertyList.http_protocol"
                  :key="item.id"
                  :value="item.tag_name"
                >{{item.tag_name}}</option>
              </select>
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
            <i>请求方式:</i>
            <ValidationProvider rules="required" v-slot="{ errors }" name="请求方式" tag="p">
              <select name id v-model="apiInfo.http_method_type" v-if="propertyList.http_method">
                <option disabled value>请选择</option>
                <option
                  v-for="item in propertyList.http_method"
                  :key="item.id"
                  :value="item.tag_name"
                >{{item.tag_name}}</option>
              </select>
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
            <i>返回情况:</i>
            <ValidationProvider rules="required" v-slot="{ errors }" name="返回情况" tag="p">
              <select name id v-model="apiInfo.http_return_type" v-if="propertyList.http_return">
                <option disabled>请选择</option>
                <option
                  v-for="item in propertyList.http_return"
                  :key="item.id"
                  :value="item.tag_name"
                >{{item.description}}</option>
              </select>
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
          </dd>
          <dd>
            <span>URL:</span>
            <ValidationProvider rules="required" v-slot="{ errors }" name="url" tag="div">
              <input type="text" v-model="apiInfo.url" />
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
          </dd>
          <dd>
            <span>名称:</span>
            <ValidationProvider rules="required" v-slot="{ errors }" name="api名称" tag="div">
              <input type="text" v-model="apiInfo.api_name" />
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
          </dd>
          <dd>
            <span>根对象名:</span>
            <ValidationProvider rules="required" v-slot="{ errors }" name="对象名" tag="div">
              <input type="text" v-model="apiInfo.object_name" />
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
          </dd>
          <dd>
            <span>方法:</span>
            <ValidationProvider rules="required" v-slot="{ errors }" name="方法名" tag="div">
              <input type="text" v-model="apiInfo.function_name" />
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
          </dd>

          <dd>
            <span>接口语言:</span>
            <ValidationProvider rules="required" v-slot="{ errors }" name="api开发语言" tag="div">
              <select v-model="apiInfo.develop_language" v-if="propertyList.api_language">
                <option disabled>请选择</option>
                <option
                  v-for="item in propertyList.api_language"
                  :key="item.id"
                  :value="item.tag_name"
                >{{item.tag_name}}</option>
              </select>
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
          </dd>
        </dl>
      </ValidationObserver>
    </div>
  </div>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate";

export default {
  name: "apiInfo",
  props: {
    groupList: Array,
    propertyList: [Array, Object],
    apiData: Object,
    groupId: [String, Number]
  },
  data() {
    return {
      apiInfo: {
        group_id: this.groupId, //分组
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
    },
    apiInfo: {
      handler: function(newdata) {
        this.$refs.form.validate().then(success => {
          if (!success) {
            this.$emit("error", "信息填写错误");
            return;
          }

          this.$emit("error", "");
          // Wait until the models are updated in the UI
          this.$nextTick(() => {
            this.$refs.form.reset();
          });
        });
      },
      deep: true
    }
  },
  computed: {
    //由于watch无法监听对象的改变，所以使用计算方法来代替
    apiInfoNew() {
      return JSON.parse(JSON.stringify(this.apiInfo));
    }
  },
  components: {
    ValidationProvider,
    ValidationObserver
  },
  created() {}
};
</script>

<style scoped>
dl dd div {
  display: inline-block;
  width: 95%;
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
  margin: 0 5px;
  display: inline-block;
  color: red;
}

.info p {
  display: inline-block;
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

.info dl dd i {
  font-size: 12px;
  font-style: normal;
  margin-right: 4px;
  font-weight: 600;
}

.info dl dd:first-child select {
  margin-left: 0;
}
</style>