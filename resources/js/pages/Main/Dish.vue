<template>
  <v-container>
    <dish-table
      :loading="loading"
      :dishes="dishes"
      name="Nekoringo"
      @fetch="fetchData"
    />
  </v-container>
</template>
<script>
import axios from 'axios'
import DishTable from '../../components/DishTable'
export default{
  components: {
    DishTable
  },
  data(){
    return{
      dishes: [],
      loading: false,
      error: null
    }
  },
  methods:{
    async fetchData(){
      this.loading = true
      this.error = null
      try {
        const response = await axios.get('/admin/dish/index')
        this.dishes = response.data.data
      } catch(err) {
        this.error = err.toString()
      }
      this.loading = false
    }
  },
  created(){
    
  },
  mounted(){
    this.fetchData()
  },
}
</script>
<style scoped>
</style>