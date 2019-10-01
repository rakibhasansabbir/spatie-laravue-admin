<template>
    <div class="row gap-20 masonry pos-r">
        <div class="masonry-sizer col-md-6"></div>
        <top-info></top-info>
        <google-map></google-map>
    </div>
</template>

<script>
    import TopInfo from './TopInfo'
    import GoogleMap from './GoogleMap'

    export default {
        name: "admin-dashboard",
        components: {
            TopInfo, GoogleMap
        }
    }
</script>

<style scoped>

</style>
