<template>
  <div id="app">
  	<header-top></header-top>
  	<sidebar></sidebar>
</div>
</template>
<style>
body,div,h1,h2,h3,h4,h5,h6,p,ul,li{margin:0;padding:0;}
a,a:hover{text-decoration:none;}
li{list-style:none;}
.wap{width:1100px;margin:0 auto;}
.floatLeft{float:left;}
.floatRight{float:right;}
body {
  	font-family: Helvetica, sans-serif;
	font-size:12px;
}
</style>
<script>
	import headerTop from './pages/header.vue'
	import sidebar from './pages/sidebar.vue'
	export default {
    	components: { headerTop ,sidebar}
	}
</script>
