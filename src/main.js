import Vue from 'vue'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'
import App from './App.vue'
import router from './router.js'


Vue.use(ElementUI)
const app = new Vue({
  router,
  render: h => h(App), 
}).$mount('#app')