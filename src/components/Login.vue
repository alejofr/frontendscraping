<template>
    <div class="row" style="margin:0;">
      <div class="col-md-8 px-0 bag-login vh-100" style="background-image: url('/images/ammefy.jpg');"></div>
      <div class="col-md-4 px-0 vh-100">
        <div class="card px-5 py-5 d-flex justify-content-center align-items-center w-100 h-100" >
            <div class="logo-lg d-flex justify-content-center align-items-center ">
              <img src="/images/logo.svg" alt="" srcset="">
            </div>
            <form class="form-lg-scraping login-form w-100 pt-5" @submit.prevent="loginForm">
              <div class="form-group">
                <b-alert v-model="showDismissibleAlert" variant="danger" class="closeButton" dismissible style="padding:15px;font-size:12px;">
                  {{ alert }}
                </b-alert>
              </div>
              <fieldset v-show="show == 0">
                  <div class="form-group">
                    <label for="appId">Cliente ID de la API</label>
                    <input type="text" name="app_id" id="appId" v-model="appId" class="form-control rounded-left" placeholder="Introduzca el Cliente ID">
                  </div>
                  <div class="form-group mt-4">
                    <label for="redirectUri">Url de Redireccionamiento de la API</label>
                    <input type="text" name="redirect_uri" id="redirectUri" v-model="redirectUri" class="form-control rounded-left" placeholder="Introduzca la Url donde enviará un codigo">
                  </div>
                  <div class="form-group mt-5">
                    <b-button type="button" @click="sendCod" class="send-cod-api px-3" variant="outline-primary">Continuar</b-button>
                  </div>
              </fieldset>
              <fieldset v-show="show == 1">
                <div class="form-group">
                  <label for="codigo" class="text-nota"><p>Deberá ingresar en el campo código, el dato que se muestra en la página (<small>{{ redirectUri }}</small>). En caso de no ver ningun dato, <a :href="link" target="bank">Ingresa Aquí</a></p></label>
                  <input type="text" name="codigo" id="codigo" v-model="cod" class="form-control rounded-left" placeholder="Introduzca el Codigo">
                </div>
                <div class="form-group mt-4">
                  <label for="clientSecret">Código Cliente Secreto</label>
                  <input type="text" name="client_secret" id="clientSecret" v-model="clientSecret" class="form-control rounded-left" placeholder="Introduzca El Código Cliente Secreto">
                </div>
                  <div class="form-group mt-5">
                    <b-button type="submit" class="send-cod-api px-3 bg1 cl0" style="border:0;">Comprobar Datos</b-button>
                  </div>
                  <div class="form-group mt-3">
                    <b-button type="button" @click="volver" class="send-cod-api px-3" variant="outline-primary">Volver</b-button>
                  </div>
              </fieldset>
            </form>
          </div>
      </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name: 'Login',
  data(){
    return {
      appId: '',
      redirectUri: '',
      cod:'',
      clientSecret: '',
      showDismissibleAlert:false,
      alert: '',
      show:0,
      link: '',
      token: ''
    }
  },
  created(){
    if( this.$store.state.loginStatus ){
        this.$router.replace('/');
    } 
  },
 
  methods: {
    ...mapActions(['inicio']),
    loginForm(){
      if(  this.cod == "" && this.clientSecret == "" )
        this.alert = "Los Campos no deben de ir vacios";
      else if ( this.cod != "" && this.clientSecret == "" )
        this.alert = "El campo Código Cliente Secreto no debe ir vacios";
      else if ( this.cod == "" && this.clientSecret !="" )
        this.alert = "El campo Código no debe ir vacios";
      
      if( this.alert != "" ){
        this.showDismissibleAlert = true;
        return false;
      }

      let url = 'https://panel.comprazapatos.com.mx/index.php?code='+this.cod+'&client_id='+this.appId+'&client_secret='+this.clientSecret+'&redirect_url='+this.redirectUri+'';
      this.axios
      .get(url)
        .then(response => {
          console.log(response.data)
          this.inicio(response.data.access_token);
          this.$router.replace('/');
        })
        .catch(error => {
          console.log(error)
      });
    },
    sendCod(){
        if(  this.appId == "" && this.redirectUri == "" )
          this.alert = "Los Campos no deben de ir vacios";
        else if ( this.appId != "" && this.redirectUri == "" )
          this.alert = "El campo Url de Redireccionamiento no debe ir vacios";
        else if ( this.appId == "" && this.redirectUri !="" )
          this.alert = "El campo Cliente Id no debe ir vacios";
        
        if( this.alert != "" ){
          this.showDismissibleAlert = true;
          return false;
        }
        this.link = 'https://auth.mercadolibre.com.co/authorization?response_type=code&client_id='+this.appId+'&redirect_uri='+this.redirectUri+'';
        window.open(this.link)
        this.show++;
        return true;
    },
    volver (){
        this.show--;
        this.showDismissibleAlert = false;
    } 
  }
}
</script>
<style scoped>
  .vh-100{
        height: 100vh;
  }
  .bag-login{
    background-size: cover;
    background-position: center;
  }

  .logo-lg{
    width: 130px;
    margin: 0 auto;
    margin-bottom: 10px;
  }

  .logo-lg img{
    max-height: 100%;
    max-width: 100%;
  }

  .form-lg-scraping label{
    font-size: 14px;
    margin-bottom: 10px;
  }

  .form-lg-scraping .form-control{
    font-size: 12px;
    color: #555;
    height: 40px;
    border-radius: 0;
    border: 1px solid #ced4da;
  }

  .form-lg-scraping .send-cod-api{
    font-size: 15px;
    width: 100%;
    height: 40px;
    border-radius: 0;
  }

  .text-nota p{
    font-size: 13px;
    color: #555;
  }

</style>