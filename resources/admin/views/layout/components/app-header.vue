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
            <span>Hi, {{ profile.user_name }}</span>
            <el-dropdown>
                  <span class="el-dropdown-link">
                    <avatar :username="profile.user_name" :size="40" backgroundColor="#c0c4cc"></avatar>
                  </span>
                <el-dropdown-menu slot="dropdown">
                    <el-dropdown-item icon="el-icon-user" @click.native="profileDrawer = true">我的</el-dropdown-item>
                    <el-dropdown-item icon="el-icon-setting" @click.native="settingDrawer = true">设置</el-dropdown-item>
                    <el-dropdown-item icon="el-icon-switch-button" divided @click.native="logout">注销</el-dropdown-item>
                </el-dropdown-menu>
            </el-dropdown>
        </div>
        <el-drawer title="我的" :visible.sync="profileDrawer" :direction="direction">
            <avatar :username="profile.user_name" :size="150" backgroundColor="#c0c4cc"
                    :customStyle="{margin: '0 auto'}"></avatar>
            <div class="profile">
                <div class="name">
                    <h3>{{ profile.user_name }}</h3>
                </div>
                <div class="roles">
                    <template v-for="(item) in profile.roles">
                        {{ item }}
                    </template>
                </div>
                <div class="info">

                </div>
            </div>
        </el-drawer>
        <el-drawer title="设置" :visible.sync="settingDrawer" :direction="direction">
            <span>我来啦!</span>
        </el-drawer>
    </el-header>
</template>

<script>
    import Avatar from 'vue-avatar'

    export default {
        name      : "app-header",
        components: {
            Avatar
        },
        data() {
            return {
                profileDrawer : false,
                settingDrawer : false,
                direction     : 'rtl',
                profile       : this.$store.getters.profile,
                breadcrumbList: null,
                title         : appConfig.name
            }
        },
        watch     : {
            $route() {
                this.getBreadcrumb()
            }
        },
        created() {
            this.getBreadcrumb()
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
            handleClose(done) {
                this.$confirm('确认关闭？')
                    .then(_ => {
                        done();
                    })
                    .catch(_ => {
                    });
            }
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

    .el-dropdown {
        margin: 10px 20px 10px 10px;
    }

    .el-dropdown-link {
        cursor: pointer;
        color: #409EFF;
    }

    .el-icon-arrow-down {
        font-size: 12px;
    }

    .header-avatar {
        float: right;
    }

    .header-avatar span {
        vertical-align: middle;
    }

    .profile {
        padding: 20px 20px 0;
    }

    .profile .name h3{
        margin-top: 0;
        margin-bottom: 10px;
    }

    .profile .roles {
        margin-bottom: 23px;
        color: #6c757d !important;
    }

    .profile .name, .profile .roles {
        text-align: center;
    }
</style>
