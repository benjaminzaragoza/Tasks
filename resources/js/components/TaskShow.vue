<template>
<span>
        <v-dialog v-model="dialog" :fullscreen="$vuetify.breakpoint.smAndDown" transition="dialog-bottom-transition"
                  @keydown.esc="dialog=false">
            <v-toolbar color="secondary  lighten-1" class="white--text">
                <v-btn icon flat class="white--text">
                    <v-icon @click="dialog=false">close</v-icon>
                </v-btn>
                <v-toolbar-title class="white--text mr-3">Detalls tasca</v-toolbar-title>
                <v-icon class="white--text">visibility</v-icon>
                <v-spacer></v-spacer>
                <v-btn flat class="white--text" @click="dialog=false">
                    <v-icon class="mr-1" >exit_to_app</v-icon>
                    SORTIR
                </v-btn>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <task-show-form :task="task" :uri="uri" :users="users" @close="dialog=false" @show="show"></task-show-form>
                </v-card-text>
            </v-card>
        </v-dialog>
    <v-btn v-if="$can('user.tasks.show',task)" icon color="cyan" flat title="Mostrar la tasca" @click="dialog=true">
    <v-icon>visibility</v-icon>
    </v-btn>
</span>
</template>

<script>
import TaskShowForm from './TaskShowForm'
export default {
  name: 'TaskUpdate',
  components: {
    'task-show-form': TaskShowForm
  },
  data () {
    return {
      dialog: false
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
    show (task) {
      this.$emit('show', task)
    }
  }
}
</script>
