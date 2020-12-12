import Vue from "vue";
import VueRouter from "vue-router";
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
      path: "/detail/:projectId",
      component: resolve => require(['./page/project/project'], resolve),
      props: true,
      children: [

        {
          path: "/detail/:projectId",
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
          path: "members",
          name: "members",
          component: resolve => require(['./components/project/members'], resolve),
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
          component: resolve => require(["./components/api/apiPage"], resolve),
          meta: { requiresAuth: true },
          redirect: "apiPage/apiList",
          props: true,
          children: [
            {
              path: "apiCreate",
              name: "apiCreate",
              component: resolve => require(["./components/api/apiCreate"], resolve),
              meta: { requiresAuth: true },
              props: true,
            },
            {
              path: "apiList",
              name: "apiList",
              component: resolve => require(["./components/api/apiList"], resolve),
              meta: { requiresAuth: true },
              props: true,
            },
            {
              path: "apiEdit/:apiId",
              name: "apiEdit",
              component: resolve => require(["./components/api/apiEdit"], resolve),
              meta: { requiresAuth: true },
              props: true,
            },
            {
              path: "apiDetail/:apiId",
              name: "apiDetail",
              component: resolve => require(["./components/api/apiDetail"], resolve),
              meta: { requiresAuth: true },
              props: true,
            },
          ],
        },
        {
          path: "projectDoc",
          name: "projectDoc",
          component: resolve => require(["./components/doc/docPage"], resolve),
          props: true,
          redirect: "projectDoc/docList",
          children: [
            {
              path: "docList",
              name: "docList",
              component: resolve => require(["./components/doc/docList"], resolve),
              props: true,
              meta: { requiresAuth: true },
            },
            {
              path: "docDetail/:docId",
              name: "docDetail",
              component: resolve => require(["./components/doc/docDetail"], resolve),
              props: true,
              meta: { requiresAuth: true },
            },
            {
              path: "docEdit/:docId",
              name: "docEdit",
              component: resolve => require(["./components/doc/docEdit"], resolve),
              props: true,
              meta: { requiresAuth: true },
            },
            {
              path: "docCreate",
              name: "docCreate",
              component: resolve => require(["./components/doc/docCreate"], resolve),
              props: true,
              meta: { requiresAuth: true },
            },
          ],
        },
      ],
    },
    {
      path: "/projectList",
      component: resolve => require(['./components/project/projectList'], resolve),
      name: "projectList"
    },
    {
      path: "/userManager",
      component: resolve => require(['./page/user/userManager'], resolve),
      name: "userManager"
    },
    {
      path: "/myCenter",
      component: resolve => require(['./page/user/myCenter'], resolve),
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
