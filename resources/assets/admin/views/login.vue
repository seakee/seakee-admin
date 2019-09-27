<template>
    <div class="login">
        <div class="login-con">
            <el-row class="login-header"><h4>欢迎登录</h4></el-row>
            <el-form :model="loginForm" status-icon :rules="rules" ref="loginForm" label-width="50px" size="small">
                <el-form-item label="账号" prop="account">
                    <el-input v-model="loginForm.account"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="password">
                    <el-input type="password" v-model="loginForm.password" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitForm('loginForm')">登录</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
    export default {
        name   : "login",
        data() {
            const checkAccount = (rule, value, callback) => {
                if (!value) {
                    return callback(new Error('账号不能为空'));
                }

                return callback();
            };
            const validatePass = (rule, value, callback) => {
                if (value === '') {
                    callback(new Error('请输入密码'));
                }
                return callback();
            };
            return {
                loginForm: {
                    password: '',
                    account : ''
                },
                rules    : {
                    password: [
                        {
                            validator: validatePass,
                            trigger  : 'blur'
                        }
                    ],
                    account : [
                        {
                            validator: checkAccount,
                            trigger  : 'blur'
                        }
                    ]
                }
            };
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.loading = true;
                        this.$store.dispatch('login', this.loginForm).then(() => {
                            this.loading = false;
                            this.$router.push({path: '/'});
                        }).catch(() => {
                            this.loading = false;
                        })
                    } else {
                        console.log('error submit!!');
                        return false
                    }
                });
            }
        }
    }
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
    #app, body, html {
        height: 100%;
        width: 100%;
    }

    body, html {
        margin: 0;
        overflow: hidden;
        padding: 0;
    }

    .login {
        background-image: url('http://cn.bing.com/az/hprichbg/rb/KilchurnSky_ZH-CN9305096030_1920x1080.jpg');
        background-position: 50%;
        background-size: cover;
        height: 100%;
        position: relative;
        width: 100%;
    }

    .login-con {
        -webkit-transform: translateY(-60%);
        position: absolute;
        right: 160px;
        top: 50%;
        transform: translateY(-60%);
        width: 300px;
        background: #fff;
        border-radius: 4px;
    }

    .el-button {
        width: 100%;
    }

    .el-form {
        padding: 15px;
    }

    .login-header {
        padding-left: 20px;
        border-bottom: solid 1px #e6e6e6;
    }
</style>
