<template>
    <v-form>
        <v-text-field v-model="name" label="Nom" hint="Nom de la tasca" placeholder="Nom de la tasca"></v-text-field>
        <v-switch v-model="completed" :label="completed ? 'Completada':'Pendent'"></v-switch>
        <v-textarea v-model="description" label="Descripció"></v-textarea>
        <v-autocomplete  :readonly="!$can('tasks.index')" v-model="user"  :items="dataUsers" label="Usuari" item-text="name" item-value="id"></v-autocomplete>
        <div class="text-xs-center">
            <v-btn @click="$emit('close')">
                <v-icon class="mr-2">exit_to_app</v-icon>
                Cancel·lar
            </v-btn>
            <v-btn color="success" @click="update" :disabled="working" :loading="working">
                <v-icon class="mr-2">save</v-icon>
                Actualitzar
            </v-btn>
        </div>
    </v-form>
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
  },
  methods: {
    update () {
      this.working = true
      const newTask = {
        name: this.name,
        completed: this.completed,
        description: this.description,
        user_id: this.user
      }
      window.axios.put(this.uri + '/' + this.task.id, newTask).then((response) => {
        console.log(response.data)
        this.$snackbar.showMessage("S'ha actualitzat correctament la tasca")
        this.$emit('updated', response.data)
        this.$emit('close')
      }).catch((error) => {
        this.$snackbar.showError(error)
        this.working = false
      }).finally(() => {
        // this.refresh()
        this.working = false
      })
    }
  }
}
</script>
