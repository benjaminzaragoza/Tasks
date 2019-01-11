<template>
    <span>
            <v-flex xs12 justify-center>
                <v-dialog v-model="deleteDialog" width="550">
                    <v-card>
                        <!--<strong>{{this.selectedTag.name}}</strong>-->
                        <v-card-title class="headline" style="text-align: center">Voleu borrar el tag  <strong style="color: red;text-transform: uppercase;">&nbsp;{{borrat}}</strong>?</v-card-title>
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
                                        <v-text-field prepend-icon="local_offer" v-model="selectedTag.name" label="Nom"></v-text-field>
                                    </v-flex>
                                    <v-flex xs12>
                                        <!--<v-text-field prepend-icon="color_lens" v-model="selectedTag.color" label="Color"></v-text-field>-->
                                        <input type="color" v-model="selectedTag.color" label="Color" style="width: 50px; height: 50px;">
                                    </v-flex>
                                    <v-flex xs12>
                                        <v-textarea prepend-icon="description" v-model="selectedTag.description" label="Descripcio"></v-textarea>
                                    </v-flex>

                                </v-layout>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" flat @click="createDialog=false">
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
                    </v-toolbar>
                    <v-card>
                        <v-card-text>
                            <v-form>
                                <v-text-field  readonly prepend-icon="local_offer" v-model="tagBeingShown.name" label="Nom" hint="Nom del tag " placeholder="Nom del tag"></v-text-field>
                                <input readonly type="color" v-model="tagBeingShown.color" label="Color" style="width: 50px; height: 50px; margin: 1%">
                                <!--<v-text-field readonly prepend-icon="color_lens" v-model="tagBeingShown.color" label="Color" hint="Color del tag " placeholder="Color del tag"></v-text-field>-->
                                <v-textarea readonly prepend-icon="description" v-model="tagBeingShown.description" label="Descripció"></v-textarea>
                            </v-form>
                        </v-card-text>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="editDialog" fullscreen transition="dialog-bottom-transition" @keydown.esc="editDialog=false">
                        <v-toolbar color="primary" class="white--text">
                            <v-btn flat icon class="white--text" @click="editDialog=false">
                                <v-icon>close</v-icon>
                            </v-btn>

                            <v-card-title class="headline" style="text-transform: capitalize;">Editar Tag
                            {{actualitzat}}</v-card-title>

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
                                    <input prepend-icon="color_lens" type="color" v-model="tagBeingEdit.color" label="Color" hint="Color del tag " style="width: 50px; height: 50px; margin: 1%">
                                    <!--<v-text-field prepend-icon="color_lens" v-model="tagBeingEdit.color" label="Color" hint="Color del tag " placeholder="Color del tag"></v-text-field>-->
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
                                :pagination.sync="pagination"
                                class="hidden-md-and-down"
                        >
                            <v-progress-linear slot="progress" color="pink" indeterminate></v-progress-linear>
                            <template slot="items" slot-scope="{item: tag}">
                                <td>{{ tag.id}}</td>
                                <td class="text-xs-left">{{ tag.name }}</td>
                                <td class="text-xs-left">{{ tag.description }}</td>
                                <td class="text-xs-left"><v-icon x-large :color="tag.color">local_offer</v-icon></td>
                                <td class="text-xs-center">
                                    <span :title="tag.created_at_formatted">{{ tag.created_at_human}}</span>
                                </td>
                                <td class="text-xs-center">
                                    <span :title="tag.updated_at_formatted">{{ tag.updated_at_human}}</span>
                                </td>
                                <td class="text-xs-center">
                                        <v-btn v-can="tags.show" icon flat title="Mostrar la tag"
                                               @click="showShow(tag)">
                                            <v-icon color="green">visibility</v-icon>
                                        </v-btn>
                                        <v-btn v-can="tags.update" icon flat title="Editar la tag"
                                               @click="showUpdate(tag)">
                                            <v-icon color="primary">edit</v-icon>
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
                        class="white--text "
                        v-can="tags.store"
                >
                    <v-icon>add</v-icon>
                </v-btn>
            </v-flex>
                                 <v-data-iterator
                                         class="hidden-lg-and-up"
                                         :items="dataTags"
                                         :search="search"
                                         no-results-text="No s'ha trobat cap registre"
                                         no-data-text="No hiha dades disponibles"
                                         rows-per-page-text="Tags per pagina"
                                         :rows-per-page-items="[5,10,25,50,100,200,{'text':'tots','value':-1}]"
                                         :loading="loading"
                                         :pagination.sync="pagination"
                                 >
                <v-flex
                        slot="item"
                        slot-scope="{item:tag}"
                        xs12
                        sm6
                        md4
                >
                    <v-card class="mb-4">
                        <v-card-title class="pb-0"><h4 class="mb-0 font-weight-bold">Tag: {{ tag.name }}</h4></v-card-title>
                        <v-list dense  style="margin-top: 5%">
                            <v-list-tile>
                               <v-list-tile-content>Descripcio:</v-list-tile-content>
                              <v-list-tile-content class="align-end">{{ tag.description }}</v-list-tile-content>
                            </v-list-tile>
                            <v-list-tile>
                                <v-list-tile-content>Color:</v-list-tile-content>
                                <v-list-tile-content style="margin-right: -70%">
                                    <v-icon x-medium :color="tag.color">local_offer</v-icon>
                                </v-list-tile-content>
                            </v-list-tile>
                            <v-list-tile>
                                <v-list-tile-content>Detalls</v-list-tile-content>
                                <v-list-tile-content class="align-end">
                                    <div class="align-end">
                                        <v-btn v-can="tags.show" icon flat title="Mostrar la tag"
                                               @click="showShow(tag)">
                                            <v-icon color="green">visibility</v-icon>
                                        </v-btn>
                                        </div>
                                </v-list-tile-content>
                            </v-list-tile>
                            <v-list-tile>
                                <v-list-tile-content>Editar</v-list-tile-content>
                                <v-list-tile-content class="align-end">
                                    <div class="align-end">
                                        <v-btn v-can="tags.update" icon flat title="Editar la tag"
                                               @click="showUpdate(tag)">
                                            <v-icon color="primary">edit</v-icon>
                                        </v-btn>
                                        </div>
                                </v-list-tile-content>
                            </v-list-tile>
                            <v-list-tile>
                                <v-list-tile-content>Borrar</v-list-tile-content>
                                <v-list-tile-content class="align-end">
                                    <div class="align-end">
                                        <v-btn v-can="tags.destroy" icon flat title="Eliminar la tag"
                                               @click="showDestroy(tag)">
                                            <v-icon title="Delete tag" color="red">delete</v-icon>
                                        </v-btn>
                                        </div>
                                </v-list-tile-content>
                            </v-list-tile>
                            </v-list>
                    </v-card>
                </v-flex>
            </v-data-iterator>
        </span>
</template>

<script>
export default {
  name: 'Tags',
  data () {
    return {
      tagBeingShown: '',
      selectedTag: {
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
      borrat: '',
      actualitzat: '',
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
    },
    uri: {
      type: String,
      required: true
    }

  },
  computed: {
    total () {
      return this.dataTags.length
    },
    eliminar () {
      return this.selectedTag.name
    }
  },
  methods: {
    showUpdate (tag) {
      this.editDialog = true
      this.tagBeingEdit = tag
      this.actualitzat = this.tagBeingEdit.name
    },
    showShow (tag) {
      this.showDialog = true
      this.tagBeingShown = tag
    },
    opcio1 () {
    },
    createTag (tag) {
      this.dataTags.splice(0, 0, tag)
    },
    showDestroy (tag) {
      this.deleteDialog = true
      this.tagBeingRemoved = tag
      this.borrat = this.tagBeingRemoved.name
    },
    removeTag (tag) {
      this.dataTags.splice(this.dataTags.indexOf(tag), 1)
    },
    add () {
      this.creating = true
      window.axios.post(this.uri, this.selectedTag).then((response) => {
        this.createTag(response.data)
        this.$snackbar.showMessage("S'ha creat correctament la tasca")
        this.createDialog = false
      }).catch((error) => {
        this.$snackbar.showError(error)
      }).finally(() => {
        this.creating = false
        this.selectedTag.name = ''
        this.selectedTag.description = ''
        this.selectedTag.color = ''
        this.createDialog = false
      })
    },
    update () {
      this.editing = true
      window.axios.put(this.uri + '/' + this.tagBeingEdit.id, this.tagBeingEdit).then((response) => {
        this.dataTags.splice(this.dataTags.indexOf(this.tagBeingEdit), 1, response.data)
        this.$snackbar.showMessage("S'ha actualitzat correctament la tasca")
        this.editDialog = false
      }).catch((error) => {
        this.editing = false
      })
    },
    destroy (tag) {
      this.removing = true
      window.axios.delete(this.uri + '/' + this.tagBeingRemoved.id).then(() => {
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
    },
    create (tag) {
    },
    show (tag) {
      console.log('Todo show tag' + tag.id)
    },
    refresh () {
      this.loading = true
      // setTimeout(() => { this.loading = false }, 5000)
      window.axios.get(this.uri).then(response => {
        this.dataTags = response.data
        this.loading = false
        this.$snackbar.showMessage("S'han actualitzat correctament els tags ")
      }).catch(error => {
        this.$snackbar.showError(error)
        this.loading = false
      })
    }
  }
}
</script>

<style>
    .strike {
        text-decoration: line-through;
    }
</style>
