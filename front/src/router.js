import Vue from "vue";
import VueRouter from "vue-router";
import Project from "./viewPage/project";
import Api from "./viewPage/api";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: "/project", component: Project },
    { path: "/api", name: "api", component: Api }
  ]
});
