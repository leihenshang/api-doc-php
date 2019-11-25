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

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: "/project", component: Project },
    {path:"/login",component:Login},
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
        { path: "detailPage",name:'detailPage', component: DetailPage },
        { path: "apiPage",name:'apiPage', component: ApiPage },
        { path: "createApi",name:'createApi', component: CreateApi },
        { path: "apiDetail/:apiId",name:'apiDetail', component: ApiDetail,props:true },
        { path: "apiEdit/:apiId",name:'apiEdit', component: ApiEdit,props:true }
      ]
    }
    // { path: "/msg", name: "msg", component: Msg }
  ]
});
