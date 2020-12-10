<template>
  <v-container>
    <publican-request-table
      :requests="requests"
      :loading="loading"
      name="Nekoringo"
      @fetch="fetchData"
    />
  </v-container>
</template>
<script>
import PublicanRequestTable from "../../../components/PublicanRequestTable";
import axios from "axios";
export default {
  data() {
    return {
      requests: [],
      loading: false,
      error: null
    };
  },
  methods: {
    async fetchData() {
      this.loading = true;
      try {
        const response = await axios.get("/admin/request/store");
        this.requests = response.data.data;
      } catch (err) {
        this.error = err;
      }
    }
  },
  created() {},
  mounted() {
    this.fetchData();
  },
  computed: {},
  components: {
    PublicanRequestTable
  }
};
</script>
<style scoped>
</style>