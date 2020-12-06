import Vue from "vue";
import VueRouter from "vue-router";

//项目相关
import ProjectList from "./components/project/projectList";

//api相关操作
import apiCreate from "./components/api/apiCreate";
import ApiList from "./components/api/apiList";
import ApiDetail from "./components/api/apiDetail";
import ApiEdit from "./components/api/apiEdit";

//文档相关操作
import DocPage from "./components/doc/docPage";
import DocCreate from "./components/doc/docCreate";
import DocEdit from "./components/doc/docEdit";
import DocDetail from "./components/doc/docDetail";
import DocList from "./components/doc/docList";

//用户相关操作
import MyCenter from "./page/user/myCenter";
import UserManager from "./page/user/userManager";

import store from "./store/main";

const originalPush = VueRouter.prototype.push
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => err)
}

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    { path: "/register", component: resolve => require(['./page/user/register'], resolve), name: "register" },
    { path: "/login", name: "userLogin", component: resolve => require(['./page/user/login'], resolve) },
    {
      path: "/detail/:id",
      component: resolve => require(['./page/project/project'], resolve),
      props: true,
      children: [

        {
          path: "",
          name: "detailPage",
          component: resolve => require(['./components/project/detailPage'], resolve),
          meta: { requiresAuth: true },
          props: true,
        },
        {
          path: "bugHome",
          name: "bugHome",
          component: resolve => require(['./components/bug/home'], resolve),
          meta: { requiresAuth: true },
          props: true,
        },
        {
          path: "fieldMapping",
          name: "fieldMapping",
          component: resolve => require(['./components/project/fieldMapping'], resolve),
          meta: { requiresAuth: true },
          props: true,
        },
        {
          path: "apiPage",
          name: "apiPage",
          component:resolve => require(["./components/api/apiPage"], resolve) ,
          meta: { requiresAuth: true },
          redirect: "apiPage/apiList/0",
          props: true,
          children: [
            {
              path: "apiCreate/:groupId",
              name: "apiCreate",
              component: apiCreate,
              meta: { requiresAuth: true },
              props: true,
            },
            {
              path: "apiList/:groupId",
              name: "apiList",
              component: ApiList,
              meta: { requiresAuth: true },
              props: true,
            },
            {
              path: "apiEdit/:apiId",
              name: "apiEdit",
              component: ApiEdit,
              meta: { requiresAuth: true },
              props: true,
            },
            {
              path: "apiDetail/:apiId",
              name: "apiDetail",
              component: ApiDetail,
              meta: { requiresAuth: true },
              props: true,
            },
          ],
        },
        {
          path: "projectDoc",
          name: "projectDoc",
          component: DocPage,
          props: true,
          redirect: "projectDoc/docList/0",
          children: [
            {
              path: "docList/:groupId",
              name: "docList",
              component: DocList,
              props: true,
              meta: { requiresAuth: true },
            },
            {
              path: "docDetail/:docId",
              name: "docDetail",
              component: DocDetail,
              props: true,
              meta: { requiresAuth: true },
            },
            {
              path: "docEdit/:docId",
              name: "docEdit",
              component: DocEdit,
              props: true,
              meta: { requiresAuth: true },
            },
            {
              path: "docCreate",
              name: "docCreate",
              component: DocCreate,
              props: true,
              meta: { requiresAuth: true },
            },
          ],
        },
      ],
    },
    {
      path: "/projectList",
      component: ProjectList,
      name: "projectList"
    },
    {
      path: "/userManager",
      component: UserManager,
      name: "userManager"
    },
    {
      path: "/myCenter",
      component: MyCenter,
      name: "myCenter"
    },
    {
      path: "/",
      redirect: "projectList",
    },
  ],
});





router.beforeEach((to, from, next) => {

  let userInfo = JSON.parse(localStorage.getItem("userInfo"));
  if (userInfo && from.fullPath === '/') {
    store.commit("saveUserInfo", userInfo);
  }

  if (
    to.matched.some((record) => record.meta.requiresAuth) && userInfo
  ) {
    Vue.axios.get("/project/get-project-operation-permission", {
      params: {
        token: ""
      }
    }).then(
      (response) => {
        response = response.data;
        if (response.code === 200) {
          store.commit("saveProjectPermission", response.data);
        }
      }
    );
  }

  let routerArr = ["userLogin", "register"];
  if (routerArr.indexOf(to.name) === -1 && !userInfo) {
    next("/login");
  } else {
    next();
  }

});


export default router;
