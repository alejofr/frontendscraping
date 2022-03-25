<template>
    <form style="padding: 40px 25px;" @submit.prevent="ProductForm">
        <div class="form-group">
            <b-alert v-model="showDismissibleAlert" variant="danger" class="closeButton" dismissible style="padding:15px;font-size:12px;">
                {{ alert }}
            </b-alert>
        </div>
        <b-row style="margin:0;">
            <b-col cols="12" md="6">
                <div class="form-box">
                    <b-form-input id="nameProd" type="text" v-model="product.nom" required></b-form-input>
                    <label for="nameProd">Nombre del producto</label>
                </div>
            </b-col>
            <b-col cols="12" md="6">
                <div class="form-box">
                    <b-form-input id="precioProd" v-model="product.cost" type="text" required></b-form-input>
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
                    <b-form-input id="nameProd" v-model="product.cost_col" type="text" required></b-form-input>
                    <label for="nameProd">$  Monto en pesos COL </label>
                </div>
            </b-col>
            <b-col cols="6" md="6" class="mt-4">
                <div class="form-box">
                    <select v-model="categoria" name="categoria" id="categMercadoLibre">
                        <option v-for="(item, index) in categorias" v-bind:key="index" value="">{{ item.name }}</option>
                    </select>
                </div>
            </b-col>
        </b-row>
        <div class="container_img">
            <carousel :items="5" :autoWidth="false" :nav="false"> 
                <div class="card-img-prod"  v-for="(value, index) in product.img" v-bind:key="index">
                    <div class="custom-control custom-checkbox image-checkbox">
                        <input type="checkbox" :value="value" :id="'img'+index" name="imagenes[]" v-model="imagenes" class="custom-control-input position-absolute">
                        <label class="custom-control-label" :for="'img'+index">
                            <img v-bind:src="value" alt="#" class="img-fluid">           
                        </label>
                    </div>
                </div>
            </carousel>
            
        </div>
        <div class="mt-3">
            <div class="export-btn text-end">
                <button type="submit">
                    Exportar a mercadolibre
                </button>
            </div>
        </div>  
    </form>
    
</template>


<script>
import carousel from 'vue-owl-carousel'

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
            imagenes: [],
        }
    },
    created(){
    if (localStorage.getItem('token')) {
        let token = localStorage.getItem('token');
         let url = 'https://panel.comprazapatos.com.mx/index.php?token='+token;
         this.axios
        .get(url)
            .then(response => {
                this.categorias = response.data;
            console.log(response.data)
            })
            .catch(error => {
            console.log(error)
        });
    }
  },
   components:{
        carousel
    },
    methods: {
        ProductForm(){
            console.log(this.images)
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

.card-img-prod{
    width: 110px;
    position: relative;
}

.card-img-prod img{
    max-height: 100%;
    max-width: 100%;
}

.card-img-prod label{ cursor: pointer;}




</style>