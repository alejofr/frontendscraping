<template>
    <b-container class="bv-example-row py-5">
        <div class="contenedor">
          <div class="code">
            <strong>Copia este Codigo: </strong>
            <span>{{ code }}</span>
          </div>
        </div>
    </b-container>
</template>

<script>
export default {
  name: 'Redireccionamiento',
  data() {
    return {
      code: ''
    }
  },
  created(){
    
    if( this.$store.state.loginStatus ){
        this.$router.replace('/');
    }

    this.code = this.$route.query.code;
  }
}
</script>

<style scoped>

.contenedor{
  height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.code{
    min-width: 320px;
    background-color: #fff;
    padding: 30px;
}

.code span{
  margin-left: 5px;
}
</style>