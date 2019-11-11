import Vue from "vue";
import VueRouter from "vue-router";
import Project from "./viewPage/project";
import Detail from "./viewPage/projectDetail";
import Msg from "./viewPage/msg";
import ApiPage from "./components/api/apiPage";
import CreateApi from "./components/api/createApi";
import DetailPage from "./components/detail/detailPage";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: "/project", component: Project },
    { path: "/", component: Project },
    {
      path: "/detail/:id", name: "detail", component: Detail, props: true,
      children: [
        { path: 'detailPage', component: DetailPage },
        { path: 'apiPage', component: ApiPage },
        { path: 'createApi', component: CreateApi },
      ]
    },
    { path: "/msg", name: "msg", component: Msg }
  ]
});
