import Vue from "vue";
import Vuex from "vuex";
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

//导入个人配置
import conf from "../public/conf.js";

Vue.prototype.apiAddress = conf.apiAddr;
Vue.config.productionTip = false;

Vue.use(VueResource);
Vue.use(Vuex);
Vue.use(mavonEditor);
Vue.use(ElementUI);
Vue.use(VueClipboard);

//从localStorage中获取用户信息
function getUserInfoByLocalStorage() {
  return JSON.parse(localStorage.getItem("userInfo"));
}


const store = new Vuex.Store({
  state: {
    count: 0,
    userInfo: {},
    project: {},
    projectPermission: 4,
  },
  mutations: {
    increment(state) {
      state.count++;
    },
    //用户信息
    saveUserInfo(state, user) {
      state.userInfo = user;
    },
    //项目信息
    saveProject(state, project) {
      state.project = project;
    },
    //用户对项目的操作权限
    saveProjectPermission(state, permission) {
      state.projectPermission = permission;
    },
  },
});

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

router.beforeEach((to, from, next) => {

  let userInfo = getUserInfoByLocalStorage();

  if (
    to.matched.some((record) => record.meta.requiresAuth)
  ) {
    Vue.http.get(Vue.prototype.apiAddress + "/project/get-project-operation-permission").then(
      (response) => {
        response = response.body;
        if (response.code === 200) {
          store.commit("saveProjectPermission", response.data);
        }
      },
      (res) => {
        let response = res.body;
        Vue.$message.error(
          "获取项目权限信息失败!" + !response.msg ? response.msg : ""
        );
      }
    );
  }

  let routerArr = ["userLogin", "register"];
  if (routerArr.indexOf(to.name) === -1 && !userInfo) {
    next("/login");
  }

  next();
});



//实例化Vue
new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
