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
                <el-button type="primary" @click="fetchData"><i class="fas fa-search"></i>查询</el-button>
            </el-form-item>
            <el-form-item>
                <router-link to="/userCenter/users/create">
                    <el-button type="primary"><i class="fas fa-user-plus"></i>新增用户</el-button>
                </router-link>
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
                    <el-button type="primary" size="mini" @click="syncRoles(scope.row.id)">角色</el-button>
                    <el-button type="success" size="mini" @click="editUser(scope.row.id)">编辑</el-button>
                    <el-button type="danger" size="mini" @click="deleteUser(scope.row.id)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="pagination-container">
            <el-pagination
                    background
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="userForm.current_page"
                    :page-sizes="[10, 20, 50]"
                    :page-size="userForm.per_page"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="userForm.total">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    import {getList, update, deleteUser} from "@/api/user";

    export default {
        data() {
            return {
                list       : null,
                listLoading: true,
                userForm   : {
                    user_name   : '',
                    email       : '',
                    mobile      : '',
                    page        : 1,
                    total       : 0,
                    per_page    : 10,
                    current_page: 1
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
                getList(this.userForm).then(response => {
                    this.list              = response.data;
                    this.userForm.total    = response.data.total;
                    this.userForm.per_page = response.data.per_page;
                    this.listLoading       = false
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
            },
            handleSizeChange   : function (pageSize) { // 每页条数切换
                this.userForm.per_page = pageSize;
                this.fetchData(this.userForm);
            },
            handleCurrentChange: function (currentPage) {//页码切换
                this.userForm.current_page = currentPage;
                this.userForm.page         = currentPage;
                this.fetchData(this.userForm);
            },
            deleteUser(id) {
                this.$confirm('此操作将永久删除该用户, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(() => {
                    deleteUser(id).then(response => {
                        if (this.list.data.length === 1 && this.userForm.page !== 1) {
                            this.userForm.page -= 1;
                        }
                        this.fetchData(this.userForm);
                        this.$message({
                            type   : 'success',
                            message: '删除成功!'
                        });
                    });
                }).catch(() => {
                    this.$message({
                        type   : 'info',
                        message: '已取消删除'
                    });
                });
            },
            editUser(id) {
                this.$router.push('/userCenter/users/edit/' + id)
            },
            syncRoles(id) {
                this.$router.push('/userCenter/users/syncRoles/' + id)
            }
        }
    }
</script>

<style>

</style>