<template>
    <v-container grid-list-md text-xs-center id="tags" class="tags">
        <v-layout row wrap>
            <v-flex xs12 justify-center>
                <v-card>
                    <v-toolbar  dark color="red dark">
                        <v-toolbar-title>Tasques ({{total}})</v-toolbar-title>
                    </v-toolbar>

                    <v-card-text class="px-0" style="width: 502px;">
                        <form>
                            <v-text-field
                                    label=" Tasca a afeguir"
                                    type="text"
                                    v-model="newTag" @keyup.enter="add"
                                    name="name"
                                    required>
                            </v-text-field>

                            <v-btn id="button_add_tag" style="margin-right: -70%;" dark color="green dark" @click="add">Afegir</v-btn>
                        </form>

                        <div v-if="errorMessage">
                            Ha succeit un error: {{ errorMessage }}
                        </div>
                        <v-list dense>
                            <v-list-tile v-for="tag in filteredTags" :key="tag.id">
                                <v-list-tile-content>
                                    <v-list-tile-title>
                                        <span :id="'tag' + tag.id" :class="{ strike: tag.completed }">
                                        </span>
                                        <editable-text
                                                :text="tag.name"
                                                @edited="editName(tag, $event)"
                                        ></editable-text>
                                    </v-list-tile-title>
                                </v-list-tile-content>
                            </v-list-tile>
                        </v-list>

                        <span id="filters" v-show="total > 0">
                        <h3>Filtros:</h3>
                        Active filter: {{ filter }}
                        <ul>
                            <li style=" text-align: left; "><button @click="setFilter('all')">Totes</button></li>
                            <li style=" text-align: left; "><button @click="setFilter('completed')">Completades</button></li>
                            <li style=" text-align: left; "><button @click="setFilter('active')">Pendents</button></li>
                        </ul>
    </span>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
  import EditableText from './EditableText'
  var filters = {
    all: function (tags) {
      return tags
    },
    completed: function (tags) {
      return tags.filter(function (tag) {
        // return tag.completed
        // NO CAL
        if (tag.completed == '1') return true
        else return false
      })
    },
    active: function (tags) {
      return tags.filter(function (tag) {
        // return !tag.completed
        if (tag.completed == '0') return true
        else return false
      })
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
        newTag: '',
        dataTags: this.tags,
        errorMessage: null
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
        window.axios.post('/api/v1/tags', {
          name: this.newTag
        }).then((response) => {
          console.log('responde')
          console.log(response.data)
          let tag = { id: response.data.id, name: this.newTag, completed: false }
          this.dataTags.splice(0, 0, { id: response.data.id, name: this.newTag, completed: false })
          this.newTag = ''
        }).catch((error) => {
          console.log(error)
        })
      },
      remove (tag) {
        axios.delete('/api/v1/tags/' + tag.id).then((response) => {
          this.dataTags.splice(this.dataTags.indexOf(tag), 1)
        }).catch((error) => {

        })
      }
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
