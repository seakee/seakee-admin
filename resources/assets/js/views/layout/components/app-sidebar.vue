<template>
    <aside class="el-aside">
        <el-menu default-active="" class="el-menu-vertical">
            <el-submenu index="1">
                <template slot="title">
                    <i class="el-icon-location"></i>
                    <span slot="title">导航一</span>
                </template>
                <el-menu-item-group>
                    <span slot="title">分组一</span>
                    <el-menu-item index="1-1">选项1</el-menu-item>
                    <el-menu-item index="1-2">选项2</el-menu-item>
                </el-menu-item-group>
                <el-menu-item-group title="分组2">
                    <el-menu-item index="1-3">选项3</el-menu-item>
                </el-menu-item-group>
                <el-submenu index="1-4">
                    <span slot="title">选项4</span>
                    <el-menu-item index="1-4-1">选项1</el-menu-item>
                </el-submenu>
            </el-submenu>
            <el-menu-item index="2">
                <i class="el-icon-menu"></i>
                <span slot="title">导航二</span>
            </el-menu-item>
            <el-menu-item index="3" disabled>
                <i class="el-icon-document"></i>
                <span slot="title">导航三</span>
            </el-menu-item>
            <el-menu-item index="4">
                <i class="el-icon-setting"></i>
                <span slot="title">导航四</span>
            </el-menu-item>
        </el-menu>
    </aside>

</template>

<script>
    export default {
        name: "app-sidebar"
    }
</script>

<style rel="stylesheet/scss" lang="scss">
    .el-aside {
        background-color: white;
        height: 100%;
        position: fixed;
        padding-top: 60px;
        z-index: 1002;
        top: 0;
        min-width: 200px;
        border-right: solid 1px #e6e6e6;
    }

    .el-menu{
        border-right: none;
    }

    .el-menu-vertical:not(.el-menu--collapse) {
        min-width: 200px;
        min-height: 100%;
    }
    .leftSlideHide{
        min-width:64px;
    }
</style>