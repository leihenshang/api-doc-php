<template>
  <div class="add" v-bind:class="{hide : isHide}">
    <h4>添加项目</h4>
    <ul>
      <li>
        <span>项目名称</span>
        <input type="text" v-model.trim="title" />
      </li>
      <li>
        <span>版本号</span>
        <input type="text" v-model.trim="ver" />
      </li>
      <li>
        <span>项目类型</span>
        <select name="1" id="2" v-model.number="type">
          <option value="1">web</option>
          <option value="2">pc</option>
        </select>
      </li>
      <li>
        <span>项目描述</span>
        <textarea name="desc" cols="50" rows="10" v-model.trim="desc"></textarea>
      </li>
      <li>
        <button @click="create">确定</button>
        <button @click="hideMeBtn">取消</button>
      </li>
    </ul>
  </div>
</template>

<script>
const CODE_OK = 200;

export default {
  name: "add",
  props: {
    msg: String,
    isShow: Boolean
  },
  data() {
    return {
      isHide: this.isShow,
      title: "",
      ver: "",
      type: 1,
      desc: ""
    };
  },
  methods: {
    hideMeBtn(type) {
      this.isHide = !this.isHide;
      this.clear();
      this.$emit("hide-box", type);
    },
    create() {
      //发送 post 请求
      this.$http
        .post(
          this.apiAddress + "/project/create",
          {
            title: this.title,
            description: this.desc,
            version: this.ver,
            type: this.type
          },
          { emulateJSON: true }
        )
        .then(
          function(res) {
            let response = res.body;
            if (response.code === CODE_OK) {
              alert("成功!" + response.msg);
              this.clear();
              this.hideMeBtn("flush");
            } else {
              alert("失败!" +response.msg);
            }
          },
          function(res) {
             let response = res.body;
            alert("操作失败!"+ response.msg);
          }
        );
    },
    clear() {
      this.title = "";
      this.ver = "";
      this.type = 1;
      this.desc = "";
    }
  },
  watch: {
    isShow: function(val) {
      this.isHide = val;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.add {
  width: 500px;
  height: 400px;
  position: absolute;
  background-color: #fff;
  top: 50%;
  left: 50%;
  border: 1px solid black;
  transform: translate(-50%, 50%);
}

.hide {
  display: none;
}
</style>
