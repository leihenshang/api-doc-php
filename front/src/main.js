import Vue from "vue";
import Vuex from "vuex";
import App from "./App.vue";
import router from "./router";
import VueResource from "vue-resource";
import "./validate";


//markdown组件
import mavonEditor from 'mavon-editor';
import 'mavon-editor/dist/css/index.css';




// Vue.prototype.apiAddress = "http://120.27.241.94:50682";
Vue.prototype.apiAddress = "http://localhost:1000";
Vue.prototype.globalId = 0;
Vue.prototype.userInfo = null;

Vue.config.productionTip = false;

Vue.use(VueResource);
Vue.use(Vuex);
Vue.use(mavonEditor);

//扩展指令，设置焦点
Vue.directive("focus", {
    inserted: function (el) {
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


//拦截器拦截请求,添加token
Vue.http.interceptors.push(request => {
    if (request.method === "GET") {
        if (!request.params.token) {
            request.params.token = store.state.userInfo.token;
        }
    } else if (request.method === "POST") {
        if (!request.body.token) {
            request.body.token = store.state.userInfo.token;
        }
        if (request.emulateJSON !== true) {
            request.emulateJSON = true;
        }
    }
    return response => {
        if (response.body.code && response.body.code === 34) {
            alert("超时,重新登录");
            localStorage.removeItem("userInfo");
            router.push("/login");
        }
    };
});

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount("#app");
