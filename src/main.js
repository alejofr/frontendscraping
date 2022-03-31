import Vue from 'vue'
import VueRouter from 'vue-router'

import axios from 'axios'
import VueAxios from 'vue-axios'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import { routes } from './routes.js';
import  auth  from './auth';
import App from './App.vue';


import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import './assets/Icon/style.css';
import './assets/css/app.css';
//import { _ } from 'core-js'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueRouter);
Vue.use(VueAxios, axios);

Vue.config.productionTip = false

const router = new VueRouter({
  mode: 'history',
  routes: routes
});

console.log(process.env.VUE_APP_RUTA_SERVE);

console.log(auth.state.loginStatus)

router.beforeEach((to, from, next) => {

if(to.meta.requiresAuth){
    if (auth.state.loginStatus) {
        next();
    } else {
      next({ name: 'Login' })
    }
}else  {
    next();
}
})

axios.interceptors.request.use(function (config) {

  if ( auth.state.loginStatus ){
    let headers = {
       'Authorization' : "Bearer "+auth.state.token
    };
   // let headers = {};
    //headers.Authorization = "Bearer "+auth.state.token;
    config['headers'] = headers;
  }
    console.log(config)
    return config;
  }, function (error) {
    alert('fallo la solicitud' + error)
    return Promise.reject(error);
});


axios.interceptors.response.use(function (response) {
  if( response.status == 401|| response.data.code == 401 ){
    localStorage.removeItem('token')
    router.replace('/Login')
  }
  return response;
  }, function (error) {

  if(error.statusCode==500){
    console.log(error);
  }

  return Promise.reject(error);
});

const app = new Vue({
  el: '#app',
  store:auth,
  router: router,
  render: h => h(App),
});

export default app
