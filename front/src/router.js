import Vue from "vue";
import VueRouter from "vue-router";
import Project from "./viewPage/project";
import ProjectList from "./components/project/projectList";
import Detail from "./viewPage/projectDetail";
// import Msg from "./viewPage/msg";
import ApiPage from "./components/api/apiPage";
import ApiDetail from "./components/api/apiDetail";
import ApiEdit from "./components/api/apiEdit";
import CreateApi from "./components/api/createApi";
import DetailPage from "./components/detail/detailPage";
import Login from "./viewPage/login";
import Register from "./viewPage/register";
import User from "./components/user/user";

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    { path: "/register", component: Register, name: 'register' },
    { path: "/project", component: Project },
    { path: "/login", name: 'userLogin', component: Login },
    {
      path: "/",
      component: Project,
      children: [{ path: "", component: ProjectList }]
    },
    {
      path: "/detail/:id",
      name: "detail",
      component: Detail,
      props: true,
      children: [
        { path: "detailPage", name: 'detailPage', component: DetailPage },
        { path: "apiPage", name: 'apiPage', component: ApiPage },
        { path: "createApi", name: 'createApi', component: CreateApi },
        { path: "apiDetail/:apiId", name: 'apiDetail', component: ApiDetail, props: true },
        { path: "apiEdit/:apiId", name: 'apiEdit', component: ApiEdit, props: true },
        { path: "user", name: 'user', component: User, props: true }
      ]
    }
    // { path: "/msg", name: "msg", component: Msg }
  ]

});

router.beforeEach((to, from, next) => {

  if (to.name !== 'register') {
    let routerArr = ['userLogin', 'register'];
    if (routerArr.indexOf(to.name) === 0) {
      next();
    } else {
      if (!Vue.prototype.userInfo) {
        next('/login');
      } else {
        next();
      }
    }
  }
  
  next();
});

export default router;
