<template>
    <span>
    <v-btn v-if="$can('user.tasks.destroy',task)" icon color="error" flat title="Eliminar la tasca"
           @click="destroy(task)" :loading="removing" :disabled="removing">
        <v-icon>delete</v-icon>
    </v-btn>
        </span>
</template>

<script>
import EventBus from './../eventBus'
export default {
  name: 'TaskDestroy',
  data () {
    return {
      removing: false

    }
  },
  props: {
    task: {
      type: Object,
      required: true
    },
    uri: {
      type: String,
      required: true
    },
    mobile: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    async destroy (task) {
      let result = await this.$confirm('Les tasques esborrades no es poden recuperar',
        {

          title: 'Esteu segurs voleu elimnar ' + task.name + '?',
          buttonTruetext: 'Eliminar',
          buttonFalsetext: 'Cancel·lar',
          color: 'error darken-1'
        })
      if (result) {
        this.removing = true
        window.axios.delete(this.uri + '/' + task.id).then(() => {
          this.$snackbar.showMessage("S'ha esborrat correctament la tasca")
          this.$emit('deleted', task)
          this.removing = false
        }).catch(error => {
          this.removing = false
        })
      }
    }
  },
  created () {
    EventBus.$on('touch-delete', (event) => {
      if (event.id === this.task.id && this.mobile) {
        this.destroy(this.task)
      }
    })
  }
}
</script>
