import Vue from "vue";
import Vuex from "vuex";
import App from "./App.vue";
import router from "./router";
import VueResource from "vue-resource";
import "./validate.js";

Vue.prototype.apiAddress = "http://120.27.241.94:50682";
// Vue.prototype.apiAddress = "http://localhost:1000";
Vue.prototype.globalId = 0;
Vue.prototype.userInfo = null;

Vue.config.productionTip = false;

Vue.use(VueResource);
Vue.use(Vuex);

//扩展指令，设置焦点
Vue.directive("focus", {
  inserted: function(el) {
    el.focus();
  }
});

const store = new Vuex.Store({
  state: {
    count: 0,
    userInfo: {},
    project: {}
  },
  mutations: {
    increment(state) {
      state.count++;
    },
    saveUserInfo(state, user) {
      state.userInfo = user;
    },
    saveProject(state, project) {
      state.project = project;
    }
  }
});

//扩展指令，验证
Vue.directive("validate", {
  update: function(el, binding) {
    el.onblur = function() {
      let testMatch = /^test$/;
      if (testMatch.test(binding.value)) {
        return;
      }
    };
  }
});

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount("#app");

// "alpha": "{_field_}只能包含字母字符",
// "alpha_dash": "{_field_}能够包含字母数字字符、破折号和下划线",
// "alpha_num": "{_field_}只能包含字母数字字符",
// "alpha_spaces": "{_field_}只能包含字母字符和空格",
// "between": "{_field_}必须在{min}与{max}之间",
// "confirmed": "{_field_}不能和{target}匹配",
// "digits": "{_field_}必须是数字，且精确到{length}位数",
// "dimensions": "{_field_}必须在{width}像素与{height}像素之间",
// "email": "{_field_}不是一个有效的邮箱",
// "excluded": "{_field_}不是一个有效值",
// "ext": "{_field_}不是一个有效的文件",
// "image": "{_field_}不是一张有效的图片",
// "oneOf": "{_field_}不是一个有效值",
// "integer": "{_field_}必须是整数",
// "length": "{_field_}长度必须为{length}",
// "max": "{_field_}不能超过{length}个字符",
// "max_value": "{_field_}必须小于或等于{max}",
// "mimes": "{_field_}不是一个有效的文件类型",
// "min": "{_field_}必须至少有{length}个字符",
// "min_value": "{_field_}必须大于或等于{min}",
// "numeric": "{_field_}只能包含数字字符",
// "regex": "{_field_}格式无效",
// "required": "{_field_}是必须的",
// "required_if": "{_field_}是必须的",
// "size": "{_field_}必须小于{size}KB"
