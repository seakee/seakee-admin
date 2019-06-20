<template>
    <div class="app-container">
        <el-form :inline="true" :model="userForm">
            <el-form-item>
                <el-input placeholder="请输入用户名" v-model="userForm.user_name" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="请输入E-mail" v-model="userForm.email" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="请输入手机号" v-model="userForm.mobile" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit"><i class="fas fa-search"></i>查询</el-button>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="onSubmit"><i class="fas fa-user-plus"></i>新增用户</el-button>
            </el-form-item>
        </el-form>
        <el-table v-bind="list" border style="width: 100%" stripe element-loading-text="Loading">
            <el-table-column prop="id" label="ID" width="50" align="center">
            </el-table-column>
            <el-table-column prop="user_name" label="用户名" align="center">
            </el-table-column>
            <el-table-column prop="email" label="E-mail" align="center">
            </el-table-column>
            <el-table-column prop="mobile" label="手机号" align="center">
            </el-table-column>
            <el-table-column prop="created_at" label="注册时间" align="center">
            </el-table-column>
            <el-table-column label="状态" align="center">
                <template slot-scope="scope">
                    <el-switch
                            v-model="scope.row.status"
                            :active-value="1"
                            inactive-value="0"
                            active-color="#13ce66"
                            inactive-color="#ff4949"
                            active-text="启用"
                            inactive-text="禁用"
                            @change="changeStatus(scope.row.id, scope.row.status)"
                    >
                    </el-switch>
                </template>
            </el-table-column>
            <el-table-column prop="" label="操作" align="center" width="230">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini">角色</el-button>
                    <el-button type="success" size="mini">编辑</el-button>
                    <el-button type="danger" size="mini">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    import {getList, update} from "@/api/user";

    export default {
        filters: {
            statusFilter(status) {
                const statusMap = {
                    1: '已启用',
                    0: '已禁用'
                };
                return statusMap[status]
            }
        },
        data() {
            return {
                list       : null,
                listLoading: true,
                userForm   : {
                    user_name: '',
                    email    : '',
                    mobile   : ''
                }
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            //拉取列表数据
            fetchData() {
                this.listLoading = true;
                getList().then(response => {
                    this.list        = response.data;
                    this.listLoading = false
                })
            },
            //修改用户状态
            changeStatus(id, status) {
                update(id, {'status': status}).then(response => {
                    this.$message({
                        message: '修改成功',
                        type   : 'success',
                        center : true
                    });
                })
            }
        }
    }
</script>

<style>

</style>