<template>
<span>
    <v-form>
        <v-text-field readonly v-model="name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
        <v-switch readonly v-model="completed" :label="completed ? 'Completada':'Pendent'" ></v-switch>
        <v-textarea readonly v-model="description" label="Descripció"></v-textarea>
        <v-autocomplete readonly v-model="user" :items="dataUsers" label="Usuari" item-value="id" item-text="name"></v-autocomplete>
    </v-form>
</span>
</template>

<script>
export default {
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
    users: {
      type: Array,
      required: true
    },
    task: {
      type: Object,
      required: true
    },
    uri: {
      type: String,
      required: true
    }
  }
}
</script>
