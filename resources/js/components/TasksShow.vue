<template>
<span>
        <v-dialog v-model="showDialog" fullscreen hide-overlay transition="dialog-bottom-transition"
                  @keydown.esc="showDialog=false">
            <v-toolbar color="blue darken-3" class="white--text">
                <v-btn icon flat class="white--text">
                    <v-icon @click="showDialog=false">close</v-icon>
                </v-btn>
                <v-toolbar-title class="white--text">Mostrar tasca</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn flat class="white--text" @click="showDialog=false">
                    <v-icon class="mr-1" >exit_to_app</v-icon>
                    SORTIR
                </v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <v-form>
                        <v-text-field readonly v-model="name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
                        <v-switch readonly v-model="completed" :label="completed ? 'Completada':'Pendent'" ></v-switch>
                        <v-textarea readonly v-model="description" label="Descripció"></v-textarea>
                        <v-autocomplete readonly v-model="user_id" :items="dataUsers" label="Usuari" item-value="id" item-text="name"></v-autocomplete>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

</span>
</template>

<script>
export default {
  name: 'Name',
  data () {
    return {
      data: ''
    }
  }
}
</script>

<style>

</styles>
