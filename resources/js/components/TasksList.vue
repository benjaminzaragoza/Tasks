<template>
    <span>
        <v-toolbar color="pink darken-2">
            <v-menu>
                <v-btn slot="activator" icon dark>
                    <v-icon>more_vert</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile>
                        <v-list-tile-title>Opció 1</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile href="http://google.com">
                        <v-list-tile-title>Google</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
            <v-icon class="white--text">assignment</v-icon>
            <v-toolbar-title class="white--text">Tasques</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon class="white--text">
                <v-icon>settings</v-icon>
            </v-btn>
            <v-btn icon class="white--text" @click="refresh" :loading="loading" :disabled="loading">
                <v-icon>refresh</v-icon>
            </v-btn>
        </v-toolbar>
        <v-card>
            <v-card-title>
                <v-layout row wrap>
                    <v-flex lg3 class="pr-2">
                        <v-select
                                label="Filtres"
                                :items="filters"
                                v-model="filter"
                                item-text="name"
                                :return-object="true"
                        ></v-select>
                    </v-flex>
                    <v-flex lg4 class="pr-2">
                        <user-select
                                label="Usuari"
                                :users="dataUsers"
                        ></user-select>
                    </v-flex>
                    <v-flex lg5>
                        <v-text-field
                                append-icon="search"
                                label="Buscar"
                                v-model="search"
                        ></v-text-field>
                    </v-flex>
                </v-layout>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="getFilteredTasks"
                    :search="search"
                    no-results-text="No s'ha trobat cap registre coincident"
                    no-data-text="No hi han dades disponibles"
                    rows-per-page-text="Tasques per pàgina"
                    :rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"
                    :loading="loading"
                    :pagination.sync="pagination"
                    class="hidden-md-and-down"
            >
                <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="{item: task}">
                     <tr class="text-xs-left">
                        <td class="text-xs-left" >{{task.id}}</td>
                        <td class="text-xs-left">
                            <span  :title="task.description">{{ task.name }}</span>
                        </td>
                        <td class="text-xs-left">
                            <v-avatar :title="(task.user !== null) ? task.user_name + ' - ' + task.user_email : 'Usuari no assignat'">
                                <img :src="(task.user !== null) ? task.user_gravatar : 'http://icons.iconarchive.com/icons/hopstarter/halloween-avatar/256/Minion-Pig-icon.png'">
                            </v-avatar>
                        </td>
                        <td class="text-xs-left">
                            <task-completed-toggle :task="task"></task-completed-toggle>
                        </td>
                        <td class="text-xs-left">
                            <span  :title="task.created_at_formatted">{{ task.created_at_human}}</span>
                        </td>
                        <td class="text-xs-left" >
                            <span :title="task.updated_at_formatted">{{ task.updated_at_human}}</span>
                        </td>
                        <td class="text-xs-left">
                            <v-btn v-if="$can('user.tasks.show',tasks)" icon color="cyan" flat title="Mostrar la tasca" @click="showShow(task)">
                                <v-icon>visibility</v-icon>
                            </v-btn>

                            <v-btn v-if="$can('user.tasks.update',tasks)" icon color="success" flat title="Actualitzar la tasca" @click="showUpdate(task)">
                                <v-icon>edit</v-icon>
                            </v-btn>
                            <v-btn v-if="$can('user.tasks.destroy',tasks)" icon color="error" flat title="Eliminar la tasca" @click="destroy(task)" :loading="removing===task.id" :disabled="removing ===task.id">
                                <v-icon>delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </template>
            </v-data-table>
            <v-data-iterator class="hidden-lg-and-up"
                             :items="dataTasks"
                             :search="search"
                             no-results-text="No s'ha trobat cap registre coincident"
                             no-data-text="No hi han dades disponibles"
                             rows-per-page-text="Tasques per pàgina"
                             :rows-per-page-items="[5,10,25,50,100,200,{'text':'Tots','value':-1}]"
                             :loading="loading"
                             :pagination.sync="pagination"
            >
                <v-flex
                        slot="item"
                        slot-scope="{item:task}"
                        xs12
                        sm6
                        md4
                >
                    <v-card class="mb-1">
                        <v-card-title v-text="task.name"></v-card-title>
                        <v-list dense>
                            <v-list-tile>
                                <v-list-tile-content>Completed:</v-list-tile-content>
                                <v-list-tile-content class="align-end">{{ task.completed }}</v-list-tile-content>
                            </v-list-tile>
                            <v-list-tile>
                                <v-list-tile-content>User:</v-list-tile-content>
                                <v-list-tile-content class="align-end">{{ task.user_id }}</v-list-tile-content>
                            </v-list-tile>
                        </v-list>
                    </v-card>
                </v-flex>
            </v-data-iterator>
        </v-card>
    </span>
</template>

<script>
import TaskCompletedToggle from './TaskCompletedToggle'

export default {
  name: 'TasksList',
  data () {
    return {
      user: '',
      user_id: '',
      loading: false,
      removing: null,
      dataTasks: this.tasks,
      dataUsers: this.users,
      filter: 'Totes',
      filters: [
        { name: 'Totes', value: null },
        { name: 'Completades', value: true },
        { name: 'Pendents', value: false }
      ],
      search: '',
      pagination: {
        rowsPerPage: 25
      },
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Name', value: 'name' },
        { text: 'User', value: 'user_id' },
        { text: 'Completat', value: 'completed' },
        { text: 'Creat', value: 'created_at_timestamp' },
        { text: 'Modificat', value: 'updated_at_timestamp' },
        { text: 'Accions', sortable: false, value: 'full_search' }
      ]
    }
  },
  components: {
    'task-completed-toggle': TaskCompletedToggle
  },
  props: {
    tasks: {
      type: Array,
      required: true
    },
    users: {
      type: Array,
      required: true
    },
    uri: {
      type: String,
      required: true
    }
  },
  computed: {
    getFilteredTasks () {
      return this.dataTasks.filter((task) => {
        if (task.completed === this.filter.value || this.filter.value == null) return true
        else return false
      })
    }
  },
  methods: {
    removeTask (task) {
      this.dataTasks.splice(this.dataTasks.indexOf(task), 1)
    },
    refresh () {
      this.loading = true
      window.axios.get(this.uri).then(response => {
        this.dataTasks = response.data
        this.loading = false
        this.$snackbar.showMessage('Tasques actualitzades correctament')
      }).catch(error => {
        console.log(error)
        this.loading = false
      })
    },
    async destroy (task) {
      // ES6 async await
      let result = await this.$confirm('Les tasques esborrades no es poden recuperar',
        {
          title: 'Esteu segurs voleu elimnar ' + task.name + '?',
          buttonTruetext: 'Eliminar',
          buttonFalsetext: 'Cancel·lar',
          // icon: '',
          color: 'error'
        })
      if (result) {
        this.removing = task.id
        window.axios.delete(this.uri + '/' + task.id).then(() => {
          this.removeTask(task)
          this.deleteDialog = false
          task = null
          this.$snackbar.showMessage("S'ha esborrat correctament la tasca")
          this.removing = null
        }).catch(error => {
          this.$snackbar.showError(error.message)
          this.removing = null
        })
      }
    }

  }
}
</script>
