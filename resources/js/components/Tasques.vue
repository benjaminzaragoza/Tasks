<template>
<span>
    <v-toolbar color="pink darken-2">
        <v-menu>
            <v-btn icon slot="activator" class="white--text">
                 <v-icon>more_vert</v-icon>
            </v-btn>
            <v-list>
                <v-list-tile @click="opcio1">
                    <v-list-tile-title>Opcio1</v-list-tile-title>
                </v-list-tile>
                <v-list-tile href="http://www.google.es">
                    <v-list-tile-title>Google</v-list-tile-title>
                </v-list-tile>
            </v-list>
        </v-menu>
        <v-toolbar-title class="white--text">Tasques</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon class="white--text">
            <v-icon>settings</v-icon>
        </v-btn>
        <v-btn icon class="white--text" @click="refresh" :loading="loading" :disabled="loading">
            <v-icon>refresh</v-icon>
        </v-btn>
    </v-toolbar>
    <v-card>
        <v-card-title>
            TODO FILTRES
        </v-card-title>
        CONTENT
        <v-data-table
                :headers="headers"
                :items="dataTasks"
                no-results-text="No s'ha trobat cap registre"
                no-data-text="No hiha dades disponibles"
                rows-per-page-text="Tasques per pagina"
                :rows-per-page-items="[5,10,25,50,100,200,{'text':'tots','value':-1}]"
                :loading="loading"
        >
            <v-progress-linear slot="progress" color="pink" indeterminate></v-progress-linear>
            <template slot="items" slot-scope="{item: task}">
                <tr>
                    <td v-text="task.id"></td>
                    <td v-text="task.name"></td>
                    <td v-text="task.user_id">Col 6</td>
                    <td v-text="task.completed"></td>
                    <td v-text="task.created_at"></td>
                    <td v-text="task.updated_at"></td>
                    <td>
                        <v-btn icon  title="Mostrar la tasca"
                               @click="show(task)">
                            <v-icon color="cyan">remove_red_eye</v-icon>
                        </v-btn>
                        <v-btn icon  title="Actualizar la tasca"
                               @click="update(task)">
                            <v-icon color="green">autorenew</v-icon>
                        </v-btn>
                        <v-btn icon  title="Eliminar la tasca"
                        @click="destroy(task)">
                            <v-icon color="red">delete</v-icon>
                        </v-btn>
                    </td>
                </tr>
            </template>
        </v-data-table>
        <v-btn
        @click="showCreateDialog"
        fab
        bottom
        right
        fixed
        large
        color="orange"
        class="white--text"
        >
            <v-icon>add</v-icon>
        </v-btn>
    </v-card>
</span>
</template>

<script>
export default {
  name: 'Tasques',
  data () {
    return {
      loading: false,
      dataTasks: [
        {
          id: 1,
          name: 'Comprar pa',
          completed: false,
          user_id: 1,
          created_at: 'fa 1 minut',
          updated_at: 'fa 1 minut'
        },
        {
          id: 2,
          name: 'Comprar llet',
          completed: false,
          user_id: 1,
          created_at: 'fa 1 minut',
          updated_at: 'fa 1 minut'
        },
        {
          id: 3,
          name: 'Estudiar PHP',
          completed: true,
          user_id: 2,
          created_at: 'fa 1 minut',
          updated_at: 'fa 1 minut'
        }
      ],
      headers: [
        { text: 'Id', value: 'id' },
        { text: 'Name', value: 'name' },
        { text: 'User_id', value: 'user_id' },
        { text: 'Completat', value: 'completed' },
        { text: 'Creat', value: 'created_at' },
        { text: 'Modificat', value: 'updated_at' },
        { text: 'Actions', sortable: false }
      ]
    }
  },
  methods: {
    opcio1 () {
      console.log('todo')
    },
    destroy (task) {
      console.log('todo delete' + task.id)
    },
    create (task) {
      console.log('todo create')
    },
    update (task) {
      console.log('todo update' + task.id)
    },
    show (task) {
      console.log('todo show' + task.id)
    },
    refresh () {
      this.loading = true
      setTimeout(() => { this.loading = false }, 5000)
      // todo axios
      console.log('todo refresh')
    },
    showCreateDialog () {
      console.log('todo create dialog')
    }

  }
}
</script>
