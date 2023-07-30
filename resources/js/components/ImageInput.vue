<template>
  <div>
    
    <div style="width: 150px;" class="mx-auto" @click="launchFilePicker()">
      <slot name="activator"></slot>
    </div>
    
    <input type="file"
       ref="file"
       :name="uploadFieldName"
       @change="onFileChange(
          $event.target.name, $event.target.files)"
       style="display:none">
    <!-- error dialog -->
    <v-dialog v-model="errorDialog" max-width="300">
      <v-card>
        <v-card-text class="subheading">{{errorText}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" @click="errorDialog = false" flat>Entendido</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    name: 'image-input',
    data: ()=> ({
      errorDialog: null,
      errorText: '',
      uploadFieldName: 'file',
      maxSize: 1024
    }),
    props: {    
      value: Object,
    },
    methods: {
      launchFilePicker(){
        this.$refs.file.click();
      },
      onFileChange(fieldName, file) {
        const { maxSize } = this
        let imageFile = file[0] 
 
        
        if (file.length>0) {
          let size = imageFile.size / maxSize / maxSize
          if (!imageFile.type.match('image.*')) {
            
            this.errorDialog = true
            this.errorText = 'Por favor elige un archivo de imagen'
          } else if (size>5) {
            
            this.errorDialog = true
            this.errorText = '¡Tu archivo es demasiado grande! Seleccione una imagen de menos de 5 MB'
          } else {

          let imageURL = URL.createObjectURL(imageFile)
            
            this.$emit('update:modelValue', { imageFile, imageURL })
          }
        }
      }
    }
  }
</script>