<template>
    <form style="padding: 40px 25px;" @submit.prevent="ProductForm">
        <div class="form-group">
            <b-alert v-model="showDismissibleAlert" variant="danger" class="closeButton" dismissible style="padding:15px;font-size:12px;">
                {{ alert }}
            </b-alert>
        </div>
            <fieldset v-show="show == 0">
                <b-row style="margin:0;">
                <b-col cols="12" md="6">
                    <div class="form-box">
                        <b-form-input id="nameProd" type="text" v-model="product.name" required></b-form-input>
                        <label for="nameProd">Nombre del producto</label>
                    </div>
                </b-col>
                <b-col cols="12" md="6">
                    <div class="form-box">
                        <b-form-input id="precioProd" v-model="product.precio_usd" type="text" required></b-form-input>
                        <label for="precioProd">$  Precio en USD</label>
                    </div>
                </b-col>
                <b-col cols="12" md="12">
                    <div class="cont-descrip">
                        <label for="descripProd">Descripción</label>
                        <div class="text-descrip mt-2">
                            <textarea id="descripProd" v-model="product.desp"></textarea>
                        </div>  
                    </div>
                </b-col>
                <b-col cols="6" md="6" class="mt-4">
                    <div class="form-box">
                        <b-form-input id="nameProd" v-model="product.precio_col" type="text" required></b-form-input>
                        <label for="nameProd">$  Monto en pesos COL </label>
                    </div>
                </b-col>
                <b-col cols="6" md="6" class="mt-4">
                    <div class="form-box">
                        <select v-model="categoria" name="categoria" id="categMercadoLibre">
                            <!--<option v-for="(item, index) in categorias" v-bind:key="index" :value="item.id">{{ item.name }}</option>-->
                        </select>
                    </div>
                </b-col>
            </b-row>
            <div class="container_img">
                <carousel :items="5" :autoWidth="false" :nav="false"> 
                    <div class="card-img-prod"  v-for="(value, index) in product.images" v-bind:key="index">
                        <div class="custom-control custom-checkbox image-checkbox">
                            <input type="checkbox" :value="value" :id="'img'+index" name="imagenes[]" v-model="imagenes" class="custom-control-input position-absolute">
                            <label class="custom-control-label" :for="'img'+index">
                                <img v-bind:src="value" alt="#" class="img-fluid">           
                            </label>
                        </div>
                    </div> 
                </carousel>
            </div>
             <div class="form-group mt-3">
                 <div class="export-btn text-end">
                      <b-button type="button" @click="next" class="send-cod-api px-3" variant="outline-primary">Continuar</b-button>
                 </div>
            </div>
        </fieldset>
        <fieldset v-show="show == 1">
            <div class="mb-3" id="category_task">
                <label class="form-label">Selecciona Una Categoría</label>
                <div class="sc-ui-card-body mb-2">
                    <div class="syi-searchable">
                    <div class="sc-sov-carrousel">
                        <div class="sc-sov-carrousel-element">
                        <div class="searchableOptionValuesContainer">
                            <div class="searchable-option-values-container__list">
                            <div class="sc-ui-option-values">
                                <ul class="ul-lis_cat">
                                    <Categ :id_cate="id"/>
                                </ul>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <div class="d-flex">
                    <div class="export-btn text-start w-50">
                        <b-button type="button" @click="prev" class="">Volver</b-button>
                    </div>
                    <div class="export-btn text-end w-50">
                         <button type="submit">
                            Exportar a mercadolibre
                        </button>
                    </div>
                </div>
            </div> 
        </fieldset> 
    </form>
    
</template>

-a
 -b
  -c
    -d

<script>
import carousel from 'vue-owl-carousel';
import Categ from './CategoriasMercadoLibre.vue'


export default {
    props: ['product'],
    name: 'ViewProd',
    data() {
        return {
            categorias: [],
            categ: [],
            categoria: '',
            showDismissibleAlert:false,
            alert: '',
            show:0,
            imagenes: [],
            id: '',
            cat: false
        }
    },
   components:{
        carousel,
        Categ
    },
    methods: {
        next(){
            this.show++;
        },
        prev(){
            this.show--;
        },
        ProductForm(){
                
            if (localStorage.getItem('token')) {
                if( this.categoria == "" ){
                    alert("Por favor!. Los datos no pueden estar vacios")
                }else{
                    let images = [];
                    let imagenes = this.imagenes;
                    for (let i = 0; i < imagenes.length; i++) {
                        let img = {
                            "source": imagenes[i]
                        };
               
                        images.push(img);
                    }
                
                    let data = {
                        'token' : localStorage.getItem('token'),
                        'prod': 'prod',
                        'categoria': this.categoria,
                        'titulo' : this.product.name,
                        'descripcion' : this.product.desp,
                        'precio' : this.product.precio_col,
                        'images' : images
                    }

                    console.log(data);
                    this.axios
                    .post(process.env.VUE_APP_RUTA_API_MERCADOLIBRE,data)
                        .then(response => {
                            //this.categorias = response.data;
                            console.log(response)
                        })
                        .catch(error => {
                        console.log(error)
                    });
                }
            }
        }
    }
}
</script>

<style scoped>

.text-descrip{
    border: 1px solid #fe9900;
}

.text-descrip textarea{
    width: 100%;
    min-height: 90px;
}

.custom-control-input{
    z-index: 1;
}

.card-img-prod{
    width: 110px;
    position: relative;
}

.card-img-prod label[data-v-3ba339d6] {
    cursor: pointer;
    padding-bottom: 66.25%;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.card-img-prod img[data-v-3ba339d6] {
    /* position: absolute; */
    /* max-height: 100%; */
    /* max-width: 100%; */
    position: absolute;
    width: 100%;
    height: 100%;
    display: block;
    transition: opacity linear 100ms;
}





</style>