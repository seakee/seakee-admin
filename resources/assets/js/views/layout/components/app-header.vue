<template>
    <el-header>
        <div class="header-title">
            <h4>HaHaHaHaHaHa</h4>
        </div>
        <div class="header-nav">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ path: '/' }">首页</el-breadcrumb-item>
                <el-breadcrumb-item><a href="/">活动管理</a></el-breadcrumb-item>
                <el-breadcrumb-item>活动列表</el-breadcrumb-item>
                <el-breadcrumb-item>活动详情</el-breadcrumb-item>
            </el-breadcrumb>
        </div>
    </el-header>
</template>

<script>
    export default {
        name: "app-header"
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
        text-align: center;
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