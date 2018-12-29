<template>
    <el-header>
        <div class="header-title">
            <h4>HaHaHaHaHaHa</h4>
        </div>
        <div class="header-nav">
            <h4><i class="el-icon-setting"></i></h4>
        </div>
    </el-header>
</template>

<script>
    import ElRow from "element-ui/packages/row/src/row";

    export default {
        components: {ElRow},
        name      : "app-header",
        data() {
            return {
                activeIndex: '1',
                activeIndex2: '1'
            };
        },
        methods   : {
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
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
    .header-title{
        min-height:100%;
        min-width: 200px;
        background: rgba(0, 0, 0, 0.05);
        position: absolute;
        text-align: center;
    }
    .header-nav{
        padding-left: 200px;
        margin: 20px 20px;
    }
</style>