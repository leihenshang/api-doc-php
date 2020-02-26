<template>
  <div class="return-params">
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
        <tr v-for="(item,index) in returnDataItem" :key="item.id">
          <td>
            <input
              type="text"
              placeholder="字段名"
              v-model="item.fieldName"
              v-on:input="dataInput(index,$event)"
            />
          </td>
          <td>
            <input type="text" placeholder v-model="item.objectName" />
          </td>
          <td>
            <input type="text" placeholder="参数名" v-model="item.description" />
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
            <div v-show="item.fieldName.length >= 1">
              <button @click="dataDelete(index)">×</button>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: "returnDataParams",
  props: {
    propertyList: [Object, Array]
  },
  data: function() {
    return {
      returnDataItem: [
        {
          fieldName: "",
          objectName: "",
          description: "",
          required: false,
          type: "string",
          handle: true,
          isAdd: false
        }
      ]
    };
  },
  methods: {
    //检查box4输入
    dataInput(index, event) {
      if (event) {
        let txt = event.target.value;
        if (txt.length >= 1 && this.returnDataItem[index].isAdd === false) {
          this.returnDataItem.push({
            fieldName: "",
            objectName: "",
            description: "",
            required: false,
            type: "string",
            handle: true,
            isAdd: false
          });
          this.returnDataItem[index].isAdd = true;
        }
      }
    },
    //box4删除
    dataDelete(key) {
      this.returnDataItem.splice(key, 1);
    }
  },
  watch: {}
};
</script>

<style scoped>
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

select {
  padding: 0;
  outline: none;
  border: 1px solid #ddd;
  height: 28px;
  border-radius: 3px;
}
</style>