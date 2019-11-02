<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="group">
    我是分组组件
    <div class="box">
      <ul v-if="groupList">
        <p>
          <input type="text" v-model="newGroup" />
          <button @click="createGroup">新增</button>
        </p>
        <li v-for="item in group" :key="item.id">
          <a href="javascript:void();">{{item.title}}</a>
          <button @click="del(item.id)">删除</button>
          <button>编辑</button>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "group",
  props: {
    id: String,
    groupList: Array
  },
  created() {},
  data() {
    return {
      newGroup: "",
      group: []
    };
  },
  methods: {
    createGroup() {
      if (this.newGroup.length < 1) {
        alert("组名长度不能低于1个");
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/group/create",
          {
            title: this.newGroup
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.$emit("add-group");
              this.newGroup = "";
              alert("成功！~");
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    del(id) {
      if (!id) {
        alert("id错误");
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/group/del",
          {
            id: id
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.$emit("add-group");
              alert("成功！~");
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    }
  },
  watch: {
    groupList: function(val) {
      this.group = val;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
