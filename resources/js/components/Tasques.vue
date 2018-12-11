<template>
    <span>
        <v-dialog v-model="editDialog" fullscreen transition="dialog-bottom-transition" @keydown.esc="editDialog=false">
            <v-toolbar color="primary" class="white--text">
                <v-btn flat icon class="white--text" @click="editDialog=false">
                    <v-icon>close</v-icon>
                </v-btn>
                <v-card-title class="headline">Editar tasca</v-card-title>
                <v-icon class="white--text">description</v-icon>
                <v-spacer></v-spacer>
                <v-btn flat class="white--text" @click="editDialog=false">
                    <v-icon class="mr-2">exit_to_app</v-icon>
                    Sortir
                </v-btn>
                <v-btn flat class="white--text" @click="update">
                    <v-icon class="mr-2">save</v-icon>
                    Guardar
                </v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <v-form>
                        <v-text-field v-model="taskBeingEdit.name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
                        <v-switch v-model="taskBeingEdit.completed" :label="taskBeingEdit.completed ? 'Completada':'Pendent'"></v-switch>
                        <v-textarea v-model="taskBeingEdit.description" label="Descripció"></v-textarea>
                        <v-autocomplete  :readonly="!$can('tasks.index')" v-model="taskBeingEdit.user_id"  :items="dataUsers" label="Usuari" item-text="name" item-value="id"></v-autocomplete>
                        <div class="text-xs-center">
                            <v-btn @click="editDialog=false">
                                <v-icon class="mr-2">exit_to_app</v-icon>
                                Cancel·lar
                            </v-btn>
                            <v-btn color="success" @click="update">
                                <v-icon class="mr-2">save</v-icon>
                                Guardar
                            </v-btn>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
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
                        <v-text-field readonly v-model="taskBeingShown.name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
                        <v-switch readonly v-model="taskBeingShown.completed" :label="taskBeingShown.completed ? 'Completada':'Pendent'" ></v-switch>
                        <v-textarea readonly v-model="taskBeingShown.description" label="Descripció"></v-textarea>
                        <v-autocomplete readonly v-model="taskBeingShown.user_id" :items="dataUsers" label="Usuari" item-value="id" item-text="name"></v-autocomplete>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-toolbar color="pink darken-2">
            <v-menu>
                <v-btn slot="activator" icon dark>
                    <v-icon>more_vert</v-icon>
                </v-btn>
                <v-list>
                    <v-list-tile @click="opcio1">
                        <v-list-tile-title>Opció 1</v-list-tile-title>
                    </v-list-tile>
                    <v-list-tile href="http://www.google.com">
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
                        <v-select
                                label="Usuari"
                                :items="dataUsers"
                                v-model="user"
                                item-text="name"
                                :return-object="true"
                                clearable
                        ></v-select>
                    </v-flex>
                    <v-flex lg5>
                        <v-text-field
                                append-icon="search"
                                v-model="search"
                                label="Buscar"
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
                    :rows-per-page-items="[5,10,25,50,100,{'text':'Tots','value':-1}]"
                    :loading="loading"
                    :pagination.sync="pagination"
                    class="hidden-md-and-down"
            >
                <v-progress-linear slot="progress" color="blue" indeterminate></v-progress-linear>
                <template slot="items" slot-scope="{item:task}">
                    <tr class="text-xs-left">
                        <td class="text-xs-left" >{{task.id}}</td>
                        <td class="text-xs-left">
                            <span  :title="task.description">{{ task.name }}</span>
                        </td>
                        <td class="text-xs-left">
                            <v-avatar :title="task.user_name + ' - ' + task.user_email">
                                <img :src="task.user_gravatar" alt="avatar">
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
            <v-data-iterator
                    class="hidden-lg-and-up"
                    :items="dataTasks"
                    :search="search"
                    no-results-text="No s'ha trobat cap registre coincident"
                    no-data-text="No hi han dades disponibles"
                    rows-per-page-text="Tasques per pàgina"
                    :rows-per-page-items="[5,10,25,50,100,{'text':'Tots','value':-1}]"
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
        <task-create :users="users" :uri="uri" @created="refresh" ></task-create>
    </span>
</template>

<script>
import TaskCompletedToggle from './TaskCompletedToggle'
import Toggle from './Toggle'
import TaskCreate from './TaskCreate'
export default {
  name: 'Tasques',
  components: {
    TaskCreate,
    TaskCompletedToggle,
    'task-completed': TaskCompletedToggle,
    'toggle': Toggle
  },
  data () {
    return {
      taskBeingShown: '',
      newTask: {
        name: '',
        completed: false,
        user_id: '',
        description: ''
      },
      dataUsers: this.users,
      completed: false,
      name: '',
      description: '',
      eliminat: '',
      editDialog: false,
      taskBeingEdit: '',
      showDialog: false,
      user: '',
      userso: [
        'Marc Mestre',
        'Cristian Marin',
        'Sergi Baucells',
        'Benjamin Zaragoza'
      ],
      filter: { name: 'Totes', value: null },
      filters: [
        { name: 'Totes', value: null },
        { name: 'Completades', value: true },
        { name: 'Pendents', value: false }
      ],
      search: '',
      pagination: {
        rowsPerPage: 25
      },
      loading: false,
      creating: false,
      editing: false,
      removing: null,
      dataTasks: this.tasks,
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Name', value: 'name' },
        { text: 'Usuari', value: 'user_id' },
        { text: 'Completat', value: 'completed' },
        { text: 'Creat', value: 'created_at_timestamp' },
        { text: 'Modificat', value: 'updated_at_timestamp' },
        { text: 'Accions', sortable: false, value: 'full_search' }
      ]
    }
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
    showUpdate (task) {
      this.editDialog = true
      this.taskBeingEdit = task
    },
    showShow (task) {
      this.showDialog = true
      this.taskBeingShown = task
    },
    opcio1 () {
    },
    createTask (task) {
      this.dataTasks.splice(0, 0, task)
    },
    removeTask (task) {
      this.dataTasks.splice(this.dataTasks.indexOf(task), 1)
    },
    update () {
      this.editing = true
      window.axios.put(this.uri + '/' + this.taskBeingEdit.id, this.taskBeingEdit).then((response) => {
        this.dataTasks.splice(this.dataTasks.indexOf(this.taskBeingEdit), 1, response.data)
      }).catch((error) => {
        this.$snackbar.showError(error)
        this.editing = false
        this.editDialog = false
      }).finally(() => {
        // this.refresh()
        this.$snackbar.showMessage("S'ha actualitzat correctament la tasca")
        this.editing = false
        this.editDialog = false
      })
    },
    async destroy (task) {
      // es6 async await
      let result = await this.$confirm('Les tasques esborrades no es poden recuperar',
        {
          title: 'Esteu segurs voleu elimnar ' + task.name + '?',
          buttonTrueText: 'Eliminar',
          buttonFalseText: 'Cancel·lar',
          color: 'red',
          buttonTrueColor: 'error darken-1'
        })
      if (result) {
        this.removing = true
        window.axios.delete(this.uri + '/' + task.id).then(() => {
          // this.refresh()
          this.removeTask(task)
          this.deleteDialog = false
          this.task = null
          this.$snackbar.showMessage("S'ha esborrat correctament la tasca")
          this.removing = false
        }).catch(error => {
          this.$snackbar.showError(error)
          this.removing = false
        })
      }
    },
    complete (task) {
      this.taskBeingEdit = task
      this.update()
    },
    show (task) {
      console.log('Todo show task' + task.id)
    },
    refresh () {
      this.loading = true
      // setTimeout(() => { this.loading = false }, 5000)
      window.axios.get(this.uri).then(response => {
        this.dataTasks = response.data
        this.loading = false
        this.$snackbar.showMessage("S'han actualitzat correctament les tasques")
      }).catch(error => {
        this.$snackbar.showError(error)
        this.loading = false
      })
    }
  },
  created () {
    console.log(window.laravel_user)
  }
}
</script>

<style>
</style>
