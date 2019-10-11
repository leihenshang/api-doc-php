import Vue from 'vue'
import App from './App.vue'
import router from './router'
import VueResource from 'vue-resource';

Vue.prototype.apiAddress = 'http://localhost:1000';

Vue.config.productionTip = false

Vue.use(VueResource);

new Vue({
  router:router,
  render: h => h(App),
}).$mount('#app')
