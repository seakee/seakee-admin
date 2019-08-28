<template>
    <div class="wrapper">
        <app-header></app-header>
        <app-sidebar></app-sidebar>
        <div class="app-content">
            <app-main></app-main>
            <app-footer></app-footer>
        </div>

    </div>
</template>

<script>
    import Header  from './components/app-header'
    import Sidebar from './components/app-sidebar'
    import Main    from './components/app-main'
    import Footer  from './components/app-footer'

    export default {
        name      : 'layout',
        components: {
            'app-header' : Header,
            'app-sidebar': Sidebar,
            'app-main'   : Main,
            'app-footer' : Footer
        }
    }
</script>

<style rel="stylesheet/scss" lang="scss">

    button i{
        width: 25px;
    }

</style>