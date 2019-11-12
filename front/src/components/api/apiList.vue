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
        <th>最近更新者</th>
        <th>作者</th>
        <th>更新时间</th>
        <th>动作</th>
      </tr>
      <tr v-for="item in apiList" :key="item.id">
        <td>{{item.id}}</td>
        <td>{{item.data.requestMethod}}</td>
        <td>{{item.data.url}}</td>
        <td>{{item.id}}</td>
        <td>{{item.id}}</td>
        <td>{{item.update_time}}</td>
        <td>
          <button @click="jumpPage('apiEdit',item.id)">编辑</button>
          <button @click="jumpPage('apiDetail',item.id)">详情</button>
          <button @click="delApi(item.id)">删除</button>
        </td>
      </tr>
    </table>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "apiList",
  props: {
    id: String
  },
  created() {
    this.getApi(1, 100);
  },
  data() {
    return {
      apiList: []
    };
  },
  methods: {
    delApi(id) {
      this.$http
        .post(
          this.apiAddress + "/api/del",
          {
            id: id
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              alert("成功！~");
              this.getApi();
            }
          },
          function(res) {
            let response = res.body;
            alert("操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    getApi(curr, pageSize) {
      this.$http
        .get(this.apiAddress + "/api/list", {
          params: { cp: curr, ps: pageSize }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.apiList = response.data;
              if (this.apiList) {
                for (let index = 0; index < this.apiList.length; index++) {
                  // this.apiList[index].data = JSON.parse(this.api[index].data);
                }
              }
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    jumpPage(name, id) {
      this.$router.push(
        "/detail/" + this.$route.params.id + "/" + name + "/" + id
      );
    }
  }
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
