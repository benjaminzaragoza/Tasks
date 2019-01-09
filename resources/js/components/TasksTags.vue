<template>
    <span>
        <!--<v-chip v-for="tag in task.tags" :key="tag.id" v-text="tag.name" :color="tag.color" @dblclick="removeTag" style="padding: 5%;cursor: pointer; color:white" ></v-chip>-->
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
        <v-btn color="secondary lighten-1" flat small icon @click="dialog = true"><v-icon>add</v-icon></v-btn>
        <v-dialog v-model="dialog" width="700" @keydown.esc="dialog = false">
            <v-card>
            <v-toolbar dark color="yellow darken-4">
                           <v-icon medium>local_offer</v-icon><v-toolbar-title>Etiquetes </v-toolbar-title>
                </v-toolbar>
                <v-card-text>
                     <v-combobox
                             v-model="selectedTag"
                             :items="tags"
                             item-text="name"
                             item-value="name"
                             label="Escull o tria una etiqueta"
                             multiple
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
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="error" flat @click="dialog = false">Cancel·lar</v-btn>
                    <v-btn color="success"  @click="addTag">Afegir</v-btn>
                </v-card-actions>
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
      selectedTag: []
    }
  },
  props: {
    task: {
      type: Object
    },
    tags: {
      type: Array
    }
  },
  methods: {
    addTag () {
      window.axios.post('/api/v1/tasks/' + this.task.id + '/tag', { tag: this.selectedTag }).then((response) => {
        this.$snackbar.showMessage('Tag ' + response.data.name + ' assigned correctly')
        this.dialog = false
        this.selectedTag = []
        this.$emit('added', response.data)
      }).catch((error) => {
        console.log(error.response.data.exception)
        this.$snackbar.showError(error.response.data.message)
      })
    },
    async removeTag (tag) {
      let result = await this.$confirm('',
        { title: 'Esteu segurs que voleu eliminar ' + tag.name + ' ?', buttonTrueText: 'Eliminar', buttonFalseText: 'Cancel·lar', color: 'error darken-1' })
      if (result) {
        window.axios.delete('/api/v1/tasks/' + this.task.id + '/tag', { data: { tag: tag } }).then((response) => {
          console.log(response.data)
          this.$snackbar.showMessage('Tag ' + tag.name + ' removed successfully')
          this.$emit('removed', response.data)
        }).catch((error) => {
          console.log(error.response)
          this.$snackbar.showError(error.response)
        })
      }
    }
  }
}
</script>
