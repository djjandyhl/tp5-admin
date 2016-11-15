var path = require('path');
var cooking = require('cooking');

cooking.set({
  entry: {
    app: ['babel-polyfill', './admin/src/main.js']
  },
  dist: './server/public/dist',
  template: './admin/index.tpl',

 /* devServer: {
    port: 8080,
    publicPath: '/',
    stats: 'info',
    noInfo: true,
    quiet: false,
    lazy: false,
    // HTML5 history API
    historyApiFallback: true,
    log: false,
    // 热替换
    hot: true
  },*/

  // production
  clean: true,
  hash: true,
  sourceMap: true,
  minimize: false,
  chunk: true, // see https://cookingjs.github.io/zh-cn/configuration.html#chunk
  postcss: [
    // require('...')
  ],
  publicPath: './',
  assetsPath: 'static',
  urlLoaderLimit: 10000,
  extractCSS: '[name].[contenthash:7].css',
  alias: {
    'src': path.join(__dirname, 'src')
  },
  // extends: ['vue2', 'lint', 'saladcss']
  extends: ['vue2']
});

module.exports = cooking.resolve();
