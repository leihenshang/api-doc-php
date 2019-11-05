import Vue from "vue";
import VueRouter from "vue-router";
import Project from "./viewPage/project";
import Api from "./viewPage/api";
import Detail from "./viewPage/projectDetail";
import Msg from "./viewPage/msg";
import ApiPage from "./components/api/apiPage";
import DetailPage from "./components/detail/detailPage";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: "/project", component: Project },
    { path: "/", component: Project },
    { path: "/api/:id", name: "api", component: Api, props: true },
    {
      path: "/detail/:id", name: "detail", component: Detail, props: true,
      children: [
        { path: 'apiPage', component: ApiPage },
        { path: 'detailPage', component: DetailPage },
        { path: '', component: DetailPage },
      ]
    },
    { path: "/msg", name: "msg", component: Msg }
  ]
});
