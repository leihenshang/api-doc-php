<template>
  <div class="text-box">
    <div class="box5">
      <div class="res-btn">
        <div class="btn-wrap">
          <button @click="toggle=0" :class="{'tab-change-btn-bg' : toggle==0}">成功</button>
          <button @click="toggle=1" :class="{'tab-change-btn-bg' : toggle==1}">失败</button>
        </div>
      </div>
      <textarea name id v-model="success" v-show="toggle==0" placeholder="成功的返回"></textarea>
      <textarea name id v-model="failed" v-show="toggle==1" placeholder="失败的返回"></textarea>
    </div>
  </div>
</template>

<script>
export default {
  name: "returnDataTextBox",
  props: {},
  data() {
    return {
      toggle: 0,
      success: "",
      failed: ""
    };
  },
  watch: {
    success: function(val) {
      this.$emit("update:success", val);
    },
    failed: function(val) {
      this.$emit("update:failed", val);
    }
  }
};
</script>

<style scope>
.box5 {
  margin-top: 10px;
}

.box5 button {
  background-color: #efefef;
  border: 1px solid #dddddd;
  width: 90px;
  height: 30px;
  font-size: 12px;
  margin: 0;
  padding: 0;
  outline: none;
}

.box5 textarea {
  width: 100%;
  min-height: 200px;
  outline: none;
  border: 1px solid #ddd;
  padding: 5px;
  resize: none;
  box-sizing: border-box;
}

.box5 .res-btn {
  position: relative;
  height: 30px;
}

.box5 .res-btn button {
  border-bottom: none;
  border-radius: 3px;
  height: 30px;
}

.box5 .res-btn button:nth-child(1) {
  border-right: none;
}

/* tab切换按钮颜色 */
.box5 .tab-change-btn-bg {
  background-color: #fff;
}
</style>