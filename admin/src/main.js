import Vue from 'vue';
import VueRouter from 'vue-router';
import vueResource from 'vue-resource';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
import './style/main.css';
import App from './app';
import routerConfig from './router';

Vue.use(VueRouter);
Vue.use(vueResource);
Vue.use(ElementUI);


const apiRoot = '/admin';
let token = localStorage.getItem('jwt_token');

Vue.http.options.root = apiRoot;
Vue.http.options.emulateJSON = true;
if(token && token != null){
  Vue.http.headers.common['jwt'] =  token;
}


const router = new VueRouter({
  mode: 'hash',
  base: __dirname,
  routes: routerConfig
});

// 检测登录
router.beforeEach((to, from, next) => {
  let token = localStorage.getItem('jwt_token');
  if (to.path != '/login' && (!token || token === null)) {
    next({path: '/login'})
  } else {
    next();
  }
})

var app = new Vue({ // eslint-disable-line
  router,
  render: h => h(App)
}).$mount('#app');

Vue.http.interceptors.push((request, next)  => {

  // modify request
  app.httpLoading = true;
  console.log('sending....')
  // continue to next interceptor
  next((response) => {
    console.log('over....')
    app.httpLoading = false;
    if(response.data.status == -1){
      app.$router.push('/login')
    }else{
      return response;
    }

  });
});
