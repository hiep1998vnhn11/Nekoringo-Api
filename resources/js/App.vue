<template>
  <v-fade-transition mode="out-in">
    <v-app id="inspire">
      <router-view />
    </v-app>
  </v-fade-transition>
</template>

<script>
export default {
  name: 'App'
}
</script>

<style>
#app {
  font-family: 'inherit', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
