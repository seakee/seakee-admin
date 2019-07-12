<template>
    <aside class="el-aside">
        <el-menu default-active="" class="el-menu-vertical" unique-opened router>
            <template v-for="(menu, parentIndex) in menus">
                <el-submenu :index="parentIndex + ''">
                    <template slot="title">
                        <i :class="menu.icon"></i>
                        <span slot="title">{{ menu.name }}</span>
                    </template>
                    <template v-if="menu.nodes !== 'undefined'">
                        <template v-for="(m) in menu.nodes">
                            <el-menu-item :index="m.path" style="padding-left: 30px">
                                <i :class="m.icon"></i>{{ m.name }}
                            </el-menu-item>
                        </template>
                    </template>
                </el-submenu>
            </template>
        </el-menu>
    </aside>
</template>

<script>
    export default {
        name: "app-sidebar",
        data() {
            return {
                menus: this.$store.getters.profile.menus
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