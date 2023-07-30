<template>
  <div>
    <v-navigation-drawer width="300" v-model="drawer" color="grey-darken-4">
      <v-card elevation="0" color="transparent" class="text-center mt-5">
        <!-- <v-avatar  size="150" image="/img/profile-circle.png"></v-avatar> -->
        <v-img
          class="mx-auto"
          width="150"
          src="/img/profile-circle.png"
          alt="profile"
        ></v-img>
        <v-card-text>
          <p class="text-h5 text-break font-weight-bold">Yecid Alberto Tovar Tovar</p>
          <span class="caption font-weight-normal"
            >Desarrollador FullStack</span
          >
        </v-card-text>
        <v-card-text class="text-left">
          <v-list lines="one">
            <v-list-item>
              <template v-slot:prepend>
                <v-icon icon="mdi-phone-dial"></v-icon>
              </template>

              <v-list-item-title>(+57) 321-414-0263</v-list-item-title>
            </v-list-item>
            <v-list-item>
              <template v-slot:prepend>
                <v-icon icon="mdi-at"></v-icon>
              </template>

              <v-list-item-title>tyesid@hotmail.com</v-list-item-title>
            </v-list-item>
            <v-list-item>
              <template v-slot:prepend>
                <v-icon icon="mdi-linkedin"></v-icon>
              </template>

              <v-list-item-title><a style="color: #ffffff !important" target="_blank" href="https://www.linkedin.com/in/yecid-tovar-tovar">yecid-tovar-tovar</a></v-list-item-title>
            </v-list-item>
          </v-list>
        </v-card-text>
      </v-card>
    </v-navigation-drawer>
  </div>
</template>
<script>
export default {
    props: ['drawerCustom'],
  data() {
    return {
      drawer: null,
    };
  },
  watch: {
    drawerCustom(){
        this.drawer = this.drawerCustom;
    }
  },
};
</script>