<template>
    <div class="app-container">
        <el-tabs type="border-card">
            <el-tab-pane label="基础配置">
                <el-form :label-position="labelPosition" :model="baseForm" ref="baseForm" label-width="100px"
                         status-icon>
                    <el-form-item label="应用名称" prop="name">
                        <el-input v-model="baseForm.name"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="submitForm('baseForm')">立即更新</el-button>
                        <el-button @click="resetForm('baseForm')">重置</el-button>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
            <el-tab-pane label="缓存配置">
                <el-form :label-position="labelPosition" :model="cacheForm" ref="cacheForm" label-width="100px"
                         status-icon>
                    <el-form-item label="缓存开关" prop="enable">
                        <el-switch
                            v-model="cacheForm.enable"
                            :active-value="true"
                            inactive-value="false"
                            active-color="#13ce66"
                            inactive-color="#ff4949"
                            active-text="开启"
                            inactive-text="关闭"
                        >
                        </el-switch>
                    </el-form-item>
                    <el-form-item label="缓存时间" prop="ttl">
                        <el-input v-model="cacheForm.ttl">
                            <template slot="append">分钟</template>
                        </el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="submitForm('cacheForm')">立即更新</el-button>
                        <el-button @click="resetForm('cacheForm')">重置</el-button>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
            <el-tab-pane label="CDN配置">
                <el-form :label-position="labelPosition" :model="cdnForm" ref="cdnForm" label-width="100px" status-icon>
                    <el-form-item label="CDN开关" prop="enable">
                        <el-switch
                            v-model="cdnForm.enable"
                            :active-value="true"
                            inactive-value="false"
                            active-color="#13ce66"
                            inactive-color="#ff4949"
                            active-text="开启"
                            inactive-text="关闭"
                        >
                        </el-switch>
                    </el-form-item>
                    <div class="line">
                        <span class="left"></span>
                        <span class="txt">CSS</span>
                        <span class="right"></span>
                    </div>
                    <el-form-item label="Element" prop="css.elementui">
                        <el-input v-model="cdnForm.css.elementui"></el-input>
                    </el-form-item>
                    <el-form-item label="Fontawesome" prop="css.fontawesome">
                        <el-input v-model="cdnForm.css.fontawesome"></el-input>
                    </el-form-item>
                    <div class="line">
                        <span class="left"></span>
                        <span class="txt">JS</span>
                        <span class="right"></span>
                    </div>
                    <el-form-item label="Vue" prop="js.vue">
                        <el-input v-model="cdnForm.js.vue"></el-input>
                    </el-form-item>
                    <el-form-item label="Element" prop="js.elementui">
                        <el-input v-model="cdnForm.js.elementui"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="submitForm('cdnForm')">立即更新</el-button>
                        <el-button @click="resetForm('cdnForm')">重置</el-button>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    import {getList, create} from "@/api/menu";

    export default {
        name   : 'index',
        data() {
            return {
                labelPosition: 'left',
                baseForm     : {
                    name: ''
                },
                cacheForm    : {
                    enable: true,
                    ttl   : 10080
                },
                cdnForm      : {
                    enable: false,
                    css   : {
                        elementui  : '',
                        fontawesome: ''
                    },
                    js    : {
                        vue      : '',
                        elementui: ''
                    }
                }
            };
        },
        created() {
            this.fetchMenuList()
        },
        methods: {
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    create(this.menuForm).then(response => {
                        if (response.data.message === 'success') {
                            this.$message({
                                type   : 'success',
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
            goBack() {
                window.history.length > 1
                    ? this.$router.go(-1)
                    : this.$router.push('/')
            },
            fetchMenuList() {
                getList().then(response => {
                    response.data.unshift(this.list);
                    this.list = response.data;
                })
            },
            getRouterList() {
                let list = this.$router.options.routes;
                list.splice(list.length - 3, list.length - 2, list.length - 1);
                list.pop();
                this.routerList         = list;
                this.dialogTableVisible = true;
            }
        }
    }
</script>

<style scoped>
    .line {
        margin-top: -16px;
        margin-bottom: 20px;
        width: 400px;
    }

    .line .left {
        display: inline-block;
        width: 20px;
        border-top: 1px solid #eee;
    }

    .line .right {
        display: inline-block;
        width: 338px;
        border-top: 1px solid #eee;
    }

    .line .txt {
        color: #686868;
        vertical-align: -4px;
    }

    .el-input {
        width: 300px;
    }
</style>
