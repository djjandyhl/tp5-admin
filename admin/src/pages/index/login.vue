<style>
  .login-content {
    width: 350px;
    margin: 100px auto 0;
  }
</style>
<template>
  <div class="login-content">
    <el-form ref="form" :model="form" :rules="rules" label-width="80px" @submit.native.prevent="formSubmit">
      <el-form-item label="用户名" prop="username">
        <el-input v-model="form.username"></el-input>
      </el-form-item>
      <el-form-item label="密码" prop="password">
        <el-input v-model="form.password" type="password"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" native-type="submit" :loading="loading">登录</el-button>
      </el-form-item>
    </el-form>
  </div>

</template>

<script>
  import Vue from 'vue';
  export default {
    data() {
      return {
        form: {
          username: '',
          password: ''
        },
        rules: {
          username: [
            {required: true, message: '请输入用户名', trigger: 'blur'}
          ],
          password: [
            {required: true, message: '请输入密码', trigger: 'change'}
          ]
        },
        loading:false
      }
    },
    methods: {
      formSubmit() {
        if(this.loading) return;
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = true;
            this.$http.post('login/doLogin', this.form).then((res) => {
              this.loading = false;
              if (res.data.code != 1) {
                this.$message({
                  message: res.data.msg,
                  type: 'error',
                  showClose: true
                });
              } else {
                Vue.http.headers.common['jwt'] =  res.data.data;
                localStorage.setItem('jwt_token', res.data.data);
                this.$router.push({ path: '/' })
              }
            })
          }
        });

      }
    }
  }
</script>