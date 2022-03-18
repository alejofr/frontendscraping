<template>
    <div class="h-100 w-100">
        <div class="row" style="padding: 30px 25px;margin:0;">
            <div class="col-md-3 mb-3" v-for="product in categ" :key="product">
                <div class="card">
                    <input type="checkbox" class="custom-control-input position-absolute" id="card">
                    <label class="card__content" id="card" for="card">
                        <div class="card__header">
                            <div class="image-card">
                                <img v-bind:src="product.img" alt="">
                            </div>
                        </div>
                        <div class="card__body">
                            <div>
                                <div class="name-text-content">
                                    <p>{{ product.name }}</p>
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
                                            <label for="nameProd">$  Monto en pesos COL </label>
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
                <button type="button">
                    Exportar a mercadolibre
                </button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['categ'],
    name: 'ViewCate',
     data() {
        return {
            product:[]
        }
    },
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