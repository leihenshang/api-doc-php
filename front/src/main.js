import Vue from "vue";
import Vuex from "vuex";
import App from "./App.vue";
import router from "./router";
import VueResource from "vue-resource";

Vue.prototype.apiAddress = "http://120.27.241.94:50682";
Vue.prototype.globalId = 0;
Vue.prototype.userInfo = null;


Vue.config.productionTip = false;

Vue.use(VueResource);
Vue.use(Vuex);

//扩展指令，设置焦点
Vue.directive('focus', {
  inserted: function (el) {
    el.focus();
  }
});

const store = new Vuex.Store({
  state: {
    count: 0,
    userInfo: {

    }
  },
  mutations: {
    increment(state) {
      state.count++
    },
    saveUserInfo(state,user){
      state.userInfo = user;
    }
  }
})




//扩展指令，验证
Vue.directive('validate', {
  update: function (el, binding) {
    el.onblur = function () {
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
