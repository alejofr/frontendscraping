<template>
    <div class="h-100 w-100">
         <div class="h-100 w-100" v-show="show == 0">
            <div class="row" style="padding: 30px 25px;margin:0;">
                <div class="col-md-3 mb-3" v-for="(product, index) in categ" :key="index">
                    <div class="card">
                        <input type="checkbox"  v-model="select" @change="evento($event)" :value="product.url" class="custom-control-input position-absolute" :id="index">
                        <label class="card__content" id="card" :for="index">
                            <div class="card__header">
                                <div class="image-card">
                                    <img v-bind:src="product.img" alt="">
                                </div>
                            </div>
                            <div class="card__body">
                                <div>
                                    <div class="name-text-content">
                                        <div class="form-box">
                                            <b-form-input id="nameProd" type="text" style="margin-bottom: 10px;font-size:12px;" :value="product.name" required></b-form-input>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <div class="precio-text-card">
                                        $ {{ product.price }} USD
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="precio-colombia-text">
                                        <b-col cols="12" md="12">
                                            <div class="form-box">
                                                <b-form-input id="nameProd" type="text" v-model="product.price_col" required></b-form-input>
                                                <label for="nameProd" style="width: 100%;text-align: center;">$ Precio COL </label>
                                            </div>
                                        </b-col>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            <div class="btn-cate-add">
                <div class="export-btn text-end">
                    <b-button type="button" @click="next" class="send-cod-api px-3" variant="outline-primary">Continuar</b-button>
                </div>
            </div>
        </div>
        <div class="h-100 w-100" v-show="show == 1">
            <div style="padding: 30px 25px;">
                 <Categ v-bind:categorias="categorias" :categSeleccionadaVolver="onCategSeleccionadaVolver" :categSeleccionada="onSeleccion" :id_cate="id_cate" :name_cate="name_cate" />
                <div class="mt-3">
                    <div class="d-flex">
                        <div class="export-btn text-start w-50">
                            <b-button type="button" @click="prev" class="">Volver</b-button>
                        </div>
                        <div class="export-btn text-end w-50">
                            <button type="submit" @click="exportar">
                                Exportar a Mercado Libre
                            </button>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</template>
<script>
import Categ from './Categorias.vue'
export default {
    props: ['categ'],
    name: 'ViewCate',
     data() {
        return {
             categorias: [],
             categoria: '',
            product:[],
            select: [],
            show:0,
            id: '',
            cat: false,
            id_cate: '',
            name_cate: ''
        }
    },
    components:{
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
                    console.log(response);
                })
                .catch(error => {
                console.log(error)
            });
        }
    },
    methods: {
        exportar(){
            console.log(this.select);
            console.log(this.categ);
            console.log(this.categoria)
            let productos = this.categ;
            let seleccion = this.select;

            for (let i = 0; i < seleccion.length; i++) {
                for (let j = 0; j < productos.length; j++) {
                    if( productos[j].url ===  seleccion[i]){
                        let images = []
                        let img = {
                            "source": productos[j].img
                        };
                        images.push(img);

                        let data = {
                            'token' : localStorage.getItem('token'),
                            'prod': 'prod',
                            'categoria': this.categoria,
                            'titulo' : productos[j].name,
                            'descripcion' : "",
                            'precio' : productos[j].price_col,
                            'images' : images
                        }
                        console.log(data);
                        this.axios
                        .post(process.env.VUE_APP_RUTA_API_MERCADOLIBRE_POST,data)
                            .then(response => {
                                if ( response.data.error == null ){
                                    alert("Se guardo con exito!.");
                                }
                            })
                            .catch(error => {
                            console.log(error)
                        });
                        break;
                    }
                }
                
            }

             //location.reload();
           
        },
        evento(event){
            event.preventDefault()
            let el = event.target;
            let valor = el.value;
            
            let label = event.target.nextSibling;
            let nameProd = label.querySelector('#nameProd').value;
        
            let productos = this.categ;
            for (let i = 0; i < productos.length; i++) {
                if( productos[i].url ===  valor){
                    if ( nameProd.length > 60){
                        this.eliminarValor(valor, event);
                        alert("por favor modifcar titulo, no puede ser mas de 60 caracteres")
                        break;
                    }else{

                        if( nameProd != "" ){
                            productos[i].name = nameProd;
                        }else{
                            this.eliminarValor(valor, event);
                            alert("por favor debe ingrear un nombre, no mas de 60 caracteres")
                        }

                    }
                }
            }

            this.categ = productos;
        },
        eliminarValor(valor, event){
            let indice = this.select.indexOf( valor );
            this.select.splice(indice, 1)
            event.target.checked = false;
        },
         next(){
            if ( this.select.length != 0 )
                this.show++;
            else 
                alert("debe seleccionar los productos a guardar");
        },
          prev(){
            this.show--;
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

.card{
    border: none;
    background-color: #fff;
     box-shadow: 1px 2px 7px 0px rgb(0 0 0 / 15%);
    -moz-box-shadow: 1px 2px 7px 0px rgb(0 0 0 / 15%);
    -webkit-box-shadow: 1px 2px 7px 0px rgb(0 0 0 / 15%);
    -o-box-shadow: 1px 2px 7px 0px rgb(0 0 0 / 15%);
    -ms-box-shadow: 1px 2px 7px 0px rgb(0 0 0 / 15%);

}

.card,.card__content{
    cursor: pointer;
}
.card__content{padding: 15px 0 25px 0;} 

.card .custom-control-input{
    top: 8px;
    right: 6px;
}

.image-card{
    height: 80px;
    width: 80px;
    margin: 0 auto;
    display: flex;
    align-items: center;
}
.image-card img{
    max-width: 100%;
    max-height: 100%;
}
.name-text-content{
    display: -webkit-box!important;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: normal;
 
}

.precio-text-card, .name-text-content{
    font-size: 12px;
    text-align: center;
    padding: 0 15px;
    font-weight: 500;
}

.precio-colombia-text{
    padding: 0 15px;
}
.precio-colombia-text .form-box input{margin-bottom: 0;}
.precio-colombia-text .form-box label, .precio-colombia-text .form-box input{
    font-size: 10px;
    color: #555;
    text-align: center;
}

.btn-cate-add{
    position: absolute;
    bottom: 0;
    width: 100%;
    padding: 10px 35px;
    background-color: #fff;
}
</style>