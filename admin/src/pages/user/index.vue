<template>
  <div>

    <el-form :inline="true" :model="search" @submit.native.prevent="onSubmit" class="demo-form-inline">
      <el-form-item>
        <el-input v-model="search.searchText" placeholder="用户名"></el-input>
      </el-form-item>
      <el-form-item>
        <el-form-item>
          <el-select v-model="search.roleId" placeholder="选择角色">
            <el-option label="全部角色" value="0"></el-option>
            <el-option v-for="role in roles" :label="role.rolename" :value="role.id"></el-option>
          </el-select>
        </el-form-item>
      </el-form-item>
      <el-form-item>
        <el-button native-type="submit" type="primary" icon="search" :loading="loading">查询</el-button>
        <el-button type="primary" icon="plus" @click.native="dialogShow('新增')">新增</el-button>
      </el-form-item>
    </el-form>
    <el-table :data="tableData.data" border style="width: 100%">
      <el-table-column property="id" label="ID" sortable></el-table-column>
      <el-table-column property="username" label="帐号"></el-table-column>
      <el-table-column property="real_name" label="姓名"></el-table-column>
      <el-table-column property="rolename" label="角色"></el-table-column>
      <el-table-column property="status" label="状态"></el-table-column>
      <el-table-column property="loginnum" label="登录次数"></el-table-column>
      <el-table-column property="last_login_time" label="最后登录时间" sortable></el-table-column>
      <el-table-column inline-template label="操作">
        <el-button-group>
          <el-button type="primary"  icon="edit" size="small" @click.native="dialogShow('编辑',row.id,$index)"></el-button>
          <el-button type="primary" :disabled="row.id==1" @click.native="rowDelete(row.id)" icon="delete" size="small"></el-button>
        </el-button-group>
      </el-table-column>
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
    <el-dialog :title="formName+'管理员'" @close="dialogHide" v-model="dialogFormVisible" size="tiny">
      <el-form :model="form" :rules="addUserRules" ref="form" label-width="100px" style="width: 80%;margin: auto">
        <el-form-item label="帐号" prop="username">
          <el-input v-model="form.username" :maxlength="16" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item v-if="formName=='新增'" label="密码" prop="password">
          <el-input v-model="form.password" type="password" :maxlength="16" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item v-if="formName=='编辑'" label="密码" prop="reset_password">
          <el-input v-model="form.reset_password" type="password" :maxlength="16" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="真实姓名" prop="real_name">
          <el-input v-model="form.real_name" :maxlength="10" auto-complete="off"></el-input>
        </el-form-item>
        <el-form-item label="所属角色" prop="role_id">
          <el-select v-model="form.role_id" placeholder="所属角色">
            <el-option v-for="role in roles" :label="role.rolename" :value="role.id"></el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button @click.native="dialogHide">取 消</el-button>
        <el-button v-if="formName=='新增'" type="primary" :loading="addLoading" @click.native="addFormSubmit">提 交</el-button>
        <el-button v-if="formName=='编辑'" type="primary" :loading="addLoading" @click.native="rowEdit">提 交</el-button>
      </span>
    </el-dialog>
  </div>
</template>
<script>
  export default{
    data() {
      var validateResetPwd = (rule, value, callback) => {
        if (value.length>0) {
          if (value.length < 4 || value.length > 16) {
            callback(new Error('请输入4-16位密码'));
          }else {
            callback();
          }
        } else {
          callback();
        }
      };
      return {
        tableData: {
          data: [],
          total: 0
        },
        search: {
          searchText: '',
          roleId: 0,
          pageNumber: 1,
          pageSize: 10
        },
        roles: [],
        loading: false,
        addLoading: false,
        dialogFormVisible: false,
        formName:'',
        form: {
          username: '',
          role_id: '',
          password: '',
          real_name: ''
        },
        addUserRules: {
          username: [
            {required: true, message: '请输入用户名', trigger: 'blur'},
            {min: 4, max: 16, message: '请输入4-16位用户名', trigger: 'blur'}
          ],
          role_id: [
            {type: "number", message: '请选择所属角色', trigger: 'change'}
          ],
          password: [
            {required: true, message: '请输入密码', trigger: 'blur'},
            {min: 4, max: 16, message: '请输入4-16位密码', trigger: 'blur'}
          ],
          reset_password: [
            {required: true, validator: validateResetPwd , trigger: 'blur'}
          ],
          real_name: [
            {required: true, message: '请输入管理员姓名', trigger: 'blur'},
            {min: 4, max: 16, message: '请输入2-10位管理员姓名', trigger: 'blur'}
          ]
        }
      }
    },
    methods: {
      getData: function (flag) {
        if (this.loading)return;
        this.loading = true;
        if (flag) {
          this.search.pageNumber = 1;
        }
        this.$http.get('user/index', {params: this.search}).then((res) => {
          this.loading = false;
          this.tableData.data = res.data.rows;
          this.tableData.total = res.data.total;
        })
      },
      onSubmit: function () {
        this.getData(true)
      },
      handleSizeChange: function () {
        this.getData();
      },
      handleCurrentChange: function () {
        this.getData();
      },
      dialogShow:function(name,id,index){
        this.dialogFormVisible = true;
        this.formName = name;
        var admin = this.tableData.data[index];
        if (name == '编辑' && admin.id == id) {
          this.form = {
            id:admin.id,
            username: admin.username,
            role_id: admin.role_id,
            reset_password: '',
            real_name: admin.real_name
          };
        }
      },
      dialogHide:function(){
        this.dialogFormVisible = false;
        if (typeof this.form.id != "undefined") {
          this.form = {username: '', role_id: '', password: '', real_name: ''};
        }
      },
      addFormSubmit: function () {
        if (this.addLoading) return;
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.$http.post('user/userAdd', this.form).then((res) => {
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
      handleReset: function () {

      },
      rowEdit:function () {
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.addLoading = true;
            this.$http.post('user/userEdit', this.form).then((res) => {
              this.addLoading = false;
              if (res.data.code > 0) {
                this.$message({message:res.data.msg,type:'success'});
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
      rowDelete:function (id) {
        this.$confirm('此操作将永久删除该管理员, 是否继续?', '提示', {
          type: 'warning'
        }).then(() => {
          this.$http.post('user/delete', {id:id}).then((res) => {
            if (res.data.code > 0) {
              this.$message({
                type: 'success',
                message: res.data.msg
              });
            } else {
              this.$message.error(res.data.msg);
            }
          })

        })
      },
      getRoles(){
        this.$http.get('role/index').then((res) => {
          this.roles = res.data.rows;
        })
      }
    },
    created () {
      this.getData();
    },
    activated(){
      this.getRoles();
    }

  }
</script>