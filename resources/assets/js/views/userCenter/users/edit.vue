<template>
    <div class="app-container">
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <div class="el-page-header">
                    <div class="el-page-header__left" @click="goBack"><i class="el-icon-back"></i>
                        <div class="el-page-header__title">返回</div>
                    </div>
                    <div class="el-page-header__content">编辑用户</div>
                </div>
            </div>
            <el-form :model="userForm" :rules="rules" ref="userForm" label-width="100px">
                <el-form-item label="用户名" prop="user_name">
                    <el-input v-model="userForm.user_name" disabled></el-input>
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
                    <el-button type="primary" @click="submitForm('userForm')">立即更新</el-button>
                    <el-button @click="resetForm('userForm')">重置</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
    import { getInfo, update } from "@/api/user";

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
                    password_confirmation: '',
                    id                   : 0
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
                        { pattern: /^1[3|4|5|7|8][0-9]\d{8}$/, message: '请输入正确的手机号', trigger: ['blur', 'change'] }
                    ],
                    password: [
                        { min: 8, max: 16, message: '长度在 8 到 16 个字符', trigger: ['blur', 'change'] },
                        { validator: validatePass, trigger: 'blur' }
                    ],
                    password_confirmation: [
                        { min: 8, max: 16, message: '长度在 8 到 16 个字符', trigger: ['blur', 'change'] },
                        { validator: validatePass2, trigger: 'blur' }
                    ]
                }
            };
        },
        created () {
            let id = this.$route.params && this.$route.params.id;
            this.userForm.id = id;
            this.fetchData(id)
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    let userForm = null;
                    if (this.userForm.password === '' && this.userForm.password === '') {
                        userForm = {
                            user_name: this.userForm.user_name,
                            email    : this.userForm.email,
                            mobile   : this.userForm.mobile,
                        }
                    } else {
                        userForm = this.userForm
                    }

                    update(this.userForm.id, userForm).then(response => {
                        if (response.data.msg === 'success') {
                            this.$message({
                                type   : 'success',
                                message: '编辑成功!'
                            });
                            this.goBack();
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
            },
            fetchData(id) {
                getInfo(id).then(response => {
                    this.userForm.user_name = response.data.user_name;
                    this.userForm.email     = response.data.email;
                    this.userForm.mobile    = response.data.mobile;
                });
            }
        }
    }
</script>

<style scoped>
    .el-form {
        width: 400px;
    }
    .text {
        font-size: 14px;
    }

    .item {
        margin-bottom: 18px;
    }
</style>