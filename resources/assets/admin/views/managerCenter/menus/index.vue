<template>
    <div class="app-container">
        <el-table :data="list"
                  border
                  style="width: 100%"
                  element-loading-text="Loading"
                  row-key="id"
                  default-expand-all
                  :tree-props="{children: 'nodes'}"
                  :row-class-name="fatherRowClass">
            <el-table-column label="菜单名称" width="150">
                <template slot-scope="scope">
                    <i :class="scope.row.icon"></i>{{ scope.row.name }}
                </template>
            </el-table-column>
            <el-table-column prop="path" label="菜单路径">
            </el-table-column>
            <el-table-column prop="sort" label="排序" width="50" align="center">
            </el-table-column>
            <el-table-column prop="updated_at" label="最后修改时间" align="center">
            </el-table-column>
            <el-table-column label="显示状态" align="center">
                <template slot-scope="scope">
                    <el-switch
                            v-model="scope.row.display"
                            :active-value="1"
                            inactive-value="0"
                            active-color="#13ce66"
                            inactive-color="#ff4949"
                            active-text="显示"
                            inactive-text="隐藏"
                            @change="changeStatus(scope.row.id, scope.row.display)"
                    >
                    </el-switch>
                </template>
            </el-table-column>
            <el-table-column prop="" label="操作" align="center" width="230">
                <template slot-scope="scope">
                    <el-button type="success" size="mini" @click="editMenu(scope.row.id)">编辑</el-button>
                    <el-button type="danger" size="mini" @click="deleteMenu(scope.row.id)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    import {getList, update, deleteMenu} from "@/api/menu";

    export default {
        data(){
            return {
                list : []
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
            //修改菜单状态
            changeStatus(id, display) {
                update(id, {'display': display}).then(response => {
                    this.$message({
                        message: '修改成功',
                        type   : 'success',
                        center : true
                    });
                })
            },
            deleteMenu(id) {
                this.$confirm('此操作将永久删除该菜单, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(() => {
                    deleteMenu(id).then(response => {
                        this.fetchData();
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
            editMenu(id) {
                this.$router.push('/managerCenter/menus/edit/' + id)
            },
            fatherRowClass({row, rowIndex}) {
                if (row.nodes !== undefined){
                    return 'father-row';
                }
            }
        }
    }
</script>

<style>
.cell i{
    width: 20px;
}
.el-table .father-row {
    background: rgb(236, 245, 255);
}
</style>