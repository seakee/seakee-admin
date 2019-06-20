<template>
    <div class="app-main">
        <router-view/>
    </div>
</template>

<script>
    export default {
        name: "app-main"
    }
</script>

<style rel="stylesheet/scss" lang="scss">
    .app-main {
        margin-right: auto;
        margin-left: auto;
    }

    .app-container {
        padding: 20px;
    }

    .el-table {
        position: unset;
    }
</style>