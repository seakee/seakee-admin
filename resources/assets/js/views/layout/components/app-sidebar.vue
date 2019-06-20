<template>
    <aside class="el-aside">
        <el-menu default-active="" class="el-menu-vertical" unique-opened>
            <template v-for="(menu, parentIndex) in this.$store.getters.profile.menus">
                <el-submenu :index="parentIndex + ''">
                    <template slot="title">
                        <i :class="'fas ' + menu.icon"></i>
                        <span slot="title">{{ menu.name }}</span>
                    </template>
                    <template v-if="menu.nodes !== 'undefined'">
                        <template v-for="(m, index) in menu.nodes">
                            <el-menu-item :index="generateIndex(parentIndex,index) + ''" style="padding-left: 30px"><i :class="'fas ' + m.icon"></i>{{ m.name }}</el-menu-item>
                        </template>
                    </template>
                </el-submenu>
            </template>
        </el-menu>
    </aside>
</template>

<script>
    export default {
        name   : "app-sidebar",
        methods: {
            generateIndex: function (parentIndex,index) {
                return parentIndex+ "_" + index
            }
        }
    }
</script>

<style rel="stylesheet/scss" lang="scss">
    .el-menu-item i {
        width: 20px;
    }

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

    .el-menu {
        border-right: none;
    }

    .el-menu-vertical:not(.el-menu--collapse) {
        min-width: 200px;
        min-height: 100%;
    }

    .leftSlideHide {
        min-width: 64px;
    }
</style>