<style>
  body {
    padding: 0;
    margin: 0;
    height: 100%;
  }

  .top-menu {
    position: relative;
    z-index: 10;
    height: 60px;
  }

  .logo-title-text {
    line-height: 60px;
    padding: 0;
    margin: 0 15px;
    color: #c0ccda;;
  }

  .top-menu-submenu {
    float: right !important;
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

  .main-content-left {
    height: 100%
  }

  .main-content-right {

    height: 100%;
    background: #F9FAFC;
  }

  .main-views {
    background: #ffffff;
    padding: 20px;
    margin-top: 20px;
  }

  .main-content-breadcrumb{

  }
</style>
<template>
  <div>
    <el-row class="top-menu el-menu--dark">
      <el-col :span="20">
        <div>
          <h2 class="logo-title-text">后台管理系统</h2>
        </div>
      </el-col>
      <el-col :span="4">
        <el-menu theme="dark" default-active="1" class="el-menu-demo" mode="horizontal">
          <el-submenu class="top-menu-submenu" index="2">
            <template slot="title">{{info.realname}}</template>
            <el-menu-item index="1">退出</el-menu-item>
          </el-submenu>
        </el-menu>
      </el-col>
    </el-row>
    <el-row class="main-content">
      <el-col :span="3" class="main-content-left">
        <el-menu :router="true" :default-active="$route.fullPath=='/'?'/user/index':$route.fullPath"
                 v-if="menus.length>0" class="left-menu" style="height:100%" @select="changeMenu" @close="closeMenu">
          <el-submenu :index="menu.node_name" v-for="(menu,index) in menus">
            <template slot="title"><i class="el-icon-message"></i>{{ menu.node_name }}</template>
            <el-menu-item :index="'/'+item.href" v-for="item in menu.child">{{ item.node_name }}</el-menu-item>
          </el-submenu>
        </el-menu>
      </el-col>
      <el-col :span="21" class="main-content-right">
        <div style="margin: 15px;">
          <div class="main-content-breadcrumb">
            <el-breadcrumb separator="/">
              <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
              <el-breadcrumb-item>活动管理</el-breadcrumb-item>
            </el-breadcrumb>
          </div>
          <div class="main-views">
            <router-view></router-view>
          </div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
  export default {
    data: function () {
      return {
        menus: [],
        info: {},

      }
    },
    methods:{
      changeMenu:function (	index, indexPath) {
        console.log(index+"---"+indexPath)
      },
      closeMenu:function (index, indexPath) {
        console.log(index+"---"+indexPath)
      }
    },
    created: function () {
      this.$http.get('index/index').then((res) => {
        if (res.data.status == 1) {
          this.menus = res.data.data.menus;
          this.info = res.data.data.info;
        }
      })
    }
  }
</script>