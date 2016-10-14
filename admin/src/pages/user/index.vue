<template>
  <div >

    <el-form :inline="true" :model="search" @submit.native.prevent="onSubmit" class="demo-form-inline">
      <el-form-item>
        <el-input v-model="search.searchText" placeholder="用户名"></el-input>
      </el-form-item><el-form-item>
    </el-form-item><el-form-item>
      <el-button native-type="submit" type="primary">查询</el-button>
    </el-form-item>
    </el-form>
    <el-table :data="tableData.data" border style="width: 100%">
      <el-table-column property="id" label="ID" sortable ></el-table-column>
      <el-table-column property="username" label="帐号" ></el-table-column>
      <el-table-column property="real_name" label="姓名" ></el-table-column>
      <el-table-column property="rolename" label="角色" ></el-table-column>
      <el-table-column property="status" label="状态" ></el-table-column>
      <el-table-column property="last_login_time" label="最后登录时间" sortable></el-table-column>
    </el-table>
    <div class="page-block text-center">
      <el-pagination
        @sizechange="handleSizeChange"
        @currentchange="handleCurrentChange"
        :current-page="search.pageNumber"
        :page-sizes="[10, 25, 50, 100]"
        :page-size="search.pageSize"
        layout="total, sizes, prev, pager, next, jumper"
        :total="tableData.total">
      </el-pagination>
    </div>
  </div>



</template>
<script>
  export default{
    data() {
      return {
        tableData: {
          data:[],
          total:0
        },
        search:{
          searchText:'',
          pageNumber:1,
          pageSize:10
        },
        roles:[]
      }
    },
    methods: {
      getData:function (flag) {

        this.loading = true;
        if(flag){
          this.search.pageNumber = 1;
        }
        this.$http.get('user/index',{params:this.search}).then((res) => {
          this.tableData.data = res.data.rows;
          this.tableData.total = res.data.total;
        })
      },
      onSubmit:function () {
        this.getData(true)
      },
      handleSizeChange:function () {
        this.getData();
      },
      handleCurrentChange:function () {
        this.getData();
      }
    },
    mounted:function () {
      this.$http.get('user/index',{params:this.search}).then((res) => {
        this.tableData.data = res.data.rows;
        this.tableData.total = res.data.total;
      })
      this.getData();
    }

  }
</script>