<template>
  <div>

    <el-form :inline="true" :model="search" @submit.native.prevent="onSubmit" class="demo-form-inline">
      <el-form-item>
        <el-input v-model="search.searchText" placeholder="角色名"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button native-type="submit" type="primary" icon="search" :loading="loading">查询</el-button>
        <el-button type="primary" icon="plus" @click.native="dialogFormVisible = true">新增</el-button>
      </el-form-item>
    </el-form>
    <el-table :data="tableData.data" border style="width: 100%">
      <el-table-column property="id" label="ID" sortable></el-table-column>
      <el-table-column property="rolename" label="角色名"></el-table-column>
      <el-table-column inline-template label="操作">
        <el-button-group>
          <el-button type="primary" icon="edit" size="small"></el-button>
          <el-button type="primary" :disabled="row.id==1" @click.native="rowDelete(row.id)" icon="delete" size="small"></el-button>
        </el-button-group>
      </el-table-column>
    </el-table>

    <el-dialog title="新增角色" v-model="dialogFormVisible" size="tiny" open="loadNodes">
      <el-form :model="form" :rules="addRoleRules" ref="form" label-width="100px" style="width: 80%;margin: auto">
        <el-form-item label="角色名" prop="rolename">
          <el-input v-model="form.rolename" :maxlength="16" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="权限" prop="roles">
          <el-tree
            @check-change="handleCheckChange"
            :data="nodes"
            :props="props"
            :show-checkbox="true"
            :highlight-current="true">
          </el-tree>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click.native="dialogFormVisible = false">取 消</el-button>
        <el-button type="primary" :loading="addLoading" @click.native="addFormSubmit">提 交</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
  export default{
    data() {
      return {
        tableData: {
          data: []
        },
        search: {
          searchText: ''
        },
        loading: false,
        addLoading: false,
        dialogFormVisible: false,
        form: {
          rolename: '',
          nodes: []
        },
        addRoleRules: {
          rolename: [
            {required: true, message: '请输入角色名', trigger: 'blur'},
            {min: 1, max: 10, message: '请输入1-10位角色名', trigger: 'blur'}
          ],
          nodes: [
            { message: '请选择所属角色', trigger: 'blur'}
          ]
        },
        nodes:[],
        props: {
          label: 'node_name',
          children: 'child'
        },
      }
    },
    methods: {
      getData(flag) {
        if (this.loading)return;
        this.loading = true;
        if (flag) {
          this.search.pageNumber = 1;
        }
        this.$http.get('role/index', {params: this.search}).then((res) => {
          this.loading = false;
          this.tableData.data = res.data.rows;
        })
      },
      onSubmit() {
        this.getData(true)
      },
      handleSizeChange() {
        this.getData();
      },
      handleCurrentChange () {
        this.getData();
      },
      addFormSubmit() {
        if (this.addLoading) return;
        console.log(this.form);
        this.$refs.form.validate((valid) => {
         if (valid) {
            this.$http.post('role/roleAdd', this.form).then((res) => {
              this.addLoading = false;
              if (res.data.code > 0) {
                this.dialogFormVisible = false;
                this.$refs.form.resetFields();
              } else {
                this.$message.error(res.data.msg);
              }
            })
          } else {
           return false;
         }
        });
      },
      handleReset () {

      },
      rowDelete (id) {
        this.$confirm('此操作将永久删除该角色, 是否继续?', '提示', {
          type: 'warning'
        }).then(() => {
          this.$http.post('role/roleDel', {id: id}).then((res) => {
            if (res.data.code > 0) {
              this.$message({
                type: 'success',
                message: res.data.msg
              });
              this.getData();
            } else {
              this.$message.error(res.data.msg);
            }
          })

        })
      },
      loadNodes () {
        this.$http.get('index/nodes').then((res) => {
          console.log(res);
           this.nodes = res.data.data;
        })
      },
      handleCheckChange(data, checked, indeterminate){
        console.log(data, checked, indeterminate);
        //this.form.nodes = nodes;
        if(checked){
          this.form.nodes.push(data.id);
        }else{
          for (var i = 0; i < this.form.nodes.length; i++) {
            if(this.form.nodes[i] == data.id){
              this.form.nodes.splice(i,1);
              break;
            }
          }
        }
      }
    },
    mounted: function () {
      this.getData();
      this.loadNodes();
    }

  }
</script>