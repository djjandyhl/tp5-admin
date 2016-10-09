<template>
	<div id="menu">
	  <el-col :span="3" class="menu-box">
	    <el-menu default-active="2" class="el-menu-vertical-demo" >
	      <el-submenu index="1">
		        <template slot="title"><i class="el-icon-message"></i>导航一</template>
		        <el-menu-item-group title="分组一">
		          <el-menu-item index="1-1">选项1</el-menu-item>
		          <el-menu-item index="1-2">选项2</el-menu-item>
		        </el-menu-item-group>
		        <el-menu-item-group title="分组2">
	          	<el-menu-item index="1-3">选项3</el-menu-item>
	        </el-menu-item-group>
	      </el-submenu>
	      <el-menu-item index="2"><i class="el-icon-menu"></i>导航二</el-menu-item>
	      <el-menu-item index="3"><i class="el-icon-setting"></i>导航三</el-menu-item>
	    </el-menu>
	  </el-col>
	</div>
</template>
<style>
	#menu{position: absolute;width: 100%;height: 100%;top: 0;left: 0;z-index: 9;}
	.menu-box{position: absolute;top: 0;height: 100%;padding-top: 60px;}
	.menu-box ul{height: 100%;}
</style>
