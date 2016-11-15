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

  }

  .my-dropdown{
    line-height: 60px;
    color: #c0ccda;
    margin-right: 10px;
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
    margin-top: 15px;
  }

  .main-content-breadcrumb {

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
        <el-dropdown class="my-dropdown">
          <span class="el-dropdown-link">
            {{info.realname}}<i class="el-icon-caret-bottom el-icon--right"></i>
          </span>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item @click.native="logout">退  出</el-dropdown-item>
          </el-dropdown-menu>
        </el-dropdown>
      </el-col>
    </el-row>
    <el-row class="main-content">
      <el-col :span="3" class="main-content-left">
        <el-menu :router="true" :default-active="$route.fullPath=='/'?'':$route.fullPath"
                 v-if="menus.length>0" class="left-menu" style="height:100%">
          <el-submenu :index="menu.node_name" v-for="(menu,index) in menus">
            <template slot="title"><i class="el-icon-message"></i>{{ menu.node_name }}</template>
            <el-menu-item :index="'/'+item.href" @click.native="clickMenu(menu,item)" v-for="item in menu.child">{{
              item.node_name }}
            </el-menu-item>
          </el-submenu>
        </el-menu>
      </el-col>
      <el-col :span="21" class="main-content-right">
        <div style="margin: 20px;">
          <div class="main-content-breadcrumb">
            <el-breadcrumb separator="/">
              <el-breadcrumb-item v-for="node in activeMenus">{{ node }}</el-breadcrumb-item>
            </el-breadcrumb>
          </div>
          <div class="main-views">
            <keep-alive>
              <router-view></router-view>
            </keep-alive>
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
        activeMenus: ['首页']
      }
    },
    methods: {
      clickMenu: function (menu, item) {
        this.activeMenus = [];
        this.activeMenus.push(menu.node_name);
        this.activeMenus.push(item.node_name);
      },
      logout: function () {
        this.$http.get('Login/logout').then((res) => {
          if (res.data.status == 1) {
            this.$router.push({path: '/login'})
          }
        })
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