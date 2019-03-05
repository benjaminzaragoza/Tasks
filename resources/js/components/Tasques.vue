<template >
<span>
     <v-card>
        <snackbar></snackbar>
        <tasks-list v-show="dataTasks.length > 0" :users="users" :uri="uri" :tasks="dataTasks" :tags="tags"></tasks-list>
        <tasks-create :users="users" :uri="uri" @created="add" ></tasks-create>
     </v-card>

        <no-data-cta
            v-show="dataTasks.length == 0"
            btn-text="Crea nova tasca"
            main-text="No hi ha tasques disponibles"
            img="img/list.svg"
    ></no-data-cta>

    </span>
</template>

<script>
import TasksCreate from './TasksCreate'
import TasksList from './TasksList'
import NoDataCTA from './NoDataCTAComponent'

export default {
  name: 'Tasques',
  components: {
    'tasks-list': TasksList,
    'tasks-create': TasksCreate,
    'no-data-cta': NoDataCTA
  },
  data () {
    return {
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
    tags: {
      type: Array
      // required: true
    },
    uri: {
      type: String,
      required: true
    }
  },
  methods: {
    add (task) {
      this.dataTasks.push(task)
    }
  }
}
</script>

<style>
</style>
