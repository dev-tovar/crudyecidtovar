<template>
  <div>
    <v-app id="inspire">
      <Drawer :drawerCustom="drawer"> </Drawer>
      <Navbar @changedrawer="changeDrawerFront"></Navbar>
      <v-main class="bg-grey-lighten-4">
        <v-container class="py-8 px-6" fluid>
           <router-view></router-view>
        </v-container>
      </v-main>
    </v-app>
  </div>
</template>


<script>
export default {
  data: () => ({
    drawer: null,
  }),
  methods: {
    changeDrawerFront(v){
        this.drawer = v;
    }
  },
};
</script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Public+Sans:wght@200&family=Roboto:wght@200&display=swap");
#app {
  font-family: "Roboto", sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
.portada {
  margin-top: 70px;
}

a{
  text-decoration: none !important;
}
</style>