/*
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:26:42
 * @LastEditTime: 2019-10-10 18:29:59
 * @LastEditors: Please set LastEditors
 */
import Vue from 'vue'


Vue.use(VueRouter)


export default new VueRouter({
    routers: [
        { path: '/foo', component: Foo },
        { path: '/bar', component: Bar }
    ]
})