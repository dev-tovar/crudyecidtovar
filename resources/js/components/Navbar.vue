<template>
  <div>
     <v-app-bar :elevation="1" color="indigo">
      <v-app-bar-nav-icon @click="drawer = !drawer"><v-icon>{{ drawer ? 'mdi-menu-open' : 'mdi-menu' }}</v-icon> </v-app-bar-nav-icon>

      <v-toolbar-title class="font-weight-bold">CRUD</v-toolbar-title>
    </v-app-bar>
  </div>
</template>
<script>
export default {
    
  data() {
    return {
      drawer: true,
    };
  },
  watch: {
    drawer(){
        this.$emit('changedrawer', this.drawer)
    }
  },
  mounted() {
    
  },
};
</script>