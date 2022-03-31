<template>
    <div v-if="swtch == true">
        <li class="li_item_cat" v-for="(item, index) in categorias" v-bind:key="index">
            <div class="dropdownlink">
                <div class="andes-list__item-image-container">
                    <span class="andes-list__item-text">
                        <div class="andes-list__item-primary">
                            <input class="form-check-input" type="radio" :id="item.id" name="categ" :value="item.id">
                            <label :for="item.id" class="select_cat-form">{{item.name}}</label>
                        </div>
                    </span>
                </div>
                <div v-if="item.children_categories == 'nonull' " class="right_item_cat">
                    <span class="icon-arrow_ios"></span>
                </div>
            </div>
            <ul class="submenuItems" v-if="item.children_categories == 'nonull' ">
                <Categ  :id_cate="item.id"/>
            </ul>
        </li>
    </div>
</template>

<script>
import Categ from './CategoriasMercadoLibre.vue'

export default {
    name: 'CategoriasMercadoLibre',
    props: ['id_cate'],
    data() {
        return {
            categorias: {},
            catego : '',
            swtch: false
        }
    },
    created(){
        if ( this.id_cate != ""  ) {
             console.log("jadhajh");
             console.log(this.id_cate)
        }else{
            if (localStorage.getItem('token')) {
                let token = localStorage.getItem('token');
                let url = process.env.VUE_APP_RUTA_API_MERCADOLIBRE+"?token="+token;
                this.axios
                .get(url)
                    .then(response => {
                        console.log("navegando");
                        this.categorias = response.data;
                        this.swtch = true;
                        console.log(response);
                    })
                    .catch(error => {
                    console.log(error)
                });
            }
            
            
        }
        console.log("epa");
       
    },
   components:{
        Categ
    },
}
</script>
<style scoped>


</style>