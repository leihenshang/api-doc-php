import Vue from "vue";
import Vuex from "vuex";
import App from "./App.vue";
import router from "./router";
import VueResource from "vue-resource";


//markdown组件
import mavonEditor from "mavon-editor";
import "mavon-editor/dist/css/index.css";

//element ui
import ElementUI from "element-ui";
import "element-ui/lib/theme-chalk/index.css";

// Vue.prototype.apiAddress = "http://120.27.241.94:50682";
Vue.prototype.apiAddress = "http://localhost:1000";
Vue.prototype.userInfo = null;

Vue.config.productionTip = false;

Vue.use(VueResource);
Vue.use(Vuex);
Vue.use(mavonEditor);
Vue.use(ElementUI);

//扩展指令，设置焦点
Vue.directive("focus", {
  inserted: function(el) {
    el.focus();
  },
});

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
  if (request.method === "GET") {
    if (!request.params.token) {
      request.params.token = store.state.userInfo.token;
    }
    //附加项目id
    if (!request.params.projectId && store.state.project) {
      request.params.projectId = store.state.project.id;
    }
  } else if (request.method === "POST") {
    if (!request.body.token) {
      request.body.token = store.state.userInfo.token;
    }
    //附加项目id
    if (!request.body.projectId && store.state.project) {
      request.body.projectId = store.state.project.id;
    }


    if (request.emulateJSON !== true) {
      request.emulateJSON = true;
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

//http请求前置操作
router.beforeEach((to, from, next) => {
  if (
    to.matched.some((record) => record.meta.requiresAuth) &&
    Vue.prototype.userInfo
  ) {
    Vue.http
      .get(
        Vue.prototype.apiAddress + "/project/get-project-operation-permission",
        {
          params: {
            token: Vue.prototype.userInfo.token,
            projectId: 22,
          },
        }
      )
      .then(
        (response) => {
          response = response.body;
          if (response.code === 200) {
            store.commit("saveProjectPermission", response.data);
          }
        },
        (res) => {
          let response = res.body;
          Vue.$message.error(
            "获取项目信息-操作失败!" + !response.msg ? response.msg : ""
          );
        }
      );
  }

  if (to.name !== "register") {
    let routerArr = ["userLogin", "register"];
    if (routerArr.indexOf(to.name) === 0) {
      next();
    } else {
      if (!Vue.prototype.userInfo) {
        next("/login");
      } else {
        next();
      }
    }
  } else {
    next();
  }
});

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
