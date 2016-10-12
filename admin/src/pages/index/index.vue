<style>
	body {
		padding: 0;
		margin: 0;
		height: 100%;
	}
	
	.top-menu {
		position: relative;
		z-index: 10;
	}
	
	.main-content {
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		padding-top: 60px;
		z-index: 9;
	}
</style>
<template>
	<div>
		<el-row class="top-menu">
			<el-col :span="24">
				<el-menu theme="dark" default-active="1" class="el-menu-demo" mode="horizontal" @select="handleselect">
					<el-menu-item index="1">处理中心</el-menu-item>
					<el-submenu index="2">
						<template slot="title">我的工作台</template>
						<el-menu-item index="2-1">选项1</el-menu-item>
						<el-menu-item index="2-2">选项2</el-menu-item>
						<el-menu-item index="2-3">选项3</el-menu-item>
					</el-submenu>
					<el-menu-item index="3">订单管理</el-menu-item>
				</el-menu>
			</el-col>
		</el-row>
		<el-row class="main-content">
			<el-col :span="3" style="height:100%">
				<el-menu default-active="2" class="left-menu" @open="handleopen" @close="handleclose" style="height:100%">
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
			<el-col :span="21">
				<div class="grid-content bg-purple"></div>
			</el-col>
		</el-row>
	</div>
</template>

<script>
  export default {
      data: function() {
          msg: 'hello'
      }
  }
</script>