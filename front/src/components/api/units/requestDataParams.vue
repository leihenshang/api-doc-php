<template>
  <div class="request-box">
    <div class="request">
      <div class="item-head">
        <ul>
          <li>
            <button @click="show=0" :class="{'tab-change-btn-bg' : show==0}">请求头部</button>
          </li>
          <li>
            <button @click="show=1" :class="{'tab-change-btn-bg' : show==1}">请求参数</button>
          </li>
          <!-- <li><button>inject</button></li> -->
        </ul>
      </div>
      <table v-show="show==0">
        <tr>
          <th>请求头名</th>
          <th>值</th>
          <th>操作</th>
        </tr>
        <tr v-for="(item,index) in apiParamHeaderItem" :key="item.id">
          <td>
            <input
              type="text"
              placeholder="参数名"
              v-model="item.name"
              v-on:input="apiParamHeaderInput(index,$event)"
            />
          </td>
          <td>
            <input type="text" placeholder="值" v-model="item.content" />
          </td>
          <td>
            <button v-if="item.content.length >= 1" @click="apiParamHeaderDelete(index)">×</button>
          </td>
        </tr>
      </table>

      <!-- 请求参数开始 -->
      <table v-show="show==1">
        <tr>
          <th>参数名</th>
          <th>说明</th>
          <th>必填</th>
          <th>类型</th>
          <th>示例</th>
          <th>操作</th>
        </tr>
        <tr v-for="(item,index) in apiParamItem" :key="item.id">
          <td>
            <input
              type="text"
              placeholder="参数名"
              v-on:input="apiParamInput(index,$event)"
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
            <select
              style="width:90%;text-align:center;margin:0 10px;"
              v-model="item.type"
              v-if="propertyList.var_type"
            >
              <option disabled value>请选择</option>
              <option
                v-for="item in propertyList.var_type"
                :key="item.id"
                :value="item.tag_name"
              >{{item.tag_name}}</option>
            </select>
          </td>
          <td>
            <input type="text" placeholder="参数示例" v-model="item.example" />
          </td>
          <td>
            <div v-show="item.name.length >= 1">
              <button @click="apiParamdelete(index)">×</button>
            </div>
          </td>
        </tr>
      </table>
      <!-- 请求参数结束 -->
    </div>
  </div>
</template>

<script>
export default {
  name: "requestDataParams",
  props: {
    propertyList: [Object, Array],
    header: {
      type: [Array, Object],
      default: function() {
        return [
          {
            name: "",
            content: "",
            handle: true,
            isAdd: false
          }
        ];
      }
    },
    params: {
      type: [Array, Object],
      default: function() {
        return [
          {
            name: "",
            desc: "",
            required: false,
            type: "string",
            example: "",
            handle: true,
            isAdd: false
          }
        ];
      }
    }
  },
  created() {},
  data: function() {
    return {
      show: 1,
      apiParamHeaderItem: [
        {
          name: "",
          content: "",
          handle: true,
          isAdd: false
        }
      ],
      apiParamItem: [
        {
          name: "",
          desc: "",
          required: true,
          type: "string",
          example: "",
          handle: true,
          isAdd: false
        }
      ]
    };
  },
  watch: {
    header: function(val) {
      if (val.length) {
        this.apiParamHeaderItem = JSON.parse(JSON.stringify(val));
        this.apiParamHeaderItem.push({
          name: "",
          content: "",
          handle: true,
          isAdd: false
        });
      }
    },
    params: function(val) {
      if (val.length) {
        this.apiParamItem = JSON.parse(JSON.stringify(val));
        this.apiParamItem.push({
          name: "",
          desc: "",
          required: true,
          type: "string",
          example: "",
          handle: true,
          isAdd: false
        });
      }
    },
    apiParamHeaderItem: function(val) {
      this.$emit("update:header", val.slice(0, val.length - 1));
    },
    apiParamItem: function(val) {
      this.$emit("update:param", val.slice(0, val.length - 1));
    }
  },
  methods: {
    //检测apiParam输入
    apiParamInput(index, event) {
      let txt = event.target.value;
      if (event) {
        if (txt.length >= 1 && this.apiParamItem[index].isAdd === false) {
          this.apiParamItem.push({
            name: "",
            desc: "",
            required: true,
            type: "string",
            example: "",
            handle: true,
            isAdd: false
          });
          this.apiParamItem[index].isAdd = true;
        }
      }
    },
    //检测apiParam header输入
    apiParamHeaderInput(index, event) {
      if (event) {
        let txt = event.target.value;

        if (txt.length >= 1 && this.apiParamHeaderItem[index].isAdd === false) {
          this.apiParamHeaderItem.push({
            name: "",
            content: "",
            handle: true,
            isAdd: false
          });
          this.apiParamHeaderItem[index].isAdd = true;
        }
      }
    },
    //apiParam删除
    apiParamdelete(key) {
      this.apiParamItem.splice(key, 1);
    },
    //apiParamheader删除
    apiParamHeaderDelete(key) {
      this.apiParamHeaderItem.splice(key, 1);
    }
  }
};
</script>

<style scope>
.request {
  margin-top: 10px;
  font-size: 14px;
}

.request ul {
  overflow: hidden;
}

.request ul li {
  float: left;
  list-style: none;
}

.request table {
  width: 100%;
  background-color: #fff;
}

.request header {
  background-color: #fff;
  border-top: 1px solid #ddd;
  border-left: 1px solid #ddd;
  border-right: 1px solid #ddd;
  display: flex;
  justify-content: flex-start;
  align-items: center;
}

.request header button {
  margin-left: 5px;
}

.request table,
.request td,
.request th {
  border: 1px solid #ddd;
  border-collapse: collapse;
}

.request th {
  background-color: #fafafa;
}

.request table tr,
.request header {
  height: 40px;
}

.request input[type="text"] {
  border: none;
  height: 40px;
  width: 100%;
  padding: 0 10px;
  box-sizing: border-box;
  /* outline: none; */
}

.request td {
  text-align: center;
}

.request input[type="checkbox"] {
  width: 80%;
}

/* tab切换按钮颜色 */
.item-head .tab-change-btn-bg {
  background-color: #fff;
}

.request-box button {
  background-color: #efefef;
  border: 1px solid #dddddd;
  width: 90px;
  height: 30px;
  font-size: 12px;
  margin: 0;
  padding: 0;
  outline: none;
  border-left: none;
  border-bottom: none;
}

select {
  padding: 0;
  outline: none;
  border: 1px solid #ddd;
  height: 28px;
  border-radius: 3px;
}
</style>