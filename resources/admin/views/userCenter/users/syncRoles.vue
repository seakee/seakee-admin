<template>
    <div class="app-container">
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <div class="el-page-header">
                    <div class="el-page-header__left" @click="goBack"><i class="el-icon-back"></i>
                        <div class="el-page-header__title">返回</div>
                    </div>
                    <div class="el-page-header__content">角色分配</div>
                </div>
            </div>
            <el-table
                    ref="rolesTable"
                    v-bind="rolesList"
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
                        label="角色标识"
                        width="120"
                        align="center">
                </el-table-column>
                <el-table-column
                        prop="display_name"
                        label="角色名称"
                        width="120"
                        align="center">
                </el-table-column>
                <el-table-column
                        prop="description"
                        label="角色描述"
                        align="center">
                </el-table-column>
                <el-table-column
                        type="selection"
                        width="55">
                </el-table-column>
            </el-table>
            <div style="margin-top: 20px;margin-left: 40%">
                <el-button type="primary" @click="syncRoles()">分配角色</el-button>
            </div>
        </el-card>
    </div>
</template>

<script>
    import {getRoles, syncRoles} from "@/api/user";
    import {getList}             from "@/api/role";

    export default {
        name   : "sync-roles",
        data() {
            return {
                roles            : null,
                rolesList        : null,
                multipleSelection: [],
                id               : 0
            }
        },
        mounted() {
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
                getRoles(id).then(response => {
                    this.roles = response.data.data;
                    getList({per_page: 100}).then(response => {
                        this.rolesList = response.data;

                        this.rolesList.data.forEach((item, index) => {
                            this.roles.forEach(role => {
                                if (item.id === role.id) {
                                    //必须要在$nextTick里面执行，否则toggleRowSelection无效
                                    this.$nextTick(function () {
                                        this.$refs.rolesTable.toggleRowSelection(this.rolesList.data[index], true);
                                    });
                                }
                            });
                        });
                    });
                })
            },
            syncRoles() {
                let role_ids = '';
                this.multipleSelection.forEach(selection => {
                    role_ids += selection.id + ',';
                });
                syncRoles(this.id, {role_ids: role_ids}).then(response => {
                    if (response.data.message === 'success') {
                        this.$message({
                            type   : 'success',
                            message: '角色分配成功!'
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
