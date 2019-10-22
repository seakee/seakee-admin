<template>
    <el-header>
        <div class="header-title">
            <router-link to="/">
                <h3>{{ title }}</h3>
            </router-link>
        </div>
        <div class="header-nav">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item v-for="(item) in breadcrumbList" :key="item.path">
                    {{ item.meta.title }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>
        <div class="header-avatar">
            <div class="name"><span>Hi, {{ profile.user_name }}</span></div>
            <el-dropdown>
                  <span class="el-dropdown-link">
                    <avatar :username="profile.user_name" :src="userForm.avatar" :size="40" backgroundColor="#c0c4cc"></avatar>
                  </span>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item icon="el-icon-user" @click.native="profileDrawer = true">我的</el-dropdown-item>
                    <el-dropdown-item icon="el-icon-setting" @click.native="settingDrawer = true">设置</el-dropdown-item>
                    <el-dropdown-item icon="el-icon-switch-button" divided @click.native="logout">注销</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
        <el-drawer :visible.sync="profileDrawer" :direction="direction" size="320px" :show-close="false">
            <div class="profile-header">
                <avatar :username="profile.user_name"
                        :src="userForm.avatar"
                        :size="150"
                        backgroundColor="#c0c4cc"
                        :customStyle="{margin: '0 auto'}"></avatar>
            </div>
            <div class="profile-content" :style="{ 'height': profileHeight + 'px' }">
                <div class="name">
                    <h3>{{ profile.user_name }}</h3>
                </div>
                <div class="roles">
                    <template v-for="(item) in profile.roles">
                        {{ item }}
                    </template>
                </div>
                <div class="info">
                    <el-table :data="profileData" style="width: 100%" :show-header="false">
                        <el-table-column prop="key" align="center"></el-table-column>
                        <el-table-column prop="value"></el-table-column>
                    </el-table>
                </div>
            </div>
            <div class="profile-footer">
                <button type="button" class="el-button el-button--primary" @click="settingDrawer = true">
                    <i class="el-icon-setting"></i><span>设置</span>
                </button>
            </div>
        </el-drawer>
        <el-drawer title="设置" :visible.sync="settingDrawer" size="320px" :direction="direction">
            <div class="profile-header">
                <el-upload
                    class="avatar-uploader"
                    action=""
                    :http-request="uploadAvatar"
                    :show-file-list="false"
                    :before-upload="beforeAvatarUpload">
                    <img v-if="userForm.avatar" :src="userForm.avatar" class="avatar">
                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                </el-upload>
            </div>
            <div class="profile-content">
                <div class="name">
                    <h3>{{ profile.user_name }}</h3>
                </div>
                <div class="roles">
                    <template v-for="(item) in profile.roles">
                        {{ item }}
                    </template>
                </div>
                <div class="info">
                    <el-form :model="userForm" :rules="rules" ref="userForm" label-width="80px">
                        <el-form-item label="邮箱" prop="email">
                            <el-input v-model="userForm.email"></el-input>
                        </el-form-item>
                        <el-form-item label="手机号" prop="mobile">
                            <el-input v-model="userForm.mobile"></el-input>
                        </el-form-item>
                        <el-form-item label="登录密码" prop="password_old">
                            <el-input type="password" v-model="userForm.password_old"></el-input>
                        </el-form-item>
                        <el-form-item label="新密码" prop="password">
                            <el-input type="password" v-model="userForm.password"></el-input>
                        </el-form-item>
                        <el-form-item label="确认密码" prop="password_confirmation">
                            <el-input type="password" v-model="userForm.password_confirmation"></el-input>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
            <div class="profile-footer-edit">
                <el-button @click="resetForm('userForm')">重置</el-button>
                <el-button type="primary" @click="submitForm('userForm')">立即更新</el-button>
            </div>
        </el-drawer>
    </el-header>
</template>

<script>
    import Avatar from 'vue-avatar';
    import { updateProfile } from "@/api/auth";
    import {avatar} from '@/api/common';

    export default {
        name      : "app-header",
        components: {
            Avatar
        },
        data() {
            let validatePass = (rule, value, callback) => {
                if (this.userForm.password !== this.userForm.password_confirmation) {
                    callback(new Error('两次输入密码不一致!'));
                } else {
                    callback();
                }
            };
            return {
                userForm: {
                    email                : this.$store.getters.profile.email,
                    mobile               : this.$store.getters.profile.mobile,
                    avatar               : this.$store.getters.profile.avatar,
                    password             : '',
                    password_confirmation: '',
                    password_old         : '',
                },
                profileDrawer : false,
                settingDrawer : false,
                direction     : 'rtl',
                profile       : this.$store.getters.profile,
                breadcrumbList: null,
                title         : appConfig.name,
                profileHeight : 0,
                profileData   : [
                    {
                        key  : '手机号',
                        value: this.$store.getters.profile.mobile
                    }, {
                        key  : '邮箱',
                        value: this.$store.getters.profile.email
                    }
                ],
                rules: {
                    email: [
                        { required: true, message: '请输入邮箱地址', trigger: 'blur' },
                        { type: 'email', message: '请输入正确的邮箱地址', trigger: ['blur', 'change'] }
                    ],
                    mobile: [
                        { required: true, message: '请输入手机号', trigger: 'blur' },
                        { pattern: /^1[3|4|5|7|8][0-9]\d{8}$/, message: '请输入正确的手机号', trigger: ['blur', 'change'] }
                    ],
                    password_old: [
                        { required: true, message: '请输入登录密码', trigger: ['blur', 'change'] }
                    ],
                    password: [
                        { min: 8, max: 16, message: '长度在 8 到 16 个字符', trigger: ['blur', 'change'] },
                    ],
                    password_confirmation: [
                        { min: 8, max: 16, message: '长度在 8 到 16 个字符', trigger: ['blur', 'change'] },
                        { validator: validatePass, trigger: 'blur' }
                    ],
                }
            }
        },
        watch     : {
            $route() {
                this.getBreadcrumb()
            }
        },
        created() {
            this.getBreadcrumb();
            this.setProfileHeight();
        },
        methods   : {
            getBreadcrumb() {
                let matchedList = this.$route.matched;
                if (matchedList[0].name === 'admin') {
                    this.breadcrumbList = [];
                } else {
                    this.breadcrumbList = matchedList;
                }
            },
            logout() {
                this.$store.dispatch('logout').then(() => {
                    this.$router.push({path: '/login'});
                }).catch(() => {

                })
            },
            setProfileHeight() {
                this.profileHeight = window.innerHeight - 250;
            },
            destroyed() {
                window.removeEventListener('resize', this.setProfileHeight)
            },
            beforeAvatarUpload(file) {
                let isLt2M = file.size / 1024 / 1024 < 2;

                if (!isLt2M) {
                    this.$message.error('上传头像图片大小不能超过 2MB!');
                }
                return isLt2M;
            },
            uploadAvatar (file){
                avatar(file).then(response => {
                    if (response.data.message === 'success') {
                        this.userForm.avatar = response.data.data;
                        this.$message({
                            type   : 'success',
                            message: '上传成功!'
                        });
                    }
                });
            },
            submitForm(formName) {
                this.$refs[formName].validate((valid) => {
                    let userForm = null;
                    if (this.userForm.password === '' && this.userForm.password_confirmation === '') {
                        userForm = {
                            email        : this.userForm.email,
                            mobile       : this.userForm.mobile,
                            avatar       : this.userForm.avatar,
                            password_old : this.userForm.password_old,
                        }
                    } else {
                        userForm = this.userForm
                    }

                    updateProfile(userForm).then(response => {
                        if (response.data.message === 'success') {
                            this.$message({
                                type   : 'success',
                                message: '更新成功!'
                            });
                        }
                    });
                });
            },
            resetForm(formName) {
                this.$refs[formName].resetFields();
            },
        }
    }
</script>

<style rel="stylesheet/scss" lang="scss">
    .el-header {
        padding: 0 0;
        position: fixed;
        min-width: 100%;
        color: #FFFFFF;
        background-color: #1e88e5 !important;
        z-index: 1003;
    }

    .header-title {
        min-height: 100%;
        min-width: 200px;
        background: #4b545c;
        position: absolute;
        display: flex;
    }

    .header-title a, .header-title a h3 {
        margin: auto;
    }

    .header-nav {
        padding-left: 200px;
        margin: 25px 20px;
        position: absolute;
    }

    .el-breadcrumb__separator,
    .el-breadcrumb__inner a,
    .el-breadcrumb__inner.is-link,
    .el-breadcrumb__inner,
    .el-breadcrumb__inner a:hover,
    .el-breadcrumb__inner.is-link:hover,
    .el-breadcrumb__item:last-child .el-breadcrumb__inner,
    .el-breadcrumb__item:last-child .el-breadcrumb__inner:hover {
        color: #FFFFFF;
    }

    .el-dropdown-link {
        cursor: pointer;
        color: #409EFF;
    }

    .el-icon-arrow-down {
        font-size: 12px;
    }

    .el-drawer {
        background: #f4f6f9 !important;
    }

    .header-avatar {
        float: right;
        padding: 10px 20px 10px 10px;
    }

    .header-avatar .name {
        float: left;
        margin: 10px;
    }

    .header-avatar span {
        vertical-align: middle;
    }

    .el-drawer__header {
        background: #343a40 !important;
        margin-bottom: 0;
    }

    .profile-header {
        padding-top: 20px;
        background: #343a40 !important;
        padding-bottom: 20px;
    }

    .profile-content .name h3 {
        color: #FFFFFF;
        margin-top: 0;
        padding-bottom: 10px;
        margin-bottom: 0;
    }

    .profile-content .roles {
        padding-bottom: 23px;
        color: #6c757d !important;
    }

    .profile-content .name, .profile-content .roles {
        text-align: center;
        background: #343a40 !important;
    }

    .profile-footer button {
        width: 100%;
        border-radius: 0;
    }

    .avatar-uploader .el-upload {
        border: 1px dashed #d9d9d9;
        display: flex;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        font: 60px / 150px Helvetica, Arial, sans-serif;
        align-items: center;
        justify-content: center;
        text-align: center;
        background-color: rgb(192, 196, 204);
        color: rgb(255, 255, 255);
        margin: 0 auto;
    }
    .avatar-uploader .el-upload:hover {
        border-color: #409EFF;
    }
    .avatar-uploader-icon {
        font-size: 28px;
        color: #8c939d;
        width: 178px;
        height: 178px;
        line-height: 178px;
        text-align: center;
    }
    .avatar {
        width: 150px;
        height: 150px;
        display: block;
        border-radius: 50%;
    }
    .info form {
        margin: 20px 30px;
    }
    .profile-footer-edit {
        align-items: center;
        text-align: center;
        button {
            width: 40%;
        }
    }
</style>
