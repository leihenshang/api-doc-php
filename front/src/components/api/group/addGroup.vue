<template>
  <div class="add-group">
    <div class="add-group-box">
      <!-- <p v-show="!isEdit">
        <input type="text" v-model="newGroup" />
        <button @click="createGroup">新增</button>
      </p> -->
      <p >
        <input type="text" v-model="groupData.title" />
        <button @click="editGroup()">保存</button>
        <!-- <button style="background-color:red;color:white;font-weight:700;">删除</button> -->
          <button style="background-color:black;color:white;font-weight:700;" @click="closeMe()" >取消</button>
      </p>
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "add-group",
  props: {
    groupData: Object,
    isShow: Boolean
  },
  created() {},
  data() {
    return {
      newGroup: "",
      group: [],
      btnChange: false,
      isEdit: false
    };
  },
  methods: {
    createGroup() {},
    editGroup(){
    if (this.groupData.title.length < 1) {
        alert("组名长度不能低于1个");
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/group/update",
          {
            title: this.groupData.title,
            id: this.groupData.id
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              alert("成功！~");
              this.$emit('closeAddGroup');
            } else {
              alert("修改失败:" + response.msg);
            }
          },
          function(res) {
            let response = res.body;
            alert("获操作失败!" + !response.msg ? response.msg : "");
          }
        );
    }
    ,
    closeMe(){
      this.$emit('closeAddGroup');
    }
  },
  watch: {
    groupData:function(){
      if(this.groupData){
        this.isEdit = !this.isEdit;
      }
    }
  }
};
</script>

<style scoped>
.add-group-box {
  border: 1px solid black;
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
  height: 26px;
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
