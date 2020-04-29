<template>
  <div class="api-info-box">
    <div class="info">
      <el-form :model="apiInfo" :rules="rules" ref="form" size="small">
        <el-form-item>
          <el-col :span="5">
            <el-form-item prop="group_id" label="分组" label-width="80px">
              <el-select v-model="apiInfo.group_id" placeholder="分组">
                <el-option
                  v-for="item in groupList"
                  :key="item.id"
                  :label="item.title"
                  :value="item.id"
                ></el-option>
              </el-select>
            </el-form-item>
          </el-col>

          <el-col :span="5">
            <el-form-item label="请求协议" prop="protocol_type" label-width="80px">
              <el-select v-model="apiInfo.protocol_type" placeholder="选择请求协议">
                <el-option
                  v-for="item in propertyList.http_protocol"
                  :key="item.id"
                  :label="item.tag_name"
                  :value="item.tag_name"
                ></el-option>
              </el-select>
            </el-form-item>
          </el-col>

          <el-col :span="5">
            <el-form-item label="请求方式" prop="http_method_type" label-width="80px">
              <el-select v-model="apiInfo.http_method_type" placeholder="选择请求方式">
                <el-option
                  v-for="item in propertyList.http_method"
                  :key="item.id"
                  :label="item.tag_name"
                  :value="item.tag_name"
                ></el-option>
              </el-select>
            </el-form-item>
          </el-col>
          <el-col :span="5">
            <el-form-item label="返回类型" prop="http_return_type" label-width="80px">
              <el-select v-model="apiInfo.http_return_type" placeholder="选择返回类型">
                <el-option
                  v-for="item in propertyList.http_return"
                  :key="item.id"
                  :label="item.description"
                  :value="item.tag_name"
                ></el-option>
              </el-select>
            </el-form-item>
          </el-col>
        </el-form-item>

        <el-form-item label="url" prop="url" label-width="80px">
          <el-input v-model="apiInfo.url"></el-input>
        </el-form-item>

        <el-form-item label="名称" prop="api_name" label-width="80px">
          <el-input v-model="apiInfo.api_name"></el-input>
        </el-form-item>

        <el-form-item label="根对象名" prop="object_name" label-width="80px">
          <el-input v-model="apiInfo.object_name"></el-input>
        </el-form-item>

        <el-form-item label="方法" prop="function_name" label-width="80px">
          <el-input v-model="apiInfo.function_name"></el-input>
        </el-form-item>

        <el-form-item label="开发语言" prop="develop_language" label-width="80px">
          <el-select v-model="apiInfo.develop_language" placeholder="选择开发语言">
            <el-option
              v-for="item in propertyList.api_language"
              :key="item.id"
              :label="item.tag_name"
              :value="item.tag_name"
            ></el-option>
          </el-select>
        </el-form-item>
      </el-form>
    </div>

    <!-- <div class="info">
      <ValidationObserver ref="form" tag="div">
        <dl>
          <dd>
            <span></span>
            <i>分组:</i>
            <ValidationProvider rules="required" v-slot="{ errors }" name="分组" tag="p">
              <select v-model="apiInfo.group_id">
                <option v-for="item in groupList" :key="item.id" :value="item.id">{{item.title}}</option>
              </select>
              <em>{{ errors[0] }}</em>
            </ValidationProvider>
            <i>请求协议:</i>

            <ValidationProvider rules="required" v-slot="{ errors }" name="请求协议" tag="p">
              <select v-model="apiInfo.protocol_type" v-if="propertyList.http_protocol">
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
    </div>-->
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
      rules: {
        group_id: [{ required: true, message: "请选择分组", trigger: "blur" }],
        protocol_type: [
          { required: true, message: "请选择协议类型", trigger: "blur" }
        ],
        http_method_type: [
          { required: true, message: "请选择分组", trigger: "blur" }
        ],
        http_return_type: [
          { required: true, message: "请选择分组", trigger: "blur" }
        ],

        url: [{ required: true, message: "请输入url", trigger: "blur" }],
        api_name: [
          { required: true, message: "请输入api名称", trigger: "blur" }
        ],
        develop_language: [
          { required: true, message: "请选择开发语言", trigger: "blur" }
        ]
      },
      apiInfo: {
        group_id: this.groupId == 0 ? null : this.groupId, //分组
        project_id: 0, //项目Id
        protocol_type: "", //协议
        http_method_type: "", //http请求方法
        http_return_type: "", //返回值类型
        url: "", //http请求URL
        api_name: "", //接口名称
        object_name: "", //根对象名
        function_name: "", //程序内部方法名
        develop_language: "" //接口开发语言
      },
      show: 0,
      isFirstUpdate: 0
    };
  },
  watch: {
    apiData: function() {
      this.apiInfo = this.apiData;
    },
    // apiInfo: {
    //   handler: function(newdata) {
    //     this.isFirstUpdate++;
    //     //处理更新时第一次
    //     if (
    //       this.isFirstUpdate === 1 ||
    //       this.isFirstUpdate === 2 ||
    //       this.isFirstUpdate === 3
    //     ) {
    //       this.$refs.form.reset();
    //       this.$emit("error", "");
    //       return;
    //     }

    //     this.$refs.form.validate().then(success => {
    //       if (!success) {
    //         this.$emit("error", "信息填写错误");
    //         return;
    //       }

    //       this.$emit("error", "");
    //       this.$emit("update:apiInfo", newdata);
    //       // Wait until the models are updated in the UI
    //       this.$nextTick(() => {
    //         this.$refs.form.reset();
    //       });
    //     });
    //   },
    //   deep: true
    // },
    propertyList: function(val) {
      for (let item in val) {
        switch (item) {
          case "http_method":
            this.apiInfo.http_method_type = val[item][0].tag_name;
            break;

          case "http_protocol":
            this.apiInfo.protocol_type = val[item][0].tag_name;
            break;

          case "http_return":
            this.apiInfo.http_return_type = val[item][0].tag_name;
            break;
          case "api_language":
            this.apiInfo.develop_language = val[item][0].tag_name;
            break;
        }
      }
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
  padding: 20px 10px 0 0;
  position: relative;
  background-color: #fff;
  box-sizing: border-box;
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