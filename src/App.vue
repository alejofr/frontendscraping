<template>
    <main>
        <div v-if="this.$store.state.loginStatus">
          <b-navbar toggleable="lg" type="dark" variant="info nav-wrap">
            <b-navbar-brand href="#">AMMEFY</b-navbar-brand>
          </b-navbar>
        </div>
        <div>
          <router-view></router-view>
        </div>
    </main>
</template>
<script>
    export default {}
</script>
<style scoped>

.nav-wrap{
  justify-content: center !important;
  background-color: #FE9900 !important;
}
</style>



