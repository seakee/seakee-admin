<template>
    <div class="app-container">
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <div class="el-page-header">
                    <div class="el-page-header__left" @click="goBack"><i class="el-icon-back"></i>
                        <div class="el-page-header__title">返回</div>
                    </div>
                    <div class="el-page-header__content">新增权限</div>
                </div>
            </div>
            <el-form :model="permissionForm" :rules="rules" ref="permissionForm" label-width="100px" status-icon>
                <el-form-item label="权限标识" prop="name">
                    <el-input v-model="permissionForm.name"></el-input>
                </el-form-item>
                <el-form-item label="权限名称" prop="display_name">
                    <el-input v-model="permissionForm.display_name"></el-input>
                </el-form-item>
                <el-form-item label="权限描述" prop="description">
                    <el-input v-model="permissionForm.description"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitForm('permissionForm')">立即创建</el-button>
                    <el-button @click="resetForm('permissionForm')">重置</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
    import { create } from "@/api/permission";

    export default {
        name:'create',
        data() {
            return {
                permissionForm: {
                    name        : '',
                    display_name: '',
                    description : ''
                },
                rules: {
                    name: [
                        { required: true, message: '请输入权限标识', trigger: 'blur'}
                    ],
                    display_name: [
                        { required: true, message: '权限名称', trigger: 'blur' }
                    ],
                    description: [
                        { required: true, message: '权限描述', trigger: 'blur' }
                    ]
                }
            };
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    create(this.permissionForm).then(response => {
                        if (response.data.msg === 'success'){
                            this.$message({
                                type: 'success',
                                message: '新增成功!'
                            });
                            this.resetForm('permissionForm');
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
    .text {
        font-size: 14px;
    }

    .item {
        margin-bottom: 18px;
    }
</style>