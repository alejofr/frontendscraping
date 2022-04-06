<template>
    <b-container class="bv-example-row py-5">
        <b-row>
            <b-col cols="4" md="4">
                <div>
                    <a class="card card-btn-link box-shadow_style01" >
                        <div  @click="viewShow($event)" style="cursor:pointer;">
                              <div class="img_card d-flex justify-content-center">
                                <i class="icon-producto"></i>
                            </div>
                            <div class="title_card pt-2">
                                <p class="text-center">Buscar Por Producto</p>
                            </div>
                        </div>
                        <div class="container-search_card pt-3">
                            <div class="search_card">
                                <label for="seacrhProd">Ingresa El Link</label>
                                <b-form-input id="seacrhProd" v-model="searchProd"  type="text"></b-form-input>
                            </div>
                            <div class="pt-2 d-flex justify-content-end btn-style_001">
                                <b-button @click="searchProducts">Buscar</b-button>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="mt-2">
                    <div class="card card-btn-link box-shadow_style01 active">
                        <div @click="viewShow($event)" style="cursor:pointer;">
                            <div class="img_card d-flex justify-content-center">
                                <i class="icon-categoria"></i>
                            </div>
                            <div class="title_card pt-2">
                                <p class="text-center">Buscar Por Categorias</p>
                            </div>
                        </div>
                        <div class="container-search_card pt-3">
                            <div class="search_card">
                                <label for="seacrhProd">Ingresa El Link</label>
                                <b-form-input id="seacrhProd" v-model="searchCate"  type="text"></b-form-input>
                            </div>
                            <div class="pt-2 d-flex justify-content-end btn-style_001">
                                <b-button @click="searchCateg">Buscar</b-button>
                            </div>
                        </div>
                    </div>
                </div>
            </b-col>
            <b-col cols="8" md="8" class="position-relative px-0">
                <div class="w-100 main-content box-shadow_style01" style="overflow: overlay;">
                    <div class="w-100 h-100" v-show="estado == false">
                        <div class="d-flex justify-content-center align-items-center w-100 h-100">
                            <div class="content-container text-center" >
                                <div class="icon-view" v-show="carga == false">
                                    <i class="icon-contenido"></i>
                                </div>
                                <div class="mt-2">
                                    <p v-show="carga == false" >No hay contenido para mostrar</p>
                                    <b-spinner v-show="carga == true" type="grow"></b-spinner>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-show="estado == true" class="w-100 h-100">
                        <ViewProd  v-if="stateProd" v-bind:product="producto"/>
                        <ViewCate v-if="stateCate"  v-bind:categ="categories"/>
                    </div>
                </div>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import ViewProd from './ViewProd.vue'
import ViewCate from './ViewCate.vue'


export default {
  name: 'Scraping',
  components: {
      ViewProd,
      ViewCate
  },
  data () {
      return {
          searchProd: '',
          searchCate: '',
          producto: [],
          categories:[],
          estado: false,
          stateProd: false,
          stateCate: false,
          carga: false
      }
  },
  methods: {
      viewShow: function(e){
          let a = document.getElementsByClassName('card-btn-link');

          for (let i = 0; i < a.length; i++) {
              if( a[i].className == "card card-btn-link box-shadow_style01 active" )
                a[i].classList.remove('active');
          }
     
          let aCat = ( e.target.parentNode.parentNode.className == "card card-btn-link box-shadow_style01" ) ? e.target.parentNode.parentNode: e.target.parentNode.parentNode.parentNode;
              aCat.classList.add('active');
      },
      searchProducts: function(){
            console.log(this.searchProd);
            let url = { 
              'url' : this.searchProd
            };
            this.stateCate = false;
            this.estado = false;
            this.stateProd = false; 
            this.carga = true;
            
             this.axios.post(process.env.VUE_APP_RUTA_SERVE + "scraping-prod", url)
            .then(response => {
                console.log(response)
                this.stateCate = false;
                this.estado = true;

                this.producto = response.data.data;
                this.carga = false;
                this.stateProd = true;
            }) 
            .catch(error => {
                this.carga = false;
                alert('Ocurrio Un error,por favor intentar más tarde');
                this.errorMessage = error.message;
                console.error("There was an error!", this.errorMessage);
            });
             

        },
        searchCateg: function(){
            this.stateProd = false;
            this.estado = false;
            this.carga = true;
            console.log(url);

            let url = { 
              'url' : this.searchCate
            };
        

            this.axios.post(process.env.VUE_APP_RUTA_SERVE + "scraping-cate", url)
            .then(response => {
                console.log(response)
                this.estado = true;
                this.carga = false;
                this.stateProd = false;

                 console.log(response.data)
                this.categories = response.data.data;
                this.stateCate = true; 
            }) 
            .catch(error => {
                this.carga = false;
                alert('Ocurrio Un error,por favor intentar más tarde');
                this.errorMessage = error.message;
                console.error("There was an error!", this.errorMessage);
            });
        }

  }
}
</script>

<style scoped>
.card-btn-link{
    background-color: #fff;
    color: #FE9900;
    padding: 20px;
    min-height: 225px;
    display: flex;
    align-content: center;
    justify-content: center;
    border: none;
    border-radius: 0;
    text-decoration: none;
    cursor: pointer;
}

.card-btn-link.active{
    background-color: #FE9900;
    color: #fff;
    -webkit-transition: all 0.4s;
    -o-transition: all 0.4s;
    -moz-transition: all 0.4s;
    transition: all 0.4s;
}


.img_card i{
    font-size: 52px;
}

.container-search_card{
    display: none;
}

.card-btn-link.active .container-search_card{
    display: block;
}
.search_card label{
    font-size: 12px;
    margin-bottom: 8px;
}
.search_card input{
    border-radius: 0;
    border:none;
    background-color: #fff;
}

.btn-style_001 button{
    font-size: 12px;
    padding: 5px 15px;
    line-height: 1;
    border-radius: 0 !important;
    background-color: #103c7e;
}

.main-content{
    background-color: #fff;
    min-height: 480px;
    height: 480px;
}

.content-container p, .content-container i{
      color: #b3b3b3;
      font-size: 18px;
}

.content-container i{
    font-size: 98px;
}


</style>
