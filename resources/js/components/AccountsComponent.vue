<template>
  <div>
    <v-card color="transparent" elevation="0">
      <template v-slot:title>
        <div class="d-flex">
          <h3 class="text-h4 font-weight-bold">Usuarios</h3>
          <v-spacer></v-spacer>
          <router-link to="/new" custom v-slot="{ navigate }">
            <v-btn
              @click="navigate"
              role="link"
              size="large"
              prepend-icon="mdi-plus"
              color="grey-darken-4"
              class="text-capitalize"
            >
              Nuevo usuario
            </v-btn>
          </router-link>
        </div>
      </template>
      <v-divider class="border-opacity-0 my-2"></v-divider>
      <v-card-text>
        <v-table>
          <thead>
            <tr>
              <th class="text-left text-body-2 font-weight-bold">Nombre</th>
              <th class="text-left text-body-2 font-weight-bold">Apellidos</th>
              <th class="text-left text-body-2 font-weight-bold">Tipo de documento</th>
              <th class="text-left text-body-2 font-weight-bold">Número de identificación</th>
              <th class="text-left text-body-2 font-weight-bold">Teléfono</th>
              <th class="text-left text-body-2 font-weight-bold">F. creación</th>
              <th class="text-left text-body-2 font-weight-bold"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(account, index) in itemsAccounts" :key="index">
              <td>
                <v-list-item>
                  <template v-slot:prepend>
                    <v-avatar v-if="account.path" class="me-4 mt-2">
                      <v-img
                        circle
                        :src="'/storage/' + account.path"
                        cover
                      ></v-img>
                    </v-avatar>
                  </template>
                  <v-list-item-title
                    class="text-uppercase font-weight-regular text-caption"
                    >{{ account.nombre }}</v-list-item-title
                  >
                </v-list-item>
              </td>
              <td>{{ account.apellido }}</td>
              <td>{{ account.info_type_id.nombre }}</td>
              <td>{{ account.numero_id }}</td>
              <td>{{ account.numero_telefono }}</td>
              <td>{{ account.created_at }}</td>
              <td>
                <router-link
                  :to="'/edit/' + account.id"
                  custom
                  v-slot="{ navigate }"
                >
                  <v-btn
                    @click="navigate"
                    role="link"
                    size="x-small"
                    icon="mdi-pencil"
                    color="indigo"
                    class="mx-1"
                  >
                  </v-btn>
                </router-link>
                  <v-btn
                    @click="deleteAccount(account.id)"
                    role="link"
                    size="x-small"
                    icon="mdi-delete"
                    color="red"
                    class="mx-1"
                  >
                  </v-btn>
              </td>
            </tr>
          </tbody>
        </v-table>
      </v-card-text>
    </v-card>
    <div v-if="show_modal" class="modal-route">
      <div class="modal-content">
        <router-view></router-view>
      </div>
    </div>
    <v-dialog persistent width="500" v-model="dialogConfirmDelete">
      <v-card>
        <template v-slot:title>
          <h3 class="text-h5 mt-6 text-center font-weight-bold">
            Eliminar usuario
          </h3>
        </template>
        <v-card-text class="pa-4 text-center">
          ¿Está seguro que desea eliminar este usuario? <br />
          Una vez eliminado no se podrá recuperar.
        </v-card-text>
        <v-card-actions class="pt-3">
          <v-spacer></v-spacer>
          <v-btn
            @click="closeDeleteAccount"
            text
            class="body-2 font-weight-bold text-capitalize"
            >Cancelar</v-btn
          >
          <v-btn
            prepend-icon="mdi-delete"
            color="red"
            variant="flat"
            class="body-2 font-weight-bold text-capitalize"
            outlined
            @click="deleteAccountConfirm"
            >Eliminar</v-btn
          >
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "AccountsComponent",
  data() {
    return {
      show_modal: false,
      itemsAccounts: [],
      idAccountDelete: null,
      dialogConfirmDelete: false,
    };
  },
  watch: {
    $route: {
      immediate: true,
      handler: function (newVal, oldVal) {
        this.show_modal = newVal.meta && newVal.meta.showModal;
        if (newVal.name == "home") {
          this.getAccounts();
        }
      },
    },
  },
  methods: {
    getAccounts() {
      axios
        .get("/crudAccount")
        .then((res) => {
          this.itemsAccounts = res.data;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    deleteAccount(id) {
      this.idAccountDelete = id;
      this.dialogConfirmDelete = true;
    },
    closeDeleteAccount() {
      this.idAccountDelete = null;
      this.dialogConfirmDelete = false;
    },
    deleteAccountConfirm(){
      axios.delete('/crudAccount/' + this.idAccountDelete)
      .then(res => {
        this.getAccounts();
        this.dialogConfirmDelete = false;
      })
      .catch(err => {
        console.error(err); 
      })
    }
  },
};
</script>