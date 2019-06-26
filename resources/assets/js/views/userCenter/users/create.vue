<template>
    <div class="app-container">
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <div class="el-page-header">
                    <div class="el-page-header__left" @click="goBack"><i class="el-icon-back"></i>
                        <div class="el-page-header__title">返回</div>
                    </div>
                    <div class="el-page-header__content">新增用户</div>
                </div>
            </div>
            <el-form :model="userForm" :rules="rules" ref="userForm" label-width="100px" status-icon>
                <el-form-item label="用户名" prop="user_name">
                    <el-input v-model="userForm.user_name"></el-input>
                </el-form-item>
                <el-form-item label="邮箱" prop="email">
                    <el-input v-model="userForm.email"></el-input>
                </el-form-item>
                <el-form-item label="手机号" prop="mobile">
                    <el-input v-model="userForm.mobile"></el-input>
                </el-form-item>
                <el-form-item label="密码" prop="password">
                    <el-input type="password" v-model="userForm.password"></el-input>
                </el-form-item>
                <el-form-item label="确认密码" prop="password_confirmation">
                    <el-input type="password" v-model="userForm.password_confirmation"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitForm('userForm')">立即创建</el-button>
                    <el-button @click="resetForm('userForm')">重置</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
    import { create } from "@/api/user";

    export default {
        name:'create',
        data() {
            let validatePass = (rule, value, callback) => {
                if (this.userForm.password !== '') {
                    this.$refs.userForm.validateField('password_confirmation');
                }
                callback();
            };
            let validatePass2 = (rule, value, callback) => {
                if (value !== this.userForm.password) {
                    callback(new Error('两次输入密码不一致!'));
                } else {
                    callback();
                }
            };
            return {
                userForm: {
                    user_name            : '',
                    email                : '',
                    mobile               : '',
                    password             : '',
                    password_confirmation: ''
                },
                rules: {
                    user_name: [
                        { required: true, message: '请输入用户名', trigger: 'blur'},
                        { min: 5, max: 15, message: '长度在 5 到 15 个字符', trigger: ['blur', 'change'] },
                        { pattern: /^[A-Za-z0-9]{5,15}$/, message: '用户名只能是字母或数字', trigger: 'blur' }
                    ],
                    email: [
                        { required: true, message: '请输入邮箱地址', trigger: 'blur' },
                        { type: 'email', message: '请输入正确的邮箱地址', trigger: ['blur', 'change'] }
                    ],
                    mobile: [
                        { required: true, message: '请输入手机号', trigger: 'blur' },
                        { pattern: /^1[3|4|5|7|8][0-9]\d{8}$/, message: '请输入正确的手机号', trigger: 'blur' }
                    ],
                    password: [
                        { required: true, message: '请输入密码', trigger: 'blur' },
                        { min: 8, max: 16, message: '长度在 8 到 16 个字符', trigger: ['blur', 'change'] },
                        { validator: validatePass, trigger: 'blur' }
                    ],
                    password_confirmation: [
                        { required: true, message: '请输入确认密码', trigger: 'blur' },
                        { min: 8, max: 16, message: '长度在 8 到 16 个字符', trigger: ['blur', 'change'] },
                        { validator: validatePass2, trigger: 'blur' }
                    ]
                }
            };
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    create(this.userForm).then(response => {console.log(response);
                        if (response.data.msg === 'success'){
                            this.$message({
                                type: 'success',
                                message: '新增成功!'
                            });
                            this.resetForm('userForm');
                        }
                    });
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
            goBack () {
                window.history.length > 1
                    ? this.$router.go(-1)
                    : this.$router.push('/')
            }
        }
    }
</script>

<style scoped>
    .el-form {
        width: 400px;
    }
    .el-page-header {
        display: flex;
        line-height: 24px;
    }

    .el-page-header__left {
        display: flex;
        cursor: pointer;
        margin-right: 40px;
        position: relative;
    }
    .el-page-header__left .el-icon-back {
        font-size: 18px;
        margin-right: 6px;
        align-self: center;
    }
    .el-page-header__title {
        font-size: 14px;
        font-weight: 500;
    }
    .el-page-header__left:after {
        content: "";
        position: absolute;
        width: 1px;
        height: 16px;
        right: -20px;
        top: 50%;
        transform: translateY(-50%);
        background-color: #dcdfe6;
    }
    .el-page-header__content {
        font-size: 18px;
        color: #303133;
    }
    .text {
        font-size: 14px;
    }

    .item {
        margin-bottom: 18px;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }

    .box-card {
        width: 100%;
    }
</style>