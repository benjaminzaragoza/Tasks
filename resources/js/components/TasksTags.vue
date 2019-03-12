<template>
    <span>
        <v-chip v-for="tag in taskTags"
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
                            v-model="selectedTags"
                            :items="tags"
                            item-text="name"
                            multiple
                            @change="formatTag"
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
                    <v-btn flat @click="dialog = false" :loading="loading" :disabled="loading">Cancel·lar</v-btn>
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
  data () {
    return {
      dialog: false,
      loading: false,
      selectedTags: [],
      dataTaskTags: this.taskTags
    }
  },
  props: {
    task: {
      type: Object,
      required: true
    },
    taskTags: {
      type: Array,
      required: true
    },
    tags: {
      type: Array,
      required: true
    }
  },
  watch: {
    taskTags (taskTags) {
      this.dataTaskTags = taskTags
    }
  },
  methods: {
    formatTag () {
      var value = this.selectedTags[this.selectedTags.length - 1]
      if (typeof value === 'string') {
        this.selectedTags[this.selectedTags.length - 1] = {
          'color': 'primary',
          'name': this.selectedTags[this.selectedTags.length - 1]
        }
      }
    },
    addTag () {
      this.loading = true
      this.selectedTags.map(tag => tag.id)
      window.axios.put('/api/v1/tasks/' + this.task.id + '/tags', {
        tags: this.selectedTags.map((tag) => {
          if (tag.id) return tag.id
          else return tag.name
        })
      }).then(response => {
        this.dialog = false
        this.$snackbar.showMessage('Etiqueta/s afegides correctament')
        this.dialog = false
        this.loading = false
        this.$emit('change', this.selectedTags)
      }).catch(error => {
      })
      this.loading = false
    },
    removeTag (tag) {
      window.axios.delete('/api/v1/tasks/' + this.task.id + '/tag', { data: { tag: tag } }).then((response) => {
        this.$snackbar.showMessage(tag.name + ' eliminat correcatment')
        this.$emit('removed', response.data)
      }).catch((error) => {
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
