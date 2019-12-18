<template>
  <div class="add-group">
    <div class="add-group-box">
      <div v-if="isEdit">
        <p>
          <input type="text" v-model="editGroupData.title" />
          <button @click="editGroup()">保存</button>
          <button style="background-color:black;color:white;font-weight:700;" @click="closeMe()">取消</button>
        </p>
        <p style="margin:20px;">
          <button style="background-color:red;color:white;font-weight:700;">删除分组</button>
        </p>
      </div>
      <div v-else>
        <p>
          <input type="text" v-model="newGroup" />
          <button @click="createGroup">新增</button>
          <button style="background-color:black;color:white;font-weight:700;" @click="closeMe()">取消</button>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "add-group",
  props: {
    groupData: Object,
    isShow: Boolean,
    showIsEdit: Boolean,
    isAdd:Boolean
  },
  created() {},
  data() {
    return {
      newGroup: "",
      editGroupData: {},
      group: [],
      btnChange: false,
      isEdit: false
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
            project_id: this.$route.params.id,
            token: this.$store.state.userInfo.token
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
                 this.$emit("closeAddGroup");
            } else {
              alert("创建分组失败:" + response.msg);
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    editGroup() {
      if (this.groupData.title.length < 1) {
        alert("组名长度不能低于1个");
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/group/update",
          {
            title: this.groupData.title,
            id: this.groupData.id,
            token: this.$store.state.userInfo.token
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              alert("成功！~");
              this.$emit("closeAddGroup");
            } else {
              alert("修改失败:" + response.msg);
            }
          },
          function(res) {
            let response = res.body;
            alert("获操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    closeMe() {
      this.$emit("closeAddGroup");
      // this.editGroupData = {};
      this.newGroup = "";
    }
  },
  watch: {
    groupData: function() {
      if (this.groupData) {
        this.editGroupData = this.groupData;
        this.isEdit = true;
      }
    },
    showIsEdit: function() {
      this.isEdit = this.showIsEdit;
    },
    isAdd: function() {
      this.isEdit = !this.isAdd;
    }
  }
};
</script>

<style scoped>
.add-group-box {
  border: 1px solid rgb(175, 172, 172);
  width: 600px;
  height: 300px;
  text-align: center;
  position: absolute;
  background-color: #fff;
  z-index: 3;
  left: 50%;
  top: 50%;
  border-radius: 10px;
  transform: translate(-50%, -50%);
  display: flex;
  align-items: center;
  justify-content: center;
}

.add-group-box input {
  padding-left: 5px;
  height: 26px;
  width: 300px;
  border-radius: 3px;
  margin-right: 5px;
  outline: none;
  border: 1px solid #d3d1d1;
}

.add-group-box button {
  height: 28px;
  padding: 0 10px;
  margin-right: 2px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  border-radius: 3px;
  font-size: 12px;
}
</style>
