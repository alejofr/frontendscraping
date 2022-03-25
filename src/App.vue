<template>
    <main>
     
         <div v-if="this.$store.state.loginStatus">
          <b-navbar toggleable="lg" type="dark" variant="info nav-wrap">
             <b-container>
                <b-navbar-brand href="#">AMMEFY</b-navbar-brand>
                <b-navbar-nav class="ml-auto">
                  <b-button  class="btn-logout" v-on:click="logout">
                    Salir <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="9" /><line x1="9" y1="12" x2="15" y2="12" /></svg>
                  </b-button>
                </b-navbar-nav>
              </b-container>
          </b-navbar>
        </div>
        <div>
          <router-view></router-view>
        </div>
    </main>
</template>
<script>
    import { mapMutations } from 'vuex'

    export default {
        methods: {
            ...mapMutations(['closeSession']),
            logout(){
                this.closeSession();
                this.$router.push('login');
            }
        }
    }
</script>
<style scoped>

.nav-wrap{
  justify-content: center !important;
  background-color: #FE9900 !important;
}

.btn-logout{
    background-color: #1e2f5f;
    min-width: 80px;
    height: 38px;
    border: none;
    border-radius: 0;
    padding: 0;

    font-size: 15px;


    display: -webkit-box;
    display: -webkit-flex;
    display: -moz-box;
    display: -ms-flexbox;
    display: flex;
    justify-content: center;
    -ms-align-items: center;
    align-items: center;
}

.btn-logout:hover{
    opacity: 1;
    background-color: #1e2f5f;
}

.btn-logout .icon{
  margin-left: 10px;
  height: 19px;
  width: 19px;
}
</style>



