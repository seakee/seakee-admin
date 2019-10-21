<template>
    <div class="app-main" :style="{ 'min-height': height + 'px' }">
        <router-view/>
    </div>
</template>

<script>
    export default {
        name: "app-main",
        data(){
          return {
              height : 0
          }
        },
        created() {
            window.addEventListener('resize', this.getHeight);
            this.getHeight();
        },
        methods: {
            getHeight(){
                this.height = window.innerHeight - 140;
            }

        },
        destroyed(){
            window.removeEventListener('resize', this.getHeight)
        }

    }
</script>

<style rel="stylesheet/scss" lang="scss">
    .app-main {
        margin: 20px;
    }

    .pagination-container {
        padding: 20px 0;
    }
    .el-page-header {
        display: flex;
        line-height: 24px;
    }

    .el-page-header__left {
        display: flex;
        cursor: pointer;
        margin-right: 40px;
        position: relative;
    }

    .el-page-header__left .el-icon-back {
        font-size: 18px;
        margin-right: 6px;
        align-self: center;
    }

    .el-page-header__title {
        font-size: 14px;
        font-weight: 500;
    }

    .el-page-header__left:after {
        content: "";
        position: absolute;
        width: 1px;
        height: 16px;
        right: -20px;
        top: 50%;
        transform: translateY(-50%);
        background-color: #dcdfe6;
    }

    .el-page-header__content {
        font-size: 18px;
        color: #303133;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }

    .box-card {
        width: 100%;
    }
</style>
