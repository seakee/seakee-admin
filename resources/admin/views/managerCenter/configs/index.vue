<template>
    <div class="app-container">
        <el-tabs type="border-card">
            <el-tab-pane label="基础配置">
                <el-form :label-position="labelPosition" :model="baseForm" ref="baseForm" label-width="100px"
                         status-icon>
                    <el-form-item label="应用名称" prop="admin.name">
                        <el-input v-model="baseForm.admin.name"></el-input>
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
                    <el-form-item label="缓存开关" prop="admin.cache.enable">
                        <el-switch
                            v-model="cacheForm.admin.cache.enable"
                            :active-value=true
                            :inactive-value=false
                            active-color="#13ce66"
                            inactive-color="#ff4949"
                            active-text="开启"
                            inactive-text="关闭"
                        >
                        </el-switch>
                    </el-form-item>
                    <el-form-item label="缓存时间" prop="admin.cache.ttl">
                        <el-input v-model="cacheForm.admin.cache.ttl">
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
                    <el-form-item label="CDN开关" prop="admin.cdn.enable">
                        <el-switch
                            v-model="cdnForm.admin.cdn.enable"
                            :active-value=true
                            :inactive-value=false
                            active-color="#13ce66"
                            inactive-color="#ff4949"
                            active-text="开启"
                            inactive-text="关闭"
                        >
                        </el-switch>
                    </el-form-item>
                    <el-divider content-position="left">CSS</el-divider>
                    <el-form-item label="Element" prop="admin.cdn.css.elementui">
                        <el-input v-model="cdnForm.admin.cdn.css.elementui"></el-input>
                    </el-form-item>
                    <el-form-item label="Fontawesome" prop="admin.cdn.css.fontawesome">
                        <el-input v-model="cdnForm.admin.cdn.css.fontawesome"></el-input>
                    </el-form-item>
                    <el-divider content-position="left">JS</el-divider>
                    <el-form-item label="Vue" prop="admin.cdn.js.vue">
                        <el-input v-model="cdnForm.admin.cdn.js.vue"></el-input>
                    </el-form-item>
                    <el-form-item label="Element" prop="admin.cdn.js.elementui">
                        <el-input v-model="cdnForm.admin.cdn.js.elementui"></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="updateCdn()">立即更新</el-button>
                        <el-button @click="resetForm('cdnForm')">重置</el-button>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    import {update} from "@/api/config";

    export default {
        name   : 'index',
        data() {
            return {
                labelPosition: 'left',
                baseForm     : {
                    admin: {
                        name : appConfig.name
                    }
                },
                cacheForm    : {
                    admin: {
                        cache: {
                            enable: appConfig.cache.enable,
                            ttl   : appConfig.cache.ttl
                        }
                    }
                },
                cdnForm      : {
                    admin: {
                        cdn  : {
                            enable: appConfig.cdn.enable,
                            css   : {
                                elementui  : appConfig.cdn.css.elementui,
                                fontawesome: appConfig.cdn.css.fontawesome
                            },
                            js    : {
                                vue      : appConfig.cdn.js.vue,
                                elementui: appConfig.cdn.js.elementui
                            }
                        }
                    }
                }
            };
        },
        methods: {
            submitForm(formName) {
                let data = {};
                if (formName === 'baseForm') {
                    data = this.baseForm;
                }
                if (formName === 'cacheForm') {
                    data = this.cacheForm;
                }
                if (formName === 'cdnForm') {
                    data = this.cdnForm;
                }
                update(data).then(response => {
                    if (response.data.message === 'success') {
                        this.$message({
                            type   : 'success',
                            message: '更新成功!'
                        });
                    }
                });
            },
            updateCdn() {
                this.$confirm('此操作将会开启维护模式，系统将在1分钟之内开始重新构建项目，确定要继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText : '取消',
                    type             : 'warning'
                }).then(() => {
                    this.submitForm('cdnForm')
                }).catch(() => {
                    this.$message({
                        type   : 'info',
                        message: '已取消'
                    });
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            }
        }
    }
</script>

<style scoped>
    .el-divider--horizontal {
        display: block;
        height: 1px;
        width: 400px;
        margin: 24px 0;
    }

    .el-input {
        width: 300px;
    }
</style>
