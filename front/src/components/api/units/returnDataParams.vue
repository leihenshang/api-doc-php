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
              <button @click="box4delete(index)">×</button>
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
  props: {},
  data() {
    return {
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
      ]
    };
  },
  watch: {}
};
</script>

<style scope>
</style>