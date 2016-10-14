const routConfig = [
  {
    path: '/',
    name: '首页',
    component: require('./pages/index/index.vue'),
    children:[
      {
        path: '/user/index',
        name: '用户列表',
        component: require('./pages/user/index.vue'),
      },
      {
        path: '/role/index',
        name: '用户列表',
        component: require('./pages/role/index.vue'),
      }
    ]
  },
  {
    path: '/login',
    name: '登录',
    component: require('./pages/index/login.vue')
  }
];
export default routConfig;

