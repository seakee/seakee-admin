<template>
    <div class="app-container">
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <div class="el-page-header">
                    <div class="el-page-header__left" @click="goBack"><i class="el-icon-back"></i>
                        <div class="el-page-header__title">返回</div>
                    </div>
                    <div class="el-page-header__content">新增角色</div>
                </div>
            </div>
            <el-form :model="roleForm" :rules="rules" ref="roleForm" label-width="100px" status-icon>
                <el-form-item label="角色标识" prop="name">
                    <el-input v-model="roleForm.name"></el-input>
                </el-form-item>
                <el-form-item label="角色名称" prop="display_name">
                    <el-input v-model="roleForm.display_name"></el-input>
                </el-form-item>
                <el-form-item label="角色描述" prop="description">
                    <el-input v-model="roleForm.description"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitForm('roleForm')">立即创建</el-button>
                    <el-button @click="resetForm('roleForm')">重置</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
    import { create } from "@/api/role";

    export default {
        name:'create',
        data() {
            return {
                roleForm: {
                    name        : '',
                    display_name: '',
                    description : ''
                },
                rules: {
                    name: [
                        { required: true, message: '请输入角色标识', trigger: 'blur'}
                    ],
                    display_name: [
                        { required: true, message: '角色名称', trigger: 'blur' }
                    ],
                    description: [
                        { required: true, message: '角色描述', trigger: 'blur' }
                    ]
                }
            };
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    create(this.roleForm).then(response => {
                        if (response.data.message === 'success'){
                            this.$message({
                                type: 'success',
                                message: '新增成功!'
                            });
                            this.resetForm('roleForm');
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
