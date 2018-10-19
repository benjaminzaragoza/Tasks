<template>
    <div id="tasks" class=" tasks flex justify-center">
        <div class="flex flex-col">
        <h1 class="text-center text-red-light">Tasques({{total}}) </h1>

            <div class="flex-row"  >
<form>
        <input required type="text" placeholder="Nova Tasca" name='name'
               v-model="newTask" @keyup.enter="add"
               class="m-3 mt-5 p-2 pl-5 shadow border rounded focus:outline-none focus:shadow-outline text-grey-darker">

                <div v-if="errorMessage">
                    Ha succeit un error {{errorMessage}}
                </div>
                <button id="button_add_task" @click="add" class="text-center text-red"  >Afegir</button>
</form>
            </div>
            <!-- -->
        <div>
            <div v-for="task in filteredTasks" :key="task.id">
                <span :id="'task'+ task.id" :class="{ strike: task.completed == '1'}">
                    <editable-text
                            :text="task.name" @edited="editName(task, $event)"
                    ></editable-text>
                </span>
                <span :id="'delete_task_' + tasks.id" @click="remove(task)">&#215;</span>
            </div>
        </div>
<!-- -->
<br>
            <span id="filters" v-show="total > 0">
            <h3>Filtros:</h3>
            <br>
            Filtre emprat -> {{ filter }}

            <div>
                <br>
                <div><button @click="setFilter('all')">Totes</button></div>
                <div><button @click="setFilter('completed')">Completades</button></div>
                <div><button @click="setFilter('active')">Pendents</button></div>
            </div>
            </span>
        </div>
    </div>
</template>
<script>
// <!--Rquire en php -->
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
      // this.dataTasks.splice(0,0,{ name: this.newTask, completed: false } )
      // this.newTask=''
      window.axios.post('/api/v1/tasks', {
        name: this.newTask
      }).then((response) => {
        console.log('responde')
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
      console.log('entra')
      window.axios.get('/api/v1/tasks').then((response) => {
        console.log('ok')
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
    // {
    //     marca:'Renault',
    //     consum:'5l/100',
    //     start: function (){
    //         console.log('arraca');
    // }
    //
    // }
