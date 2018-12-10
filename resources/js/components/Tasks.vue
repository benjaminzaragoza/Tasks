<template>
    <v-container grid-list-md text-xs-center id="tasks" class="tasks">
        <v-layout row wrap>
            <v-flex xs12 justify-center>
                <v-card>
                    <v-toolbar  dark color="red dark">
                        <v-toolbar-title style="margin-left: 40%">Tasques ({{total}})</v-toolbar-title>
                    </v-toolbar>

                    <v-card-text class="px-0" style="width: 502px;">
                        <form>
                            <v-text-field
                                    label=" Tasca a afeguir"
                                    type="text"
                                    v-model="newTask" @keyup.enter="add"
                                    name="name"
                                    required
                            >
                            </v-text-field>

                            <v-btn id="button_add_task" style="margin-right: -70%;" dark color="green dark" @click="add">Afegir</v-btn>
                        </form>

                        <div v-if="errorMessage">
                            <!--Ha succeit un error: {{ errorMessage }}-->
                        </div>
                        <v-list dense>
                            <v-list-tile v-for="task in filteredTasks" :key="task.id">
                                <v-list-tile-content>
                                    <v-list-tile-title>
                                        <span :id="'task' + task.id" :class="{ strike: task.completed }">
                                        </span>
                                        <editable-text
                                                :text="task.name"
                                                @edited="editName(task, $event)"
                                        ></editable-text>
                                        <svg :id="'deleteTask' + task.id" xmlns="http://www.w3.org/2000/svg"
                                             @click="remove(task)"
                                             class="h-3 w-3 cursor-pointer ml-2 fill-current text-red"
                                             viewBox="0 0 20 20">
                                            <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zM11.4 10l2.83-2.83-1.41-1.41L10 8.59 7.17 5.76 5.76 7.17 8.59 10l-2.83 2.83 1.41 1.41L10 11.41l2.83 2.83 1.41-1.41L11.41 10z"/>
                                        </svg>
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
  all: function (tasks) {
    return tasks
  },
  completed: function (tasks) {
    return tasks.filter(function (task) {
      // return task.completed
      // NO CAL
      if (task.completed == '1') return true
      else return false
    })
  },
  active: function (tasks) {
    return tasks.filter(function (task) {
      // return !task.completed
      if (task.completed == '0') return true
      else return false
    })
  }
}
export default {

  name: 'Tasks',
  components: {
    'editable-text': EditableText
  },
  data () {
    return {
      filter: 'all', // All Completed Active
      newTask: '',
      dataTasks: this.tasks,
      errorMessage: null
    }
  },
  props: {
    'tasks': {
      type: Array,
      default: function () {
        return []
      }
    }
  },
  computed: {
    total () {
      return this.dataTasks.length
    },
    filteredTasks () {
      // Segons el filtre actiu
      // Alternativa switch/case -> array associatiu
      return filters[this.filter](this.dataTasks)
    }
  },
  watch: {
    tasks (newTasks) {
      this.dataTasks = newTasks
    }
  },
  methods: {
    editName (task, text) {
      task.name = text
    },
    setFilter (newFilter) {
      this.filter = newFilter
    },
    add () {
      if (this.newTask === '') return
      window.axios.post('/api/v1/tasks', {
        name: this.newTask
      }).then((response) => {
        console.log(response.data)
        let task = { id: response.data.id, name: this.newTask, completed: false }
        this.dataTasks.splice(0, 0, { id: response.data.id, name: this.newTask, completed: false })
        this.newTask = ''
      }).catch((error) => {
        console.log(error)
      })
    },
    remove (task) {
      axios.delete('/api/v1/tasks/' + task.id).then((response) => {
        this.dataTasks.splice(this.dataTasks.indexOf(task), 1)
      }).catch((error) => {

      })
    }
    // edit(task){
    //
    // }
  },
  created () {
    if (this.tasks.length === 0) {
      window.axios.get('/api/v1/tasks').then((response) => {
        console.log(response.data)
        this.dataTasks = response.data
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
