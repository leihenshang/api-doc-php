/*
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:26:42
 * @LastEditTime: 2019-10-10 18:29:59
 * @LastEditors: Please set LastEditors
 */
import Vue from "vue";
import VueRouter from "vue-router";
import Project from "./viewPage/project.vue";
import Api from "./viewPage/api";

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    { path: "/project", component: Project },
    { path: "/api", component: Api }
  ]
});
