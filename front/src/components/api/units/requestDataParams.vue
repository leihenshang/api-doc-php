<template>
  <div class="request-box">
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
        <tr>
          <th>请求头名</th>
          <th>值</th>
          <th>操作</th>
        </tr>
        <tr v-for="(item,index) in box3HeaderItem" :key="item.id">
          <td>
            <input
              type="text"
              placeholder="参数名"
              v-model="item.name"
              v-on:input="box3HeaderInput(index,$event)"
            />
          </td>
          <td>
            <input type="text" placeholder="值" v-model="item.content" />
          </td>
          <td>
            <button @click="box3HeaderDelete(index)">×</button>
          </td>
        </tr>
      </table>

      <!-- 请求参数开始 -->
      <table v-show="box3==1">
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
              <button @click="box3delete(index)">×</button>
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
    propertyList: [Object, Array]
  },
  created() {},
  data: function() {
    return {
      box3: 1,
      box3HeaderItem: [
        {
          name: "",
          content: "",
          handle: true,
          isAdd: false
        }
      ],
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
      ]
    };
  },
  watch: {},
  methods: {
    //检测box3输入
    box3Input(index, event) {
      if (event) {
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
    //检测box3 header输入
    box3HeaderInput(index, event) {
      if (event) {
        let txt = event.target.value;
        if (txt.length >= 1 && this.box3HeaderItem[index].isAdd === false) {
          this.box3HeaderItem.push({
            name: "",
            content: "",
            handle: true,
            isAdd: false
          });
          this.box3HeaderItem[index].isAdd = true;
        }
      }
    },

    //box3删除
    box3delete(key) {
      this.box3Item.splice(key, 1);
    },
    //box3header删除
    box3HeaderDelete(key) {
      this.box3HeaderItem.splice(key, 1);
    }
  }
};
</script>

<style scope>
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

/* tab切换按钮颜色 */
.tab-change-btn-bg {
  background-color: #fff;
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

select {
  padding: 0;
  outline: none;
  border: 1px solid #ddd;
  height: 28px;
  border-radius: 3px;
}
</style>