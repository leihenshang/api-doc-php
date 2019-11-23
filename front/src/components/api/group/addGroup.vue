<template>
  <div class="add-group">
    <div class="add-group-box">
      <p v-show="isAdd">
        <input type="text" v-model="newGroup" />
        <button @click="createGroup">新增</button>
      </p>
            <p v-show="isEdit">
        <input type="text" v-model="newGroup" />
        <button>修改</button>
        <button style="background-color:red;color:white;font-weight:700;">删除</button>
      </p>
    </div>
  </div>
</template>

<script>
// const CODE_OK = 200;
export default {
  name: "add-group",
  props: {},
  created() {},
  data() {
    return {
      newGroup: "",
      group: [],
      isAdd:true,
      isEdit:false
    };
  },
  methods: {
    createGroup() {}
  },
  watch: {}
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
