<template>
    <v-container grid-list-md text-xs-center id="tags" class="tags">
        <v-layout row wrap>
            <v-flex xs12 justify-center>
                <v-dialog v-model="deleteDialog" width="400">
                    <v-card>
                        <v-card-title class="headline">Voleu borrar el tag <strong>{{this.newTag.name}}</strong> ?</v-card-title>
                        <v-card-text>
                            Aquesta operació no es pot desfer.
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" flat="flat" @click="deleteDialog = false">
                                Cancel·lar
                            </v-btn>
                            <v-btn color="red darken-1" dark @click="destroy">
                            Confirmar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="createDialog" max-width="600px">
                    <v-card>
                        <v-toolbar dark color="pink">
                            <v-icon>local_offer</v-icon>
                            <v-toolbar-title>NOU TAG</v-toolbar-title>

                        </v-toolbar>
                        <v-spacer></v-spacer>

                        <v-card-text>
                            <v-container grid-list-md>
                                <v-layout wrap>
                                    <v-flex xs12>
                                        <v-text-field prepend-icon="local_offer" v-model="newTag.name" label="Nom"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-text-field prepend-icon="color_lens" v-model="newTag.color" label="Color"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-textarea prepend-icon="description" v-model="newTag.description" label="Descripcio"></v-textarea>
                                    </v-flex>

                                </v-layout>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="blue darken-1" flat @click="createDialog=false">
                                <v-icon class="mr-2">exit_to_app</v-icon>
                                Close</v-btn>
                            <v-btn id="button_add_tag" dark color="green dark" flat @click="add">
                                <v-icon class="mr-2">save</v-icon>
                                Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="showDialog" hide-overlay fullscreen transition="dialog-bottom-transition" @keydown.esc="showDialog=false">
                    <v-toolbar color="green" class="white--text">
                        <v-btn flat icon class="white--text" @click="showDialog=false">
                            <v-icon >close</v-icon>
                        </v-btn>
                        <v-card-title class="headline">Mostrar tag</v-card-title>
                        <v-icon class="white--text">local_offer</v-icon>

                        <v-spacer></v-spacer>
                        <v-btn flat class="white--text" @click="showDialog=false">
                            <v-icon class="mr-2">exit_to_app</v-icon>
                            Sortir
                        </v-btn>
                        <v-btn flat class="white--text">
                            <v-icon class="mr-2">save</v-icon>
                            Guardar
                        </v-btn>
                    </v-toolbar>
                    <v-card>
                        <v-card-text>
                            <v-form>
                                <v-text-field  disabled prepend-icon="local_offer" v-model="tagBeingShown.name" label="Nom" hint="Nom del tag " placeholder="Nom del tag"></v-text-field>
                                <v-text-field disabled prepend-icon="color_lens" v-model="tagBeingShown.color" label="Color" hint="Color del tag " placeholder="Color del tag"></v-text-field>
                                <v-textarea disabled prepend-icon="description" v-model="tagBeingShown.description" label="Descripció"></v-textarea>
                                <div class="text-xs-center">
                                    <v-btn @click="showDialog=false">
                                        <v-icon class="mr-2">exit_to_app</v-icon>
                                        Cancel·lar
                                    </v-btn>
                                    <v-btn color="success">
                                        <v-icon class="mr-2">save</v-icon>
                                        Guardar
                                    </v-btn>
                                </div>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="editDialog" fullscreen transition="dialog-bottom-transition" @keydown.esc="editDialog=false">
                        <v-toolbar color="blue" class="white--text">
                            <v-btn flat icon class="white--text" @click="editDialog=false">
                                <v-icon>close</v-icon>
                            </v-btn>

                            <v-card-title class="headline">Editar Tag</v-card-title>
                            <v-icon class="white--text">local_offer</v-icon>

                            <v-spacer></v-spacer>
                            <v-btn flat class="white--text" @click="editDialog=false">
                                <v-icon class="mr-2">exit_to_app</v-icon>
                                Sortir
                            </v-btn>
                            <v-btn flat class="white--text">
                                <v-icon class="mr-2">save</v-icon>
                                Guardar
                            </v-btn>
                        </v-toolbar>
                        <v-card>
                            <v-card-text>
                                <v-form>
                                    <v-text-field prepend-icon="local_offer" v-model="tagBeingEdit.name" label="Nom" hint="Nom del tag " placeholder="Nom del tag"></v-text-field>
                                    <v-text-field prepend-icon="color_lens" v-model="tagBeingEdit.color" label="Color" hint="Color del tag " placeholder="Color del tag"></v-text-field>
                                    <v-textarea prepend-icon="description" v-model="tagBeingEdit.description" label="Descripció"></v-textarea>
                                    <div class="text-xs-center">
                                        <v-btn @click="editDialog=false">
                                            <v-icon class="mr-2">exit_to_app</v-icon>
                                            Cancel·lar
                                        </v-btn>
                                        <v-btn color="success" @click="update" >
                                            <v-icon class="mr-2">save</v-icon>
                                            Guardar
                                        </v-btn>
                                    </div>
                                </v-form>
                            </v-card-text>
                        </v-card>
                    </v-dialog>
                <v-card>
                    <v-toolbar  dark color="red dark">
                        <v-icon>local_offer</v-icon>

                        <v-toolbar-title>Tags ({{total}})</v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-flex lg3 style="margin-top: 1%;">
                            <v-text-field
                                    append-icon="search"
                                    v-model="search"
                                    label="Buscar"
                                    color="white"

                            ></v-text-field>
                        </v-flex>
                        <v-btn icon class="white--text" @click="refresh" :loading="loading" :disabled="loading">
                            <v-icon>refresh</v-icon>
                        </v-btn>
                    </v-toolbar>

                    <v-card-text class="px-0">
                        <v-data-table
                                :headers="headers"
                                :items="dataTags"
                                :search="search"
                                no-results-text="No s'ha trobat cap registre"
                                no-data-text="No hiha dades disponibles"
                                rows-per-page-text="Tags per pagina"
                                :rows-per-page-items="[5,10,25,50,100,200,{'text':'tots','value':-1}]"
                                :loading="loading"
                        >
                            <v-progress-linear slot="progress" color="pink" indeterminate></v-progress-linear>
                            <template slot="items" slot-scope="{item: tag}">
                                <td>{{ tag.id}}</td>
                                <td class="text-xs-left">{{ tag.name }}</td>
                                <td class="text-xs-left">{{ tag.description }}</td>
                                <td class="text-xs-left"><div class="elevation-2" :style="'background-color:' + tag.color+';border-radius: 4px;height: 15px;width: 15px;'"></div></td>
                                <td>
                                    <span :title="tag.created_at_formatted">{{ tag.created_at_human}}</span>
                                </td>
                                <td>
                                    <span :title="tag.updated_at_formatted">{{ tag.updated_at_human}}</span>
                                </td>
                                <td class="text-xs-center">
                                        <v-btn v-can="tags.show" icon flat title="Mostrar la tag"
                                               @click="showShow(tag)">
                                            <v-icon color="green">visibility</v-icon>
                                        </v-btn>
                                        <v-btn v-can="tags.update" icon flat title="Editar la tag"
                                               @click="showUpdate(tag)">
                                            <v-icon color="blue">edit</v-icon>
                                        </v-btn>
                                        <v-btn v-can="tags.destroy" icon flat title="Eliminar la tag"
                                               @click="showDestroy(tag)">
                                            <v-icon title="Delete tag" color="red">delete</v-icon>
                                        </v-btn>
                                    </td>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
                <v-btn
                        @click="showCreate"
                        fab
                        bottom
                        right
                        fixed
                        large
                        color="pink accent-3"
                        class="white--text"
                        v-can="tags.store"
                >
                    <v-icon>add</v-icon>
                </v-btn>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
export default {
  name: 'Tags',
  data () {
    return {
      tagBeingShown: '',
      newTag: {
        name: '',
        description: '',
        color: ''
      },
      dataTags: this.tags,
      name: '',
      color: '',
      description: '',
      createDialog: false,
      deleteDialog: false,
      usersold: [
        'Marc Mestre',
        'Cristian Marin',
        'Sergi Baucells',
        'Benjamin Zaragoza'
      ],
      editDialog: false,
      tagBeingRemoved: '',
      tagBeingEdit: '',
      showDialog: false,
      filter: 'Totes',
      // filters: [
      //   'Totes',
      //   'Completades',
      //   'Pendents'
      // ],
      search: '',
      pagination: {
        rowsPerPage: 25
      },
      loading: false,
      creating: false,
      editing: false,
      removing: false,
      headers: [
        { text: 'Id', value: 'id', align: 'left', sortable: true },
        { text: 'Name', value: 'name', align: 'left', sortable: true },
        { text: 'Description', value: 'description', align: 'left', sortable: true },
        { text: 'Color', value: 'color', align: 'left', sortable: true },
        { text: 'Creat', value: 'created_at_timestamp', align: 'center', sortable: true },
        { text: 'Modificat', value: 'updated_at_timestamp', align: 'center', sortable: true },
        { text: 'Actions', align: 'center', sortable: false }
      ]
    }
  },
  props: {
    tags: {
      type: Array,
      required: true
    }
  },
  computed: {
    total () {
      return this.dataTags.length
    },
    eliminar () {
      return this.newTag.name
    }
  },
  methods: {
    showUpdate (tag) {
      this.editDialog = true
      this.tagBeingEdit = tag
    },
    showShow (tag) {
      this.showDialog = true
      this.tagBeingShown = tag
    },
    opcio1 () {
      console.log('Todo Opcio')
    },
    createTag (tag) {
      this.dataTags.splice(0, 0, tag)
    },
    showDestroy (tag) {
      this.deleteDialog = true
      this.tagBeingRemoved = tag
    },
    removeTag (tag) {
      this.dataTags.splice(this.dataTags.indexOf(tag), 1)
    },
    add () {
      window.axios.post('/api/v1/tags', this.newTag).then((response) => {
        this.createTag(response.data)
        this.$snackbar.showMessage("S'ha creat correctament la tasca")
        this.createDialog = false
      }).catch((error) => {
        this.$snackbar.showError(error)
      })
    },
    update () {
      this.editing = true
      window.axios.put('/api/v1/tags/' + this.tagBeingEdit.id, this.tagBeingEdit).then((response) => {
        this.dataTags.splice(this.dataTags.indexOf(this.tagBeingEdit), 1, response.data)
        this.$snackbar.showMessage("S'ha actualitzat correctament la tasca")
        this.editDialog = false
      }).catch((error) => {
        this.editing = false
      })
    },
    destroy (tag) {
      this.removing = true
      window.axios.delete('/api/v1/tags/' + this.tagBeingRemoved.id).then(() => {
        // this.refresh()
        this.removeTag(this.tagBeingRemoved)
        this.deleteDialog = false
        this.tagBeingRemoved = null
        this.$snackbar.showMessage("S'ha esborrat correctament el tag")
        this.removing = false
      }).catch(error => {
        this.$snackbar.showError(error)
        this.removing = false
      })
    },
    showCreate (tag) {
      this.createDialog = true
      console.log('Todo delete tag')
    },
    create (tag) {
      console.log('Todo delete tag')
    },
    show (tag) {
      console.log('Todo show tag' + tag.id)
    },
    refresh () {
      this.loading = true
      // setTimeout(() => { this.loading = false }, 5000)
      window.axios.get('/api/v1/tags').then(response => {
        this.dataTags = response.data
        this.loading = false
        this.$snackbar.showMessage("S'han actualitzat correctament els tags ")
      }).catch(error => {
        this.$snackbar.showError(error)
        this.loading = false
      })
    }
  }
  // created () {
  //   console.log('Usuari logat')
  //   console.log(window.laravel_user)
  // }
}
</script>

<style>
    .strike {
        text-decoration: line-through;
    }
</style>
