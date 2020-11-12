import Vue from "vue";
import store from './store/main';
import App from "./App.vue";
import router from "./router";
import VueClipboard from "vue2-clipboard";
import axios from 'axios'
import VueAxios from 'vue-axios'


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

Vue.use(VueAxios, axios)
Vue.use(mavonEditor);
Vue.use(ElementUI);
Vue.use(VueClipboard);

//从localStorage中获取用户信息
function getUserInfoByLocalStorage() {
  return JSON.parse(localStorage.getItem("userInfo"));
}

//vue-resource拦截器拦截请求,添加token
Vue.axios.interceptors.request.use( config => {
  let userInfo = getUserInfoByLocalStorage();
  if (userInfo) {
    if (config.method === "get" && config.params) {
      if ( !config.params.token) {
        config.params.token = userInfo.token;
      }

      //附加项目id
      if ( config.params && !config.params.projectId && store.state.project) {
        config.params.projectId = store.state.project.id;
      }
    } else if (config.method === "post" && config.data) {
      if (!config.data.token) {
        config.data.token = userInfo.token;
      }

      //附加项目id
      if (!config.data.projectId && store.state.project) {
        config.data.projectId = store.state.project.id;
      }
    }
  }

  return config;

},error =>{
  return Promise.reject(error);
});


Vue.axios.interceptors.response.use(response => {
    let code = response.data.code;
  if (code === 34) {
    Vue.prototype.$message.error("超时,重新登录");
    localStorage.removeItem("userInfo");
    router.push("/login");
  }

  return response;
}, function (error) {
  return Promise.reject(error);
});



//实例化Vue
new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
