
<template>
  <div class="group">
    <div class="add-group-werapper" v-show="showAdd">
      <addGroup
        :isShow="showAdd"
        :isAdd="showCreateGroup"
        :isEdit="isEdit"
        :groupData="groupData"
        v-on:closeAddGroup="closeAddGroup()"
        v-on:add-group="addGroup()"
      />
    </div>
    <h4>
      <span>分组</span>
    </h4>
    <ul v-if="groupList">
      <li>
        <a href="javascript:;" @click="clientBtn(null,null)">全部文档</a>
      </li>
      <li v-for="(item,index) in group" :key="item.id" :class="{'li-click' : item.isClick }">
        <a href="javascript:;" @click="clientBtn(item.id,index)">{{item.title}}</a>
        <div class="btn-group">
          <button @click="del(item.id)">删除</button>
          <button @click="editGroup(item)">编辑</button>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import addGroup from "./addGroup";

const CODE_OK = 200;
export default {
  name: "group",
  props: {
    id: String,
    groupList: Array,
    showCreateGroup: Boolean,
    showIsEdit: Boolean
  },
  created() {},
  data() {
    return {
      newGroup: "",
      group: [],
      showAdd: false,
      groupData: {},
      isEdit: false
    };
  },
  methods: {
    //删除分组
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
            id: id,
            token: this.$store.state.userInfo.token
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
    },
    //点击分组
    clientBtn(id, index) {
      for (const key in this.group) {
        this.group[key].isClick = false;
      }
      if (index !== null) {
        this.group[index].isClick = true;
      }

      this.$emit("change-group", id);
    },
    editGroup(data) {
      this.groupData = data;
      this.showAdd = !this.showAdd;
      this.isEdit = true;
    },
    closeAddGroup() {
      this.showAdd = !this.showAdd;
      this.$emit("close-add-group", this.showAdd);
    },
    addGroup() {
      this.$emit("add-group");
    }
  },
  watch: {
    groupList: function(val) {
      this.group = val;
    },
    showCreateGroup: function(val) {
      this.showAdd = val;
    }
  },
  components: {
    addGroup
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.li-click {
  background-color: rgba(128, 0, 128, 0.39);
}

.li-click a {
  color: #fff !important;
}

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
  padding: 5px 0 0 15px;
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
  display: flex;
  margin: 10px 0;
  height: 32px;
  line-height: 32px;
}

.group ul li:first-child {
  border-bottom: 1px solid rgb(228, 219, 219);
}

.group ul li:hover {
  background-color: #e3f1e5;
}
.group ul li:hover button {
  display: inline-block;
}

.btn-group {
  overflow: hidden;
  width: 120px;
  line-height: 32px;
  text-align: center;
}

.group ul li a {
  display: inline-block;
  width: 100%;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
  font-size: 14px;
  height: 28px;
  color: rgb(75, 74, 74);
  margin-left: 8px;
  padding-left: 10px;
  height: 100%;
}
</style>
