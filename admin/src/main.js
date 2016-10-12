import Vue from 'vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
import App from './app';
import VueRouter from 'vue-router';
import routerConfig from './router';
import vueResource from 'vue-resource';


Vue.use(ElementUI);
Vue.use(VueRouter);
Vue.use(vueResource);
Vue.http.options.root = '/root';

const apiRoot = 'http://assets.dev/';
const router = new VueRouter({
  mode: 'hash',
  base: __dirname,
  routes: routerConfig
});

Vue.http.options.root = apiRoot;
Vue.http.headers.common['Authorization'] = 'no';
Vue.http.options.emulateJSON = true;
new Vue({ // eslint-disable-line
  data: {
    apiRoot: apiRoot
  },
  router,
  render: h => h(App)
}).$mount('#app');

