<template>
    <div class="app-container">
        <el-card class="box-card" shadow="never">
            <div slot="header" class="clearfix">
                <div class="el-page-header">
                    <div class="el-page-header__left" @click="goBack"><i class="el-icon-back"></i>
                        <div class="el-page-header__title">返回</div>
                    </div>
                    <div class="el-page-header__content">新增菜单</div>
                </div>
            </div>
            <el-form :model="menuForm" :rules="rules" ref="menuForm" label-width="100px" status-icon>
                <el-form-item label="上级菜单" prop="father_id">
                <el-select v-model="menuForm.father_id" placeholder="请选择上级菜单">
                    <el-option
                            v-for="item in list"
                            :key="item.id"
                            :label="item.name"
                            :value="item.id">
                    </el-option>
                </el-select>
                </el-form-item>
                <el-form-item label="菜单名" prop="name">
                    <el-input v-model="menuForm.name"></el-input>
                </el-form-item>
                <el-form-item label="路由标识" prop="route_name">
                    <el-input v-model="menuForm.route_name"></el-input>
                </el-form-item>
                <el-form-item label="路径" prop="path">
                    <el-input v-model="menuForm.path"></el-input>
                    <a style="color: #409EFF" @click="getRouterList">可用路径</a>
                </el-form-item>
                <el-form-item label="排序" prop="sort">
                    <el-input v-model="menuForm.sort"></el-input>
                </el-form-item>
                <el-form-item label="图标" prop="icon">
                    <el-input v-model="menuForm.icon"></el-input>
                    <span>更多图标样式请参考<a style="color: #409EFF" href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank">fontawesome.com</a></span>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="submitForm('menuForm')">立即创建</el-button>
                    <el-button @click="resetForm('menuForm')">重置</el-button>
                </el-form-item>
            </el-form>
        </el-card>
        <el-dialog title="可用路径" :visible.sync="dialogTableVisible">
            <el-table :data="routerList"
                      border
                      style="width: 100%"
                      element-loading-text="Loading"
                      row-key="name"
                      height="400"
                      :tree-props="{children: 'children'}">
                <el-table-column prop="path" label="Path">
                </el-table-column>
                <el-table-column prop="name" label="Name">
                </el-table-column>
                <el-table-column label="Title" width="100">
                    <template slot-scope="scope">
                        {{ scope.row.meta.title }}
                    </template>
                </el-table-column>
            </el-table>
        </el-dialog>
    </div>
</template>

<script>
    import { getList, create } from "@/api/menu";

    export default {
        name:'create',
        data() {
            return {
                menuForm: {
                    father_id : '',
                    name      : '',
                    route_name: '',
                    path      : '',
                    sort      : 0,
                    icon      : 'far fa-circle'
                },
                routerList: [],
                list: {id: -1, name: '根目录'},
                dialogTableVisible: false,
                rules: {
                    father_id: [
                        { required: true, message: '请选择上级菜单', trigger: 'blur'}
                    ],
                    name: [
                        { required: true, message: '请输入菜单名称', trigger: 'blur' }
                    ],
                    route_name: [
                        { required: true, message: '请输入路由标识', trigger: 'blur' }
                    ],
                    path: [
                        { required: true, message: '请输入路径', trigger: 'blur' }
                    ],
                    icon: [
                        { required: true, message: '请输入图标', trigger: 'blur' }
                    ]
                }
            };
        },
        created() {
            this.fetchMenuList()
        },
        methods: {
            submitForm(formName) {console.log(this.menuForm);
                this.$refs[formName].validate((valid) => {
                    create(this.menuForm).then(response => {
                        if (response.data.msg === 'success'){
                            this.$message({
                                type: 'success',
                                message: '新增成功!'
                            });
                            this.resetForm('menuForm');
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
            fetchMenuList(){
                getList().then(response => {
                    response.data.unshift(this.list);
                    this.list = response.data;
                })
            },
            getRouterList() {
                let list = this.$router.options.routes;
                list.splice(list.length - 3, list.length - 2, list.length - 1);
                list.pop();
                this.routerList = list;
                this.dialogTableVisible = true;
            }
        }
    }
</script>

<style scoped>
    .text {
        font-size: 14px;
    }

    .item {
        margin-bottom: 18px;
    }
    .el-select{
        width: 300px;
    }
    .el-input {
        width: 300px;
    }
</style>