<template>
    <el-footer height="40px">
        <div class="version">
            <b>Version</b> {{ version }}
        </div>
        <strong>Copyright &copy; {{ date.getFullYear() }} <a
            href="https://github.com/seakee/seakee-admin">SeakeeAdmin</a>.</strong> All rights
        reserved.
    </el-footer>
</template>

<script>
    export default {
        name: "app-footer",
        data() {
            return {
                date   : new Date(),
                version: appConfig.version
            }
        }
    }
</script>

<style rel="stylesheet/scss" lang="scss">
    .version {
        float: right;
    }

    .el-footer {
        left: 200px;
        padding: 10px 15px;
        right: 0;
        bottom: 0;
        border-top: solid 1px #e6e6e6;
        background: #ffffff;
        font-size: 14px;
    }
</style>
