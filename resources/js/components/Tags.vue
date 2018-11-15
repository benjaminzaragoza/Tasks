<template>
    <v-container grid-list-md text-xs-center id="tags" class="tags">
        <v-layout row wrap>
            <v-flex xs12 justify-center>
                <v-dialog v-model="deleteDialog" width="400">
                    <v-card>
                        <v-card-title class="headline">Voleu borrar el tag {{this.tagToDelete.name}}?</v-card-title>
                        <v-card-text>
                            Aquesta operació no es pot desfer.
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="green darken-1" flat="flat" @click="deleteDialog = false">
                                Cancel·lar
                            </v-btn>
                            <v-btn color="red darken-1" dark @click="destroy()">
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
                            <v-btn id="button_add_task" dark color="green dark" flat @click="add">
                                <v-icon class="mr-2">save</v-icon>
                                Save</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <v-dialog v-model="showDialog" fullscreen transition="dialog-bottom-transition" @keydown.esc="showDialog=false">
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
                                <v-text-field prepend-icon="local_offer" v-model="name" label="Nom" hint="Nom del tag " placeholder="Nom del tag"></v-text-field>
                                <v-text-field prepend-icon="color_lens" v-model="name" label="Color" hint="Color del tag " placeholder="Color del tag"></v-text-field>
                                <v-textarea prepend-icon="description" v-model="description" label="Descripció"></v-textarea>
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
                                    <v-text-field prepend-icon="local_offer" v-model="name" label="Nom" hint="Nom del tag " placeholder="Nom del tag"></v-text-field>
                                    <v-text-field prepend-icon="color_lens" v-model="name" label="Color" hint="Color del tag " placeholder="Color del tag"></v-text-field>
                                    <v-textarea prepend-icon="description" v-model="description" label="Descripció"></v-textarea>
                                    <div class="text-xs-center">
                                        <v-btn @click="editDialog=false">
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

                <v-card>
                    <v-toolbar  dark color="red dark">
                        <v-icon>local_offer</v-icon>

                        <v-toolbar-title>Tags ({{total}})</v-toolbar-title>
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
                            <template slot="items" slot-scope="props">
                                <td>{{ props.item.id }}</td>
                                <td class="text-xs-left">{{ props.item.name }}</td>
                                <td class="text-xs-left">{{ props.item.description }}</td>
                                <td class="text-xs-left"><div class="elevation-2" :style="'background-color:' + props.item.color+';border-radius: 4px;height: 15px;width: 15px;'"></div></td>
                                <td class="text-xs-center">
                                        <!--<v-btn icon flat title="Mostrar la snackbar"-->
                                               <!--@click="snackbar=true">-->
                                            <!--<v-icon color="orange">verified_user</v-icon>-->
                                        <!--</v-btn>-->
                                        <v-btn :loading="showing" :disabled="showing" icon flat title="Mostrar la tagg"
                                               @click="showTag()">
                                            <v-icon color="green">visibility</v-icon>
                                        </v-btn>
                                        <v-btn :loading="editing" :disabled="editing" icon flat title="Editar la tag"
                                               @click="showUpdate">
                                            <v-icon color="blue">edit</v-icon>
                                        </v-btn>
                                        <v-btn icon flat title="Eliminar la tag"
                                               @click="showDestroy(props.item)">
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
                >
                    <v-icon>add</v-icon>
                </v-btn>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import EditableText from './EditableText'
var filters = {
  all: function (tags) {
    return tags
  }
}
export default {
  name: 'tags',
  components: {
    'editable-text': EditableText
  },
  data () {
    return {
      filter: 'all', // All Completed Active
      newTag: {
        name: '',
        description: '',
        color: ''
      },
      dataTags: this.tags,
      name: '',
      description: '',
      errorMessage: null,
      headers: [
        { text: 'Id', value: 'id', align: 'left', sortable: true },
        { text: 'Name', value: 'name', align: 'left', sortable: true },
        { text: 'Description', value: 'description', align: 'left', sortable: true },
        { text: 'Color', value: 'color', align: 'left', sortable: true },
        { text: 'Actions', align: 'center', sortable: false }
      ],
      loading: false,
      search: '',
      createDialog: false,
      showDialog: false,
      editDialog: false,
      deleteDialog: false,
      tagToDelete: '',
      editing: false,
      showing: false,

    }
  },
  props: {
    'tags': {
      type: Array,
      default: function () {
        return []
      }
    }
  },
  computed: {
    total () {
      return this.dataTags.length
    },
    filteredtags () {
      return filters[this.filter](this.dataTags)
    }
  },
  watch: {
    tags (newTags) {
      this.dataTags = newTags
    }
  },
  methods: {
    editName (tag, text) {
      tag.name = text
    },
    setFilter (newFilter) {
      this.filter = newFilter
    },
    add () {
      window.axios.post('/api/v1/tags', this.newTag).then((response) => {
        console.log('responde')
        console.log(response.data)
        this.refresh()
        this.newTag.name = ''
        this.newTag.description = ''
        this.newTag.color = ''
        this.loading=false
      }).catch((error) => {
        console.log(error)
      })
    },
    destroy () {
      window.axios.delete('/api/v1/tags/' + this.tagToDelete.id).then((response) => {
        this.deleteDialog = false
        this.snacktype = 'success'
        this.snackMsg = 'Tag ' + this.tagToDelete.name + ' successfully deleted!'
        this.snackbar = true
        this.dataTags.splice(this.dataTags.indexOf(this.tagToDelete), 1)
      }).catch((error) => {
        this.errorMsg = error.message
      })
    },
    // remove (tag) {
    //   axios.delete('/api/v1/tags/' + tag.id).then((response) => {
    //     this.dataTags.splice(this.dataTags.indexOf(tag), 1)
    //   }).catch((error) => {
    //
    //   })
    // },
    refresh () {
      this.loading = true
      window.axios.get('/api/v1/tags').then(response => {
        this.dataTags = response.data
      }).catch(error => {
        console.log(error)
      })
    },
    showTag () {
      this.showDialog = true
    },
    showCreate (task) {
      this.createDialog = true
    },
    showUpdate () {
      this.editDialog = true
    },
    show (tag) {
      this.showing = true
      setTimeout(() => { this.showing = false }, 5000)
      console.log('TODO MOSTRAR tag ' + tag.id)
    },
    showDestroy (tag) {
      this.tagToDelete = tag
      this.deleteDialog = true
    }
  },
  created () {
    if (this.tags.length === 0) {
      console.log('entra')
      window.axios.get('/api/v1/tags').then((response) => {
        this.dataTags = response.data
      }).catch((error) => {
        this.errorMessage = error.response.data
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
