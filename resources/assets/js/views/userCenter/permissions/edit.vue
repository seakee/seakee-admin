<template>
    <div class="app-container">
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <div class="el-page-header">
                    <div class="el-page-header__left" @click="goBack"><i class="el-icon-back"></i>
                        <div class="el-page-header__title">返回</div>
                    </div>
                    <div class="el-page-header__content">编辑权限</div>
                </div>
            </div>
            <el-form :model="permissionForm" :rules="rules" ref="permissionForm" label-width="100px">
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
                    <el-button type="primary" @click="submitForm('permissionForm')">立即更新</el-button>
                    <el-button @click="resetForm('permissionForm')">重置</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
    import { getInfo, update } from "@/api/permission";

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
        created () {
            let id = this.$route.params && this.$route.params.id;
            this.permissionForm.id = id;
            this.fetchData(id)
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    update(this.permissionForm.id, this.permissionForm).then(response => {
                        if (response.data.msg === 'success') {
                            this.$message({
                                type   : 'success',
                                message: '编辑成功!'
                            });
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
                    this.permissionForm.name         = response.data.name;
                    this.permissionForm.display_name = response.data.display_name;
                    this.permissionForm.description  = response.data.description;
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