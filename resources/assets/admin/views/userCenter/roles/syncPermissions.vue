<template>
    <div class="app-container">
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <div class="el-page-header">
                    <div class="el-page-header__left" @click="goBack"><i class="el-icon-back"></i>
                        <div class="el-page-header__title">返回</div>
                    </div>
                    <div class="el-page-header__content">角色授权</div>
                </div>
            </div>
            <el-table
                    ref="permissionsTable"
                    v-bind="permissionsList"
                    style="width: 50%"
                    stripe
                    @selection-change="handleSelectionChange">
                <el-table-column
                        prop="id"
                        label="ID"
                        width="50"
                        align="center">
                </el-table-column>
                <el-table-column
                        prop="name"
                        label="权限标识"
                        width="120"
                        align="center">
                </el-table-column>
                <el-table-column
                        prop="display_name"
                        label="权限名称"
                        width="120"
                        align="center">
                </el-table-column>
                <el-table-column
                        prop="description"
                        label="权限描述"
                        align="center">
                </el-table-column>
                <el-table-column
                        type="selection"
                        width="55">
                </el-table-column>
            </el-table>
            <div style="margin-top: 20px;margin-left: 40%">
                <el-button type="primary" @click="syncPermissions()">授权角色</el-button>
            </div>
        </el-card>
    </div>
</template>

<script>
    import {getPermissions, syncPermissions} from "@/api/role";
    import {getList}                         from "@/api/permission";

    export default {
        name   : "sync-roles",
        data() {
            return {
                permissions      : null,
                permissionsList  : null,
                multipleSelection: [],
                id               : 0
            }
        },
        created() {
            this.id = this.$route.params && this.$route.params.id;
            this.fetchData(this.id);
        },
        methods: {
            goBack() {
                window.history.length > 1
                    ? this.$router.go(-1)
                    : this.$router.push('/')
            },
            fetchData(id) {
                getPermissions(id).then(response => {
                    this.permissions = response.data;
                    getList({per_page: 100}).then(response => {
                        this.permissionsList = response.data;

                        this.permissionsList.data.forEach((item, index) => {
                            this.permissions.forEach(permission => {
                                if (item.id === permission.id) {
                                    //必须要在$nextTick里面执行，否则toggleRowSelection无效
                                    this.$nextTick(function () {
                                        this.$refs.permissionsTable.toggleRowSelection(this.permissionsList.data[index], true);
                                    });
                                }
                            });
                        });
                    });
                })
            },
            syncPermissions() {
                let permission_ids = '';
                this.multipleSelection.forEach(selection => {
                    permission_ids += selection.id + ',';
                });
                syncPermissions(this.id, {permission_ids: permission_ids}).then(response => {
                    if (response.data.message === 'success') {
                        this.$message({
                            type   : 'success',
                            message: '角色授权成功!'
                        });
                    }
                });
            },
            handleSelectionChange(val) {
                this.multipleSelection = val;
            }
        }
    }
</script>

<style scoped>

</style>
