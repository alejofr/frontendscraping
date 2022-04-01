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
        <fieldset v-show="show == 1" >
            <Categ v-bind:categorias="categorias" :categSeleccionadaVolver="onCategSeleccionadaVolver" :categSeleccionada="onSeleccion" :id_cate="id_cate" :name_cate="name_cate" />
            <div class="mt-3">
                <div class="d-flex">
                    <div class="export-btn text-start w-50">
                        <b-button type="button" @click="prev" class="">Volver</b-button>
                    </div>
                    <div class="export-btn text-end w-50">
                         <button type="submit">
                            Exportar a Mercado Libre
                        </button>
                    </div>
                </div>
            </div> 
        </fieldset> 
    </form>
    
</template>

<script>
import carousel from 'vue-owl-carousel';
//import Categ from './CategoriasMercadoLibre.vue'
import Categ from './Categorias.vue'


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
            cat: false,
            id_cate: '',
            name_cate: ''
        }
    },
   components:{
        carousel,
        Categ
    },
    created(){
        if (localStorage.getItem('token')) {
            let token = localStorage.getItem('token');
            let url = process.env.VUE_APP_RUTA_API_MERCADOLIBRE+"?token="+token;
            this.axios
            .get(url)
                .then(response => {
                    console.log("navegando");
                    this.categorias = response.data;
                    console.log(response.data);
                })
                .catch(error => {
                console.log(error)
            });
        }
    },
    methods: {
        next(){
            
            if ( this.product.name != "" && this.product.precio_usd &&  this.product.desp != "" &&  this.product.precio_col != "" && this.imagenes.length != 0 )
                this.show++;
            else 
                alert("los valos no debe estar vacios");
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
                    .post(process.env.VUE_APP_RUTA_API_MERCADOLIBRE_POST,data)
                        .then(response => {
                            console.log(response.data);
                            if ( response.data.error != null ){
                                let cause = response.data.cause;
                                for (let i = 0; i < cause.length; i++) {
                                    
                                    if ( cause[i].cause_id == 126 ){
                                        alert("Error en Guardar Categoria, Por favor debe seleccionar Categorias correspondientes a hojas");
                                    }else if( cause[i].cause_id == 134 ){
                                        alert("Error en Guardar Titulo. el tamaño no puede superar los 60 caracteres");
                                    }
                                    
                                }
                            }else{
                                alert("Se guardo con exito!.");
                                location.reload();
                            }
                            
                        })
                        .catch(error => {
                        console.log(error)
                    });
                }
            }
        },
        onSeleccion(datos, id) {
            console.log('categoria seleccionada anterior: '+id)

            
            this.getCategoriasHijo(datos,'no', id);
            this.categoria = datos;
        },
        onCategSeleccionadaVolver(id){
            console.log('categoria seleccionada anterior - volver: '+id)
            if ( id === 'padre' ){
                id = '';
                this.name_cate = '';
                this.id_cate = '';
                this.getCategoriasPadre();
            }else{
                let resp = this.getCategoriasHijoPadreFiltroVolver(id);
                resp.then(response => {
                    console.log(response);
                    this.id_cate = ( response.path_from_root === "null" ) ? '' : response.path_from_root;
                    this.name_cate = response.name;

                    if ( this.id_cate != ""){
                        console.log("aqui devolvio: "+this.id_cate)
                        this.getCategoriasHijo(this.id_cate,'si', id);
                    }else{
                        id = '';
                        this.name_cate = '';
                        this.id_cate = '';
                        this.getCategoriasPadre();
                    }

                    this.categoria = id;
                });

            }

            
            
        },
        getCategoriasPadre(){
            let token = localStorage.getItem('token');
            let url = process.env.VUE_APP_RUTA_API_MERCADOLIBRE+"?token="+token;
            this.axios
            .get(url)
                .then(response => {
                    console.log("navegando");
                    this.categorias = response.data;
                    console.log(response.data);
                })
                .catch(error => {
                console.log(error)
            });
        },
        getCategoriasHijo(datos,accion, id){
            let token = localStorage.getItem('token');
                let url = process.env.VUE_APP_RUTA_API_MERCADOLIBRE+"?token="+token+"&id_cate="+datos;
                this.axios
                .get(url)
                    .then(response => {
                        console.log("navegando hijo");
                        if ( response.data.children_categories != "null" ){
                            this.categorias = response.data.children_categories;
                            if ( accion === 'no' ){
                                this.name_cate = response.data.name;
                                if ( id === '' ){
                                    this.id_cate = 'padre';
                                }else if ( (id === 'padre') || (id != '' && id != 'padre') ){
                                    this.id_cate = response.data.id;
                                }
                            }
                            
                            console.log(response.data.children_categories.length);
                        }
                          
                        
                        
                        
                    })
                    .catch(error => {
                    console.log(error)
                });
        },
        async getCategoriasHijoPadreFiltroVolver(id){
            let respuesta = await new Promise((resolve,reject)=>{
                let token = localStorage.getItem('token');
                let url = process.env.VUE_APP_RUTA_API_MERCADOLIBRE+"?token="+token+"&id_anterior="+id;
                this.axios
                .get(url)
                    .then(response => {
                        resolve(response.data);
                    })
                    .catch(error => {
                    console.log(error)
                    reject(error)
                     
                });
            });
            
           return respuesta;
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