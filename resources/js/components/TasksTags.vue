<template>
    <span>
        <v-chip v-for="tag in task.tags"
                :key="tag.id"
                :color="tag.color"
                @dblclick="removeTag(tag)"
                style="cursor: pointer; color:white"
                close
                @input="removeTag(tag)"
        >
            {{ tag.name }}
        </v-chip>
        <v-btn class="btn-dark-sm" color="secondary lighten-1" flat small icon @click="dialog = true"><v-icon>add</v-icon></v-btn>
        <v-dialog width="700" v-model="dialog" @keydown.esc="dialog = false">
            <v-card>
            <v-toolbar dark color="yellow darken-4">
                 <v-icon medium>local_offer</v-icon><v-toolbar-title>Etiquetes</v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                    <v-combobox
                            v-model="selectedTag"
                            :items="tags"
                            item-text="name"
                            item-value="name"
                            multiple
                            label="Escull o tria una etiqueta"
                            chips>
                        <template slot="selection"
                                  slot-scope="data" >
                            <v-chip
                                    :selected="data.selected"
                                    :disabled="data.disabled"
                                    :color="data.item.color"
                                    :key="JSON.stringify(data.item)"
                                    class="v-chip--select-multi"
                                    @input="data.parent.selectItem(data.item)"
                                    style="color: white;padding-right: 2%;margin-top: 2%"
                            >         <v-icon style="margin-right: 10%" small >local_offer</v-icon>{{ data.item.name }}
                            </v-chip>
                        </template>
                    </v-combobox>
                    <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="error" flat @click="dialog = false">Cancel·lar</v-btn>
                    <v-btn color="success"  @click="addTag">Afegir</v-btn>
                </v-card-actions>
                </v-card-text>
            </v-card>
        </v-dialog>
    </span>
</template>

<script>
export default {
  name: 'TasksTags',
  props: {
    task: {
      type: Object
    },
    tags: {
      type: Array
    },
    readonly: {
      type: Boolean,
      default: false
    }
  },
  data () {
    return {
      dialog: false,
      selectedTag: null
    }
  },
  methods: {
    addTag () {
      window.axios.post('/api/v1/tasks/' + this.task.id + '/tag', { tag: this.selectedTag }).then((response) => {
        this.$snackbar.showMessage(response.data.name + ' assignat correctament')
        this.dialog = false
        this.selectedTag = null
        this.$emit('added', response.data)
      }).catch((error) => {
        this.$snackbar.showError(error.response.data.message)
      })
    },
    removeTag (tag) {
      window.axios.delete('/api/v1/tasks/' + this.task.id + '/tag', { data: { tag: tag } }).then((response) => {
        this.$snackbar.showMessage( tag.name + ' eliminat correcatment')
        this.$emit('removed', response.data)
      }).catch((error) => {
        this.$snackbar.showError(error.response.data.exception)
      })
    }
  }
}
</script>

<style scoped>
@media all and (max-width: 800px) {
    .btn-dark-sm { background: #222; }
    .btn-dark-sm i.v-icon{ color:#ddd; }
}
</style>
