<template>
    <div class="app-container">
        <el-row :gutter="10">
            <el-col :span="8">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>服务器信息</span>
                    </div>
                    <el-table :data="serverData" style="width: 100%" :show-header="false">
                        <el-table-column prop="key"></el-table-column>
                        <el-table-column prop="value"></el-table-column>
                    </el-table>
                </el-card>
            </el-col>
            <el-col :span="8">
                <el-card class="box-card">
                    <div slot="header" class="clearfix">
                        <span>系统信息</span>
                    </div>
                    <el-table :data="systemData" style="width: 100%" :show-header="false">
                        <el-table-column prop="key"></el-table-column>
                        <el-table-column prop="value"></el-table-column>
                    </el-table>
                </el-card>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import {getServer, getSystem} from "@/api/dashboard";

    export default {
        name: "index",
        data() {
            return {
                serverData: [],
                systemData: []
            }
        },
        created() {
            this.fetchData()
        },
        methods: {
            //拉取列表数据
            fetchData() {
                this.listLoading = true;
                getServer().then(response => {
                    this.serverData = response.data.data;
                });
                getSystem().then(response => {
                    this.systemData = response.data.data;
                })
            }
        }
    }
</script>

<style scoped>
    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }
    .clearfix:after {
        clear: both
    }
</style>
