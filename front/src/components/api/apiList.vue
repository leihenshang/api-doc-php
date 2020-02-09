<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="api-list">
    <table>
      <tr>
        <th>名称</th>
        <th>请求方法</th>
        <th>url</th>
        <th>协议</th>
        <th>语言</th>
        <th>创建时间</th>
        <th>操作</th>
      </tr>
      <tr v-for="item in apiList.resItem" :key="item.id">
        <td>
          <span class="span-dot"></span>
          {{item.api_name}}
        </td>
        <td>{{item.http_method_type}}</td>
        <td>{{item.url}}</td>
        <td>{{item.protocol_type}}</td>
        <td>{{item.develop_language}}</td>
        <td>{{item.create_time}}</td>
        <td class="api-list-btn">
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
    id: String,
    apiList: Object
  },
  created() {},
  data() {
    return {};
  },
  methods: {
    delApi(id) {
      if (!confirm("确认删除?")) {
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/api/del",
          {
            id: id,
            token: this.$store.state.userInfo.token
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              alert("成功！~");
              this.$emit("api-delete");
            }
          },
         res =>  {
            let response = res.body;
            alert("操作失败!" + !response.msg ? response.msg : "");
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

<style scoped>
/* .api-list table,
.api-list td,
.api-list th {
  border: 1px solid #e5e5e5;
} */

.api-list {
  background-color: #fff;
  height: auto;
}

.api-list td,
.api-list th {
  padding: 8px 8px;
  font-size: 12px;
  font-weight: 700;
  color: #666;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.api-list tr:hover {
  background-color: #e3f1e5;
}

.api-list th {
  font-size: 14px;
  font-weight: 700;
  text-align: left;
}

.api-list table {
  border-collapse: collapse;
  width: 100%;
}

.api-list table button {
  height: 28px;
  padding: 0 10px;
  margin-right: 2px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  border-radius: 3px;
  font-size: 12px;
}

.span-dot {
  width: 10px;
  height: 10px;
  display: inline-block;
  border-radius: 10px;
  background-color: #4caf50;
  margin-right: 5px;
}
</style>
