<template>
    <v-container grid-list-md text-xs-center id="tags" class="tags">
        <v-layout row wrap>
            <v-flex xs12 justify-center>
                <v-dialog v-model="createDialog" fullscreen>
                    <v-card>
                        <v-toolbar>
                        </v-toolbar>
                        <v-card-text>
                            <v-container>
                                <v-layout row>
                                    <v-flex>
                                        <v-text-field v-model="newTag.name" label="Name"></v-text-field>
                                        <v-text-field v-model="newTag.description" label="Description"></v-text-field>
                                        <v-text-field v-model="newTag.color" label="Color"></v-text-field>

                                        <v-btn id="button_add_task" style="margin-right: -70%;" dark color="green dark" @click="add" >Afegir</v-btn>

                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-dialog>
                <v-card>
                    <v-toolbar  dark color="red dark">
                        <v-toolbar-title>Tags ({{total}})</v-toolbar-title>
                    </v-toolbar>

                    <v-card-text class="px-0">
                        <v-data-table
                                :headers="headers"
                                :items="dataTags"
                                :search="search"
                                no-results-text="No s'ha trobat cap registre"
                                no-data-text="No hiha dades disponibles"
                                rows-per-page-text="Tasques per pagina"
                                :rows-per-page-items="[5,10,25,50,100,200,{'text':'tots','value':-1}]"
                                :loading="loading"
                        >
                            <v-progress-linear slot="progress" color="pink" indeterminate></v-progress-linear>
                            <template slot="items" slot-scope="{item: task}">
                                <tr>
                                    <td v-text="task.id"></td>
                                    <td v-text="task.name"></td>
                                    <td v-text="task.description">Col 6</td>
                                    <td v-text="task.color"></td>
                                    <td>
                                        <v-btn icon flat title="Mostrar la snackbar"
                                               @click="snackbar=true">
                                            <v-icon color="orange">verified_user</v-icon>
                                        </v-btn>
                                        <v-btn icon flat title="Mostrar la tasca"
                                               @click="show(task)">
                                            <v-icon color="cyan">remove_red_eye</v-icon>
                                        </v-btn>
                                        <v-btn icon flat title="Actualizar la tasca"
                                               @click="update(task)">
                                            <v-icon color="green">autorenew</v-icon>
                                        </v-btn>
                                        <v-btn icon flat title="Eliminar la tasca"
                                               @click="showDestroy(task)">
                                            <v-icon color="red">delete</v-icon>
                                        </v-btn>
                                    </td>
                                </tr>
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
      errorMessage: null,
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Name', value: 'name' },
        { text: 'Description', value: 'user_id' },
        { text: 'Color', value: 'completed' },
        { text: 'Actions', sortable: false }
      ],
      loading: false,
      search: '',
      createDialog:false
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
      // Segons el filtre actiu
      // Alternativa switch/case -> array associatiu
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
      // this.datatags.splice(0,0,{ name: this.newtag, completed: false } )
      // this.newtag=''
      window.axios.post('/api/v1/tags', this.newTag).then((response) => {
        console.log('responde')
        console.log(response.data)
        this.refresh()
        this.newTag.name = ''
        this.newTag.description = ''
        this.newTag.color = ''
      }).catch((error) => {
        console.log(error)
      })
    },
    remove (tag) {
      axios.delete('/api/v1/tags/' + tag.id).then((response) => {
        this.dataTags.splice(this.dataTags.indexOf(tag), 1)
      }).catch((error) => {

      })
    },
    refresh () {
      this.loading = true
      // setTimeout(() => { this.loading = false }, 5000)
      window.axios.get('/api/v1/tags').then(response => {
        //  SHOW SNACKBAR MSISATGE OK: 'les tasques s'han actualitzar correctament'
        this.dataTags = response.data
      }).catch(error => {
        console.log(error)
        // SHOW SNACKBAR ERROR TODO
      })
    },
    showCreate (task) {
      this.createDialog = true
      console.log('Todo delete task')
    },
    // edit(tag){
    //
    // }
  },
  created () {
    if (this.tags.length === 0) {
      console.log('entra')
      window.axios.get('/api/v1/tags').then((response) => {
        console.log('ok')
        console.log(response.data)
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
