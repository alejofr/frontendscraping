<template>
    <div style="padding: 40px 25px;">
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
        </b-row>
        <div class="container_img">
            <carousel :items="5" :autoWidth="false" :nav="false"> 
                <div class="card-img-prod" v-for="images in product.img" :key="images">
                    <div class="custom-control custom-checkbox image-checkbox">
                        <input type="checkbox" class="custom-control-input position-absolute" id="ck1a">
                        <label class="custom-control-label" for="ck1a">
                            <img v-bind:src="images" alt="#" class="img-fluid">           
                        </label>
                    </div>
                </div>
                
            </carousel>
        </div>
        <div class="mt-3">
            <div class="export-btn text-end">
                <button type="button">
                    Exportar a mercadolibre
                </button>
            </div>
        </div>  
    </div>
    
</template>


<script>
import carousel from 'vue-owl-carousel'

export default {
    props: ['product'],
    name: 'ViewProd',
    data() {
        return {
            images:[]
        }
    },
    components:{
        carousel
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