<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="group">
    <h4>
      <span>分组</span>
    </h4>
    <ul v-if="groupList">
      <p>
        <input type="text" v-model="newGroup" />
        <button @click="createGroup">新增</button>
      </p>
      <li v-for="item in group" :key="item.id">
        <a href="javascript:void();">{{item.title}}</a>
        <div class="btn-group">
          <button @click="del(item.id)">删除</button>
          <button>编辑</button>
        </div>
      </li>
    </ul>
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
            title: this.newGroup,
            project_id: this.$route.params.id
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
      if (!confirm("确定删除?")) {
        return;
      }

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
.group {
  width: 100%;
  height: 100%;
  box-sizing: border-box;
  padding: 2px;
  background-color: #fff;
  overflow-y: auto;
}

.group h4 {
  font-size: 14px;
}

.group ul p {
padding-left:8px;
  margin: 10px 0 15px;
}

.group ul p input {
  height: 26px;
  border-radius: 3px;
  margin-right: 5px;
  outline: none;
  border: 1px solid #d3d1d1;
}

.group ul p button {
  height: 28px;
  padding: 0 10px;
  margin-right: 2px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  border-radius: 3px;
  font-size: 12px;
}

.group ul li button {
  height: 26px;
  padding: 0 5px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  border-radius: 3px;
  font-size: 12px;
  display: none;
}

/* .group ul li button:hover {
  background-color: gray;
  color: #fff;
} */

.group ul li {
  width: 100%;
  overflow: hidden;
  margin: 10px 0;
  height: 32px;
  line-height: 32px;
}

.group ul li:hover {
  background-color: #e3f1e5;
}

.group ul li:hover button {
  display: inline-block;
}

.btn-group {
  float: right;
  overflow: hidden;
  line-height: 28px;
}

.group ul li a {
  display: inline-block;
  width: 120px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  font-size: 14px;
  height: 28px;
  color: rgb(75, 74, 74);
  margin-left: 8px;
}
</style>
