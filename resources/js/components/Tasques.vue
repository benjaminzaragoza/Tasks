<template>
    <span>
        <v-dialog v-model="deleteDialog" width="400">
            <v-card>
                <v-card-title class="headline">Esteu segurs?</v-card-title>
                <v-card-text>
                    Aquesta operació no es pot desfer.
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                      <v-btn color="green darken-1" flat="flat" @click="deleteDialog = false">
                        Cancel·lar
                      </v-btn>
                      <v-btn color="error darken-1" flat="flat" @click="destroy"
                             :loading="removing"
                             :disabled="removing">
                        Confirmar
                      </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog v-model="createDialog" fullscreen transition="dialog-bottom-transition" @keydown.esc="createDialog=false">
            <v-toolbar color="primary" class="white--text">
                <v-btn flat icon class="white--text" @click="createDialog=false">
                    <v-icon>close</v-icon>
                </v-btn>
                <v-card-title class="headline">Crear tasca</v-card-title>
                <v-spacer></v-spacer>
                <v-btn flat class="white--text" @click="createDialog=false">
                    <v-icon class="mr-2">exit_to_app</v-icon>
                    Sortir
                </v-btn>
                <v-btn flat class="white--text" @click="add">
                    <v-icon class="mr-2">save</v-icon>
                    Guardar
                </v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <v-form>
                        <v-text-field v-model="newTask.name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
                        <v-switch v-model="newTask.completed" :label="newTask.completed ? 'Completada':'Pendent'"></v-switch>
                        <v-textarea v-model="newTask.description" label="Descripció"></v-textarea>
                        <v-autocomplete v-model="newTask.user_id" :items="dataUsers" label="Usuari" item-text="name" item-value="id"></v-autocomplete>
                        <div class="text-xs-center">
                            <v-btn @click="createDialog=false">
                                <v-icon class="mr-2">exit_to_app</v-icon>
                                Cancel·lar
                            </v-btn>
                            <v-btn color="success" @click="add" >
                                <v-icon class="mr-2">save</v-icon>
                                Guardar
                            </v-btn>
                        </div>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="editDialog" fullscreen transition="dialog-bottom-transition" @keydown.esc="editDialog=false">
            <v-toolbar color="primary" class="white--text">
                <v-btn flat icon class="white--text" @click="editDialog=false">
                    <v-icon>close</v-icon>
                </v-btn>
                <v-card-title class="headline">Editar tasca</v-card-title>
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
                        <v-text-field v-model="taskBeingEdit.name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
                        <v-switch v-model="taskBeingEdit.completed" :label="taskBeingEdit.completed ? 'Completada':'Pendent'"></v-switch>
                        <v-textarea v-model="taskBeingEdit.description" label="Descripció"></v-textarea>
                        <v-autocomplete v-model="taskBeingEdit.user_id"  :items="dataUsers" label="Usuari" item-text="name" item-value="id"></v-autocomplete>
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
                <v-btn flat class="white--text">
                    <v-icon class="mr-1">save</v-icon>
                    Guardar
                </v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <v-form>
                        <v-text-field disabled v-model="taskBeingShown.name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
                        <v-switch disabled v-model="taskBeingShown.completed" :label="taskBeingShown.completed ? 'Completada':'Pendent'" ></v-switch>
                        <v-textarea disabled v-model="taskBeingShown.description" label="Descripció"></v-textarea>
                        <v-autocomplete disabled v-model="taskBeingShown.user_id" :items="dataUsers" label="Usuari" item-value="id" item-text="name"></v-autocomplete>
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
                    :items="dataTasks"
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
                    <tr>
                        <td>{{task.id}}</td>
                        <td>
                            <span :title="task.description">{{ task.name }}</span>
                        </td>
                        <td>
                            <v-avatar :title="task.user_name">
                                <img :src="task.user_gravatar" alt="avatar">
                            </v-avatar>
                        </td>
                        <td>
                          <v-switch v-model="task.completed" :label="task.completed ? 'Completada' : 'Pendent'" @change="complete(task)"></v-switch>
                        </td>
                        <td>
                            <span :title="task.created_at_formatted">{{ task.created_at_human}}</span>
                        </td>
                        <td>
                            <span :title="task.updated_at_formatted">{{ task.updated_at_human}}</span>
                        </td>
                        <td>
                            <!--<v-btn icon color="orange" flat title="Mostrar snackbar" @click="snackbar=true">-->
                                <!--<v-icon>info</v-icon>-->
                            <!--</v-btn>-->
                            <v-btn v-can="tasks.show" icon color="cyan" flat title="Mostrar la tasca" @click="showShow(task)">
                                <v-icon>visibility</v-icon>
                            </v-btn>

                            <v-btn v-can="tasks.update" icon color="success" flat title="Actualitzar la tasca" @click="showUpdate(task)">
                                <v-icon>edit</v-icon>
                            </v-btn>
                            <v-btn v-can="tasks.destroy" icon color="error" flat title="Eliminar la tasca" @click="showDestroy(task)">
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
        <v-btn
                @click="showCreate"
                fab
                bottom
                right
                fixed
                large
                color="pink accent-3"
                class="white--text"
                v-if="$can('tasks.store')"
        >
            <v-icon>add</v-icon>
        </v-btn>
    </span>
</template>

<script>
export default {
  name: 'Tasques',
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
      createDialog: false,
      deleteDialog: false,
      editDialog: false,
      taskBeingRemoved: '',
      taskBeingEdit: '',
      showDialog: false,
      user: '',
      userso: [
        'Marc Mestre',
        'Cristian Marin',
        'Sergi Baucells',
        'Benjamin Zaragoza'
      ],
      filter: 'Totes',
      filters: [
        'Totes',
        'Completades',
        'Pendents'
      ],
      search: '',
      pagination: {
        rowsPerPage: 25
      },
      loading: false,
      creating: false,
      editing: false,
      removing: false,
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
      console.log('Todo Opcio')
    },
    createTask (task) {
      this.dataTasks.splice(0, 0, task)
    },
    showDestroy (task) {
      this.deleteDialog = true
      this.taskBeingRemoved = task
    },
    removeTask (task) {
      this.dataTasks.splice(this.dataTasks.indexOf(task), 1)
    },
    add () {
      window.axios.post(this.uri, this.newTask).then((response) => {
        this.createTask(response.data)
        this.$snackbar.showMessage("S'ha creat correctament la tasca")
        this.createDialog = false
      }).catch((error) => {
        this.$snackbar.showError(error)
      })
    },
    update () {
      this.editing = true
      window.axios.put(this.uri + this.taskBeingEdit.id, this.taskBeingEdit).then((response) => {
        this.dataTasks.splice(this.dataTasks.indexOf(this.taskBeingEdit), 1, response.data)
        this.$snackbar.showMessage("S'ha actualitzat correctament la tasca")
        this.editDialog = false
      }).catch((error) => {
        this.editing = false
      })
    },
    destroy (task) {
      this.removing = true
      window.axios.delete(this.uri + this.taskBeingRemoved.id).then(() => {
        // this.refresh()
        this.removeTask(this.taskBeingRemoved)
        this.deleteDialog = false
        this.taskBeingRemoved = null
        this.$snackbar.showMessage("S'ha esborrat correctament la tasca")
        this.removing = false
      }).catch(error => {
        this.$snackbar.showError(error)
        this.removing = false
      })
    },
    showCreate (task) {
      this.createDialog = true
      console.log('Todo delete task')
    },
    create (task) {
      console.log('Todo delete task')
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
    console.log('Usuari logat')
    console.log(window.laravel_user)
  }
}
</script>

<style>
</style>
