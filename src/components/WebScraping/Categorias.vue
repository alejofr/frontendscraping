<template>
    <div class="mb-3" id="category_task">
        <label class="form-label">Selecciona Una Categoría - {{ id_cate }}</label>
        <div class="sc-ui-card-body mb-2">
            <div class="syi-searchable">
            <div class="sc-sov-carrousel">
                <div class="sc-sov-carrousel-element">
                <div class="searchableOptionValuesContainer">
                    <div class="searchable-option-values-container__list">
                    <div class="sc-ui-option-values">
                        <ul class="ul-lis_cat">
                             <li class="li_item_cat" v-for="(item, index) in categorias" v-bind:key="index">
                                <div class="dropdownlink">
                                    <div class="andes-list__item-image-container">
                                        <span class="andes-list__item-text">
                                            <div class="andes-list__item-primary">
                                                <input class="form-check-input" v-on:change="getSeleccionada()" type="radio" v-model="seleccionada" :id="item.id" name="categ" :value="item.id">
                                                <label :for="item.id" class="select_cat-form">{{item.name}}</label>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <p v-if="name_cate != '' ">Categoría seleccionada: {{name_cate}} <button type="button" @click="anterior" style="color: #012355;font-weight: 600;">Anterior</button></p>
    </div>
</template>

<script>


export default {
    name: 'Categorias',
    props: ['categorias', 'categSeleccionada','categSeleccionadaVolver', 'id_cate', 'name_cate'],
    data() {
        return {
            seleccionada: ""
        }
    },
    methods: {
        getSeleccionada(){
            console.log(this.seleccionada);
            this.categSeleccionada(this.seleccionada, this.id_cate);
        },
        anterior(){
            this.categSeleccionadaVolver(this.id_cate);
        }
    }
}
</script>
<style scoped>


</style>