<template>
<span>
    <v-form>
        <v-text-field readonly v-model="name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
        <v-switch readonly v-model="completed" :label="completed ? 'Completada':'Pendent'" ></v-switch>
        <v-textarea readonly v-model="description" label="Descripció"></v-textarea>
        <user-select readonly v-model="user" :users="dataUsers" label="Usuari"></user-select>
    </v-form>
</span>
</template>

<script>
import UserSelect from './UserSelect'

export default {
  name: 'TaskShowForm',
  components: {
    'user-select': UserSelect
  },
  data () {
    return {
      name: this.task.name,
      completed: this.task.completed,
      dataUsers: this.users,
      user: this.task.user,
      description: this.task.description,
      working: false
    }
  },
  props: {
    task: {
      type: Object,
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
    showUser (task) {
      this.user = this.users.find((user) => {
        return parseInt(user.id) === parseInt(task.user_id)
      })
    }
  },
  created () {
    this.showUser(this.task)
  }
}
</script>
