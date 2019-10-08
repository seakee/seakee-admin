<template>
    <el-header>
        <div class="header-title">
            <h3>{{ title }}</h3>
        </div>
        <div class="header-nav">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item v-for="(item) in breadcrumbList" :key="item.path">
                    {{ item.meta.title }}
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>
    </el-header>
</template>

<script>
    export default {
        name: "app-header",
        data(){
            return {
                breadcrumbList: null,
                title: appConfig.name
            }
        },
        watch: {
            $route() {
                this.getBreadcrumb()
            }
        },
        created() {
            this.getBreadcrumb()
        },
        methods: {
            getBreadcrumb() {
                let matchedList = this.$route.matched;
                if (matchedList[0].name === 'admin'){
                    this.breadcrumbList = [];
                } else {
                    this.breadcrumbList = matchedList;
                }
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
        background: rgba(0, 0, 0, 0.05);
        position: absolute;
        display: flex;
    }

    .header-title h3 {
        margin: auto;
    }

    .header-nav {
        padding-left: 200px;
        margin: 25px 20px;
    }

    .el-breadcrumb__separator,
    .el-breadcrumb__inner a,
    .el-breadcrumb__inner.is-link,
    .el-breadcrumb__inner,
    .el-breadcrumb__inner a:hover,
    .el-breadcrumb__inner.is-link:hover,
    .el-breadcrumb__item:last-child .el-breadcrumb__inner,
    .el-breadcrumb__item:last-child .el-breadcrumb__inner:hover{
        color: #FFFFFF;
    }
</style>
