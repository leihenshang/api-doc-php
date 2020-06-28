import Vue from "vue";
import store from './store/main';
import App from "./App.vue";
import router from "./router";
import VueResource from "vue-resource";
import VueClipboard from "vue2-clipboard";

//markdown组件
import mavonEditor from "mavon-editor";
import "mavon-editor/dist/css/index.css";

//element ui
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";

//导入配置
import conf from "../public/conf.js";

Vue.prototype.apiAddress = conf.apiAddr;
Vue.config.productionTip = false;

Vue.use(VueResource);
Vue.use(mavonEditor);
Vue.use(ElementUI);
Vue.use(VueClipboard);

//从localStorage中获取用户信息
function getUserInfoByLocalStorage() {
  return JSON.parse(localStorage.getItem("userInfo"));
}


//vue-resource拦截器拦截请求,添加token
Vue.http.interceptors.push((request) => {
  let userInfo = getUserInfoByLocalStorage();

  if (userInfo) {
    if (request.method === "GET") {
      if (!request.params.token) {
        request.params.token = userInfo.token;
      }

      //附加项目id
      if (!request.params.projectId && store.state.project) {
        request.params.projectId = store.state.project.id;
      }
    } else if (request.method === "POST") {
      if (!request.body.token) {
        request.body.token = userInfo.token;
      }

      //附加项目id
      if (!request.body.projectId && store.state.project) {
        request.body.projectId = store.state.project.id;
      }


      if (request.emulateJSON !== true) {
        request.emulateJSON = true;
      }
    }
  }

  return (response) => {
    if (response.body.code && response.body.code === 34) {
      Vue.prototype.$message.error("超时,重新登录");
      localStorage.removeItem("userInfo");
      router.push("/login");
    }
  };
});



//实例化Vue
new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
