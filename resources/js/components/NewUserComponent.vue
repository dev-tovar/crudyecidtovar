<template>
  <div>
    <v-dialog persistent v-model="dialog" scrollable width="600">
      <v-card>
        <v-card-title class="font-weight-bold text-h5 text-center py-4">
          {{ idAccount ? "Editar Usuario" : "Nuevo usuario" }}</v-card-title
        >
        <v-divider></v-divider>
        <v-card-text>
          <v-container>
            <v-form ref="formuser">
              <v-row>
                <v-col cols="12" sm="12" md="12" class="pb-1">
                  <span class="font-weight-bold">Foto de perfil:</span>
                  <v-container grid-list-xl>
                    <image-input v-model="avatar">
                      <template v-slot:activator>
                        <v-avatar
                          size="150px"
                          v-ripple
                          v-if="!avatar"
                          class="bg-grey-lighten-4 mb-3 elevation-1"
                          style="cursor: pointer"
                        >
                          <!-- <v-icon size="50">mdi-image-plus</v-icon>  -->
                          <v-img cover src="/img/add-photo.png" alt="avatar">
                          </v-img>
                        </v-avatar>
                        <v-avatar
                          style="cursor: pointer"
                          size="150"
                          v-else
                          class="mb-3 elevation-1"
                        >
                          <v-img cover :src="avatar.imageURL" alt="avatar">
                          </v-img>
                        </v-avatar>
                      </template>
                    </image-input>
                  </v-container>
                </v-col>
                <v-col cols="12" sm="6" md="6" class="py-1">
                  <span class="font-weight-bold">Nombres:</span>
                  <v-text-field
                    :rules="[rules.required, rules.min2]"
                    required
                    density="compact"
                    variant="outlined"
                    v-model="formUser.name"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" class="py-1">
                  <span class="font-weight-bold">Apellidos:</span>
                  <v-text-field
                    :rules="[rules.required, rules.min2]"
                    required
                    density="compact"
                    variant="outlined"
                    v-model="formUser.lastName"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" class="py-1">
                  <span class="font-weight-bold">Tipo de Documento:</span>
                  <v-select
                    :rules="[rules.required]"
                    :items="itemsIdentification"
                    item-value="id"
                    item-title="nombre"
                    required
                    density="compact"
                    variant="outlined"
                    v-model="formUser.typeId"
                  ></v-select>
                </v-col>
                <v-col cols="12" sm="6" md="6" class="py-1">
                  <span class="font-weight-bold"
                    >Número de Identificación:</span
                  >
                  <v-text-field
                    :rules="[rules.required]"
                    required
                    density="compact"
                    variant="outlined"
                    v-model="formUser.numId"
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" class="py-1">
                  <span class="font-weight-bold">Teléfono:</span>
                  <v-text-field
                    :rules="[rules.required]"
                    required
                    density="compact"
                    variant="outlined"
                    v-model="formUser.phone"
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-form>
          </v-container>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn @click="backRoute" :disabled="saveLoading" class="text-capitalize" variant="text">
            Cerrar
          </v-btn>
          <v-btn
            v-if="idAccount && idAccount > 0"
            :disabled="saveLoading"
            :loading="saveLoading"
            @click="updateData"
            prepend-icon="mdi-check"
            class="text-capitalize"
            color="indigo"
            variant="flat"
          >
            Actualizar Usuario
          </v-btn>
          <v-btn
            v-else
            :disabled="saveLoading"
            :loading="saveLoading"
            @click="saveData"
            prepend-icon="mdi-check"
            class="text-capitalize"
            color="indigo"
            variant="flat"
          >
            Guardar Usuario
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import axios from "axios";
import ImageInput from "./ImageInput.vue";

export default {
  components: {
    ImageInput: ImageInput,
  },
  data() {
    return {
      saveLoading: false,
      dialog: true,
      avatar: null,
      itemsIdentification: [],
      formUser: {
        name: null,
        lastName: null,
        typeId: null,
        numId: null,
        phone: null,
      },
      infoAccount: null,
      rules: {
        required: (v) => !!v || "Este campo es requerido",
        min2: (v) =>
          (v && v.length >= 2) || "Este campo debe tener al menos 2 caracteres",
      },
    };
  },
  mounted() {
    this.getTypeIdentifications();
  },
  computed: {
    idAccount() {
      return this.$route.params.id ? this.$route.params.id : null;
    },
  },
  watch: {
    idAccount: {
      immediate: true,
      handler: function () {
        if (this.idAccount && this.idAccount > 0) {
          this.getInfoAccount();
        }
      },
      deep: true,
    },
    avatar: {
      handler: function () {
        this.saved = false;
      },
      deep: true,
    },
  },

  methods: {
    getInfoAccount() {
      axios
        .get("/crudAccount/" + this.idAccount)
        .then((res) => {
          this.infoAccount = res.data;
          this.processInfo();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    processInfo() {
      this.formUser.name = this.infoAccount.nombre;
      this.formUser.lastName = this.infoAccount.apellido;
      this.formUser.typeId = this.infoAccount.tipo_id;
      this.formUser.numId = this.infoAccount.numero_id;
      this.formUser.phone = this.infoAccount.numero_telefono;
      this.avatar = {
        imageURL: "/storage/" + this.infoAccount.path,
      };
    },
    getTypeIdentifications() {
      axios
        .get("/getTypeIdentifications")
        .then((res) => {
          this.itemsIdentification = res.data;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    async saveData() {
      const { valid } = await this.$refs.formuser.validate();

      if (valid) {
        this.saveLoading = true;
        let formData = new FormData();

        if (this.avatar && this.avatar.imageFile) {
          formData.append("image", this.avatar.imageFile);
        }
        formData.append("nombre", this.formUser.name);
        formData.append("apellido", this.formUser.lastName);
        formData.append("tipo_id", this.formUser.typeId);
        formData.append("numero_id", this.formUser.numId);
        formData.append("numero_telefono", this.formUser.phone);

        axios
          .post("/crudAccount", formData)
          .then((res) => {
            console.log(res);

            this.successSave("insert");
          })
          .catch((err) => {
            console.error(err);
            this.saveLoading = false;
          });
      }
    },
    async updateData() {
      const { valid } = await this.$refs.formuser.validate();

      if (valid) {
        this.saveLoading = true;
        let formData = new FormData();

        if (this.avatar && this.avatar.imageFile) {
          formData.append("image", this.avatar.imageFile);
        }
        formData.append("nombre", this.formUser.name);
        formData.append("apellido", this.formUser.lastName);
        formData.append("tipo_id", this.formUser.typeId);
        formData.append("numero_id", this.formUser.numId);
        formData.append("numero_telefono", this.formUser.phone);

        axios
          .post("/updateAccount/" + this.idAccount, formData)
          .then((res) => {
            console.log(res);

            this.successSave("update");
          })
          .catch((err) => {
            console.error(err);
            this.saveLoading = false;
          });
      }
    },
    successSave(type) {
      this.$refs.formuser.resetValidation();

      if (type == "insert") {
        //MOSTRAR MENSAJE DE INSERT SUCCESS
        this.formUser = {
          name: null,
          lastName: null,
          typeId: null,
          numId: null,
          phone: null,
        };
        this.avatar = null;

        setTimeout(() => {
          this.$router.push({ name: "home" });
        }, 1000);
      } else if (type == "update") {
        //MOSTRAR MENSAJE DE UPDATE SUCCESS
        this.saveLoading = false;
      }
    },
    backRoute(){
                  this.$router.push({ name: "home" });

    }
  },
};
</script>