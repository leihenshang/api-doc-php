import Vue from "vue";
import VueRouter from "vue-router";

//项目相关
import Home from "./viewPage/home";
import Detail from "./viewPage/projectDetail";
// import Msg from "./viewPage/msg";
import ProjectList from "./components/project/projectList";
import FieldMapping from "./components/project/fieldMapping";

//api相关操作
import ApiPage from "./components/api/apiPage";
import apiCreate from "./components/api/apiCreate";
import DetailPage from "./components/project/detailPage";
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
import Login from "./components/user/login";
import Register from "./components/user/register";
import MyCenter from "./components/user/myCenter";
import UserManager from "./components/user/userManager";

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    { path: "/register", component: Register, name: "register" },
    { path: "/login", name: "userLogin", component: Login },
    {
      path: "/detail/:id",
      component: Detail,
      props: true,
      children: [
        {
          path: "",
          name: "detailPage",
          component: DetailPage,
          meta: { requiresAuth: true },
          props: true,
        },
        {
          path: "fieldMapping",
          name: "fieldMapping",
          component: FieldMapping,
          meta: { requiresAuth: true },
          props: true,
        },
        {
          path: "apiPage",
          name: "apiPage",
          component: ApiPage,
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
      path: "/",
      component: Home,
      redirect: "projectList",
      children: [
        { path: "projectList", component: ProjectList, name: "projectList" },
        {
          path: "myCenter",
          component: MyCenter,
          name: "myCenter",
        },
        {
          path: "userManager",
          component: UserManager,
          name: "userManager",
        },
      ],
    },
  ],
});

export default router;
