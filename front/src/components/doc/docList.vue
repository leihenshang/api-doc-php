<template>
  <div class="doc-list common-table">
    <table v-show="!hideMe">
      <tr>
        <th>名称</th>
        <th>创建者</th>
        <th>创建时间</th>
        <th>操作</th>
      </tr>
      <tr v-for="item in docList" :key="item.id">
        <td>
          <span class="span-dot"></span>
          {{item.title}}
        </td>
        <td>{{item.user_id}}</td>
        <td>{{item.create_time}}</td>
        <td class="doc-list-btn">
          <button @click="jumpPage('docEdit',item.id)">编辑</button>
          <button @click="jumpPage('docDetail',item.id)">详情</button>
          <button @click="delDoc(item.id)">删除</button>
        </td>
      </tr>
    </table>

    <div class="container" v-show="hideMe">
      <div class="container-btn">
        <button @click="hideMe = !hideMe">返回</button>
      </div>
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "docList",
  props: {
    id: String,
    docList: Array
  },
  created() {},
  data() {
    return {
      hideMe: false
    };
  },
  methods: {
    delDoc(id) {
      if (!confirm("确认删除?")) {
        return;
      }

      this.$http
        .post(this.apiAddress + "/doc/delete", {
          id: id
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              alert("成功！~");
              this.$emit("doc-delete");
            }
          },
          res => {
            let response = res.body;
            alert("操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    jumpPage(name, docId) {
      this.hideMe = true;
      this.$router.push({ name, params: { docId: docId } });
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

.container button {
  height: 30px;
  width: 120px;
}

.container-btn {
  width: 75%;
  margin: 0 auto;
  text-align: right;
}
</style>
