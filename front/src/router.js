import Vue from "vue";
import VueRouter from "vue-router";

//api
import Project from "./viewPage/project";
import Detail from "./viewPage/projectDetail";
// import Msg from "./viewPage/msg";
import ProjectList from "./components/project/projectList";
import ApiPage from "./components/api/apiPage";
import apiCreate from "./components/api/apiCreate";
import DetailPage from "./components/detail/detailPage";

//文档相关操作
import DocPage from "./components/doc/docPage";
import DocCreate from "./components/doc/docCreate";
import DocEdit from "./components/doc/docEdit";
import DocDetail from "./components/doc/docDetail";

//用户相关操作
import Login from "./components/user/login";
import Register from "./components/user/register";
import UserCenter from "./components/user/userCenter";
import User from "./components/user/user";
import VueResource from "vue-resource";
import { Store } from "vuex";
// import UserManagement from "./components/user/userManagement";

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    { path: "/register", component: Register, name: "register" },
    { path: "/project", component: Project },
    { path: "/login", name: "userLogin", component: Login },
    {
      path: "/",
      component: Project,
      children: [
        { path: "", component: ProjectList }
        // ,
        // {
        //   path: "userManagement",
        //   name: "userManagement",
        //   component: UserManagement
        // }
      ]
    },
    {
      path: "/detail/:id",
      component: Detail,
      props: true,
      name: "detail",

      children: [
        {
          path: "",
          name: "detailPage",
          component: DetailPage,
          meta: { requiresAuth: true },
          props: true
        },
        {
          path: "apiPage",
          name: "apiPage",
          component: ApiPage,
          meta: { requiresAuth: true },
          props: true
        },
        {
          path: "apiCreate/:groupId",
          name: "apiCreate",
          component: apiCreate,
          meta: { requiresAuth: true },
          props: true
        },

        {
          path: "user",
          name: "user",
          component: User,
          props: true,
          meta: { requiresAuth: true }
        },
        {
          path: "projectDoc",
          name: "projectDoc",
          component: DocPage,
          props: true,
          children: [
            {
              path: "docDetail/:docId",
              name: "docDetail",
              component: DocDetail,
              props: true,
              meta: { requiresAuth: true }
            },
            {
              path: "docEdit/:docId",
              name: "docEdit",
              component: DocEdit,
              props: true,
              meta: { requiresAuth: true }
            },
            {
              path: "docCreate",
              name: "docCreate",
              component: DocCreate,
              props: true,
              meta: { requiresAuth: true }
            }
          ]
        }
      ]
    },
    {
      path: "/userCenter",
      component: UserCenter,
      name: "userCenter"
    }
    // { path: "/msg", name: "msg", component: Msg }
  ]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    Vue.resource.get(
      Vue.prototype.apiAddress + "/project/get-project-operation-permission",
      {
        params: {
          token: Vue.prototype.userInfo.token,
          projectId: 22
        }
      }
    ).then(
      response => {
        response = response.body;
        if (response.code === CODE_OK) {
          Vue.$store.commit("savePermission", response.data);
        }
      },
      res => {
        let response = res.body;
        Vue.$message.error(
          "获取项目信息-操作失败!" + !response.msg ? response.msg : ""
        );
      }
    );
    console.log("进入了项目详情页");
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

export default router;
