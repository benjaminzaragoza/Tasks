<template>
    <span>
        <tasks-list :users="users" :uri="uri" :tasks="dataTasks" ></tasks-list>
        <tasks-create :users="users" :uri="uri" @created="add" ></tasks-create>
    </span>
</template>

<script>
import TasksCreate from './TasksCreate'
import TasksList from './TasksList'
export default {
  name: 'Tasques',
  components: {
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
    add (task) {
      this.dataTasks.push(task)
    },
    createTask (task) {
      this.dataTasks.splice(0, 0, task)
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
