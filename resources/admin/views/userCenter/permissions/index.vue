<template>
    <div class="app-container">
        <el-form :inline="true" :model="permissionForm">
            <el-form-item>
                <el-input placeholder="请输入权限标识" v-model="permissionForm.name" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="请输入权限名称" v-model="permissionForm.display_name" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="fetchData"><i class="fas fa-search"></i>查询</el-button>
            </el-form-item>
            <el-form-item>
                <router-link to="/userCenter/permissions/create">
                    <el-button type="primary"><i class="fas fa-user-plus"></i>新增权限</el-button>
                </router-link>
            </el-form-item>
        </el-form>
        <el-table v-bind="list" border style="width: 100%" stripe element-loading-text="Loading">
            <el-table-column prop="id" label="ID" width="50" align="center">
            </el-table-column>
            <el-table-column prop="name" label="权限标识" align="center">
            </el-table-column>
            <el-table-column prop="display_name" label="权限名称" align="center">
            </el-table-column>
            <el-table-column prop="description" label="权限描述" align="center">
            </el-table-column>
            <el-table-column prop="created_at" label="创建时间" align="center">
            </el-table-column>
            <el-table-column prop="" label="操作" align="center" width="230">
                <template slot-scope="scope">
                    <el-button type="success" size="mini" @click="editPermission(scope.row.id)">编辑</el-button>
                    <el-button type="danger" size="mini" @click="deletePermission(scope.row.id)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="pagination-container">
            <el-pagination
                    background
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="permissionForm.current_page"
                    :page-sizes="[10, 20, 50]"
                    :page-size="permissionForm.per_page"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="permissionForm.total">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    import {deletePermission, getList} from "@/api/permission";

    export default {
        data() {
            return {
                list       : null,
                listLoading: true,
                permissionForm   : {
                    name         : '',
                    display_name : '',
                    page         : 1,
                    total        : 0,
                    per_page     : 10,
                    current_page : 1
                }
            }
        },
        mounted() {
            this.fetchData()
        },
        methods: {
            //拉取列表数据
            fetchData() {
                this.listLoading = true;
                getList(this.permissionForm).then(response => {
                    this.list                    = response.data;
                    this.permissionForm.total    = response.data.total;
                    this.permissionForm.per_page = response.data.per_page;
                    this.listLoading             = false
                })
            },
            handleSizeChange   : function (pageSize) { // 每页条数切换
                this.permissionForm.per_page = pageSize;
                this.fetchData(this.permissionForm);
            },
            handleCurrentChange: function (currentPage) {//页码切换
                this.permissionForm.current_page = currentPage;
                this.permissionForm.page         = currentPage;
                this.fetchData(this.permissionForm);
            },
            deletePermission(id) {
                this.$confirm('此操作将永久删除该权限, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(() => {
                    deletePermission(id).then(response => {
                        if (this.list.data.length === 1 && this.permissionForm.page !== 1) {
                            this.permissionForm.page -= 1;
                        }
                        this.fetchData(this.permissionForm);
                        if (response.data.message === 'success'){
                            this.$message({
                                type: 'success',
                                message: '删除成功!',
                                center : true
                            });
                        }
                    });
                }).catch(() => {
                    this.$message({
                        type   : 'info',
                        message: '已取消删除'
                    });
                });
            },
            editPermission(id) {
                this.$router.push('/userCenter/permissions/edit/' + id)
            }
        }
    }
</script>

<style>

</style>
