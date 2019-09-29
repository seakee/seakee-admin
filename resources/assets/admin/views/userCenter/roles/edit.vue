<template>
    <div class="app-container">
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <div class="el-page-header">
                    <div class="el-page-header__left" @click="goBack"><i class="el-icon-back"></i>
                        <div class="el-page-header__title">返回</div>
                    </div>
                    <div class="el-page-header__content">编辑角色</div>
                </div>
            </div>
            <el-form :model="roleForm" :rules="rules" ref="roleForm" label-width="100px">
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
                    <el-button type="primary" @click="submitForm('roleForm')">立即更新</el-button>
                    <el-button @click="resetForm('roleForm')">重置</el-button>
                </el-form-item>
            </el-form>
        </el-card>
    </div>
</template>

<script>
    import { getInfo, update } from "@/api/role";

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
        created () {
            let id = this.$route.params && this.$route.params.id;
            this.roleForm.id = id;
            this.fetchData(id)
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    update(this.roleForm.id, this.roleForm).then(response => {
                        if (response.data.message === 'success') {
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
                    this.roleForm.name         = response.data.name;
                    this.roleForm.display_name = response.data.display_name;
                    this.roleForm.description  = response.data.description;
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
