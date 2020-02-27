<template>
    <div class="app-container">
        <el-form :inline="true" :model="roleForm">
            <el-form-item>
                <el-input placeholder="请输入角色标识" v-model="roleForm.name" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-input placeholder="请输入角色名称" v-model="roleForm.display_name" clearable>
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="fetchData"><i class="fas fa-search"></i>查询</el-button>
            </el-form-item>
            <el-form-item>
                <router-link to="/userCenter/roles/create">
                    <el-button type="primary"><i class="fas fa-user-plus"></i>新增角色</el-button>
                </router-link>
            </el-form-item>
        </el-form>
        <el-table v-bind="list" border style="width: 100%" stripe element-loading-text="Loading">
            <el-table-column prop="id" label="ID" width="50" align="center">
            </el-table-column>
            <el-table-column prop="name" label="角色标识" align="center">
            </el-table-column>
            <el-table-column prop="display_name" label="角色名称" align="center">
            </el-table-column>
            <el-table-column prop="description" label="角色描述" align="center">
            </el-table-column>
            <el-table-column prop="created_at" label="创建时间" align="center">
            </el-table-column>
            <el-table-column prop="" label="操作" align="center" width="230">
                <template slot-scope="scope">
                    <el-button type="primary" size="mini" @click="syncPermissions(scope.row.id)">权限</el-button>
                    <el-button type="success" size="mini" @click="editRoles(scope.row.id)">编辑</el-button>
                    <el-button type="danger" size="mini" @click="deleteRole(scope.row.id)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
        <div class="pagination-container">
            <el-pagination
                    background
                    @size-change="handleSizeChange"
                    @current-change="handleCurrentChange"
                    :current-page="roleForm.current_page"
                    :page-sizes="[10, 20, 50]"
                    :page-size="roleForm.per_page"
                    layout="total, sizes, prev, pager, next, jumper"
                    :total="roleForm.total">
            </el-pagination>
        </div>
    </div>
</template>

<script>
    import {getList, deleteRole} from "@/api/role";

    export default {
        data() {
            return {
                list       : null,
                listLoading: true,
                roleForm   : {
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
                getList(this.roleForm).then(response => {
                    this.list              = response.data;
                    this.roleForm.total    = response.data.total;
                    this.roleForm.per_page = response.data.per_page;
                    this.listLoading       = false
                })
            },
            handleSizeChange   : function (pageSize) { // 每页条数切换
                this.roleForm.per_page = pageSize;
                this.fetchData(this.roleForm);
            },
            handleCurrentChange: function (currentPage) {//页码切换
                this.roleForm.current_page = currentPage;
                this.roleForm.page         = currentPage;
                this.fetchData(this.roleForm);
            },
            deleteRole(id) {
                this.$confirm('此操作将永久删除该角色, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(() => {
                    deleteRole(id).then(response => {
                        if (this.list.data.length === 1 && this.roleForm.page !== 1) {
                            this.roleForm.page -= 1;
                        }
                        this.fetchData(this.roleForm);
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
            editRoles(id) {
                this.$router.push('/userCenter/roles/edit/' + id)
            },
            syncPermissions(id) {
                this.$router.push('/userCenter/roles/syncPermissions/' + id)
            }
        }
    }
</script>

<style>

</style>
