import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
import './style/main.css';
import App from './app';
import VueRouter from 'vue-router';
import routerConfig from './router';
import vueResource from 'vue-resource';


Vue.use(ElementUI);
Vue.use(VueRouter);
Vue.use(vueResource);

const apiRoot = '/admin';
let token = localStorage.getItem('jwt_token');

Vue.http.options.root = apiRoot;
Vue.http.options.emulateJSON = true;
if(token && token != null){
  Vue.http.headers.common['Authorization'] =  token;
}


const router = new VueRouter({
  mode: 'hash',
  base: __dirname,
  routes: routerConfig
});

// 检测登录
router.beforeEach((to, from, next) => {

  if (to.path != '/login' && (!token || token === null)) {
    next({path: '/login'})
  } else {
    next();
  }
})

const app = new Vue({ // eslint-disable-line
  data: {
    apiRoot: apiRoot,
    httpLoading:false
  },
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
