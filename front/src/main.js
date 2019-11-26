import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import VueResource from "vue-resource";

Vue.prototype.apiAddress = "http://120.27.241.94:50682";
Vue.prototype.globalId = 0;
Vue.prototype.userInfo = null;

Vue.config.productionTip = false;

Vue.use(VueResource);

new Vue({
  router: router,
  render: h => h(App)
}).$mount("#app");
