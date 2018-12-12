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
                        <v-text-field v-model="name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
                        <v-switch v-model="completed" :label="completed ? 'Completada':'Pendent'"></v-switch>
                        <v-textarea v-model="description" label="Descripció"></v-textarea>
                        <v-autocomplete  :readonly="!$can('tasks.index')" v-model="user_id"  :items="dataUsers" label="Usuari" item-text="name" item-value="id"></v-autocomplete>
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

        <tasks-list :users="users" :uri="uri" :tasks="tasks"></tasks-list>
        <tasks-create :users="users" :uri="uri" @created="add" ></tasks-create>

    </span>
</template>

<script>
import TaskCompletedToggle from './TaskCompletedToggle'
import TasksCreate from './TasksCreate'
import TasksList from './TasksList'
export default {
  name: 'Tasques',
  components: {
    'task-completed-toggle': TaskCompletedToggle,
    'tasks-list': TasksList,
    'tasks-create': TasksCreate
  },
  data () {
    return {
      taskBeingShown: '',
      completed: false,
      dataUsers: this.users,
      user_id: '',
      name: '',
      description: '',
      editDialog: false,
      showDialog: false,
      dataTasks: this.tasks
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
    // showUpdate (task) {
    //   this.editDialog = true
    //   this.taskBeingEdit = task
    // },
    add (task) {
      this.dataTasks.push(task)
    },
    showShow (task) {
      this.showDialog = true
      this.taskBeingShown = task
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
