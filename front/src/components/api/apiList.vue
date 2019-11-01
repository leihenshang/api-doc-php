<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="apiList">
    我是apiList组件
    <table>
      <tr>
        <th>名称</th>
        <th>请求方法</th>
        <th>url</th>
        <th>动作</th>
      </tr>
      <tr v-for="item in apiList" :key="item.id">
        <td>{{item.id}}</td>
        <td>{{item.id}}</td>
        <td>{{item.id}}</td>
        <td>
          <button>编辑</button>
          <button>详情</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
// const CODE_OK = 200;
export default {
  name: "apiList",
  props: {
    id: String,
    apiList: Array
  },
  created() {},
  data() {
    return {};
  },
  methods: {}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
table,
td,
th {
  border: 1px solid black;
}

table {
  border-collapse: collapse;
}
</style>
