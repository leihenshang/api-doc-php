import Vue from "vue";
import VueRouter from "vue-router";
import Project from "./viewPage/project";
import Api from "./viewPage/api";
import Detail from "./viewPage/detail";
import Msg from "./viewPage/msg";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: "/project", component: Project },
    { path: "/", component: Project },
    { path: "/api", name: "api", component: Api },
    { path: "/detail/:id", name: "detail", component: Detail, props: true },
    { path: "/msg", name: "msg", component: Msg }
  ]
});
