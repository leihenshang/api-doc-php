<template>
  <div class="add-panel">
    <div class="add" v-bind:class="{hide : isHide}">
      <h4>添加项目</h4>
      <ValidationObserver ref="form" vid="form">
        <ul>
          <li>
            <em>项目名称</em>
            <validation-provider rules="required" v-slot="{ errors }" vid="title">
              <input type="text" v-model.trim="title" name="title" v-focus />
              <span>{{ errors[0] }}</span>
            </validation-provider>
          </li>
          <li>
            <em>版本号</em>
            <validation-provider rules="required" v-slot="{ errors }" vid="version">
              <input type="text" v-model.trim="ver" />
              <span>{{ errors[0] }}</span>
            </validation-provider>
          </li>
          <li>
            <em>项目类型</em>
            <validation-provider rules="required" v-slot="{ errors }" vid="type">
              <select v-model="type">
                <option></option>
                <option value="web">web</option>
                <option value="pc">pc</option>
              </select>
              <span>{{ errors[0] }}</span>
            </validation-provider>
          </li>
          <li>
            <textarea name="desc" v-model.trim="desc" placeholder="输入描述"></textarea>
          </li>
        </ul>
      </ValidationObserver>
      <div class="add-btn">
        <button @click=" updateData !== null ? update() : create()">确定</button>
        <button @click="hideMeBtn">取消</button>
      </div>
    </div>
    <div class="shade" v-bind:class="{hide : isHide}"></div>
  </div>
</template>

<script>
import { ValidationProvider, extend, ValidationObserver } from "vee-validate";
import { required } from "vee-validate/dist/rules";

extend("required", {
  ...required,
  message: "This field is required",
  computesRequired: true
});

const CODE_OK = 200;

export default {
  name: "add",
  props: {
    msg: String,
    isShow: Boolean,
    updateData: null
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
      console.log(this.$refs.form.errors);

      this.$refs.form.validate().then(res => {
        if (!res) {
          return;
        }
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
                alert("失败!" + response.msg);
              }
            },
            function(res) {
              let response = res.body;
              alert("操作失败!" + response.msg);
            }
          );
      });
    },
    update() {
      this.$http
        .post(
          this.apiAddress + "/project/update",
          {
            id: this.updateData.id,
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
              alert("失败!" + response.msg);
            }
          },
          function(res) {
            let response = res.body;
            alert("操作失败!" + response.msg);
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
    },
    updateData: function(val) {
      this.title = val.title;
      this.ver = val.version;
      this.type = val.type;
      this.desc = val.description;
    }
  },
  components: {
    ValidationProvider,
    ValidationObserver
  }
};
</script>

<style scoped>
.add {
  width: 700px;
  height: auto;
  position: absolute;
  background-color: #fff;
  top: 50%;
  left: 50%;
  border: 1px solid rgb(207, 207, 207);
  transform: translate(-50%, -50%);
  padding: 40px 25px;
  box-sizing: border-box;
  z-index: 2;
  border-radius: 8px;
  overflow: hidden;
}

.add ul em {
  display: inline-block;
  min-width: 80px;
  font-size: 14px;
  text-align: right;
  padding-right: 10px;
  box-sizing: border-box;
  font-style: normal;
}

.add ul span {
  color: red;
}

.add h4 {
  text-align: center;
}

.add ul li {
  margin: 20px 0;
}

.add ul li textarea {
  width: 100%;
  min-height: 120px;
  padding: 6px;
  box-sizing: border-box;
}

.add ul li input {
  padding: 6px;
  box-sizing: border-box;
  height: 24px;
  width: 60%;
}

.add ul li select {
  height: 24px;
  width: 20%;
}

.hide {
  display: none;
}

.add-btn button {
  padding: 4px 14px;
  margin-right: 10px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  border-radius: 3px;
}

.shade {
  width: 100%;
  height: 100%;
  z-index: 1;
  position: absolute;
  top: 0;
  left: 0;
  background-color: rgba(1, 1, 1, 0.2);
}
</style>
