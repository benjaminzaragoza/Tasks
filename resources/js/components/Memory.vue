<template>
    <div>
        <v-layout >
            <v-flex  xs6 sm2 lg2>
                <i class="color material-icons btn btn-default" slot="activator"
                   @click="show"
                   @click.stop="dialog = true"
                >memory</i>
            </v-flex>
            <v-dialog
                    v-model="dialog"
                    max-width="290"
            >
                <v-card>
                    <v-card-title class="headline primary white--text"
                                  primary-title
                    >Memoria<v-icon class="white--text" style="margin-left: 2%">memory</v-icon></v-card-title>
                        <v-card-text>

                        <p class="font-weight-bold subheading">Actualitza! <v-btn icon @click="show" :loading="mem"> <v-icon>memory</v-icon></v-btn></p>
                            <p>Memoria del dispositiu : <b id="result"></b>&nbsp;GB</p>
                            </v-card-text>
                        <v-card-actions>

                        <v-spacer></v-spacer>
                        <v-btn
                                color="primary"
                                flat="flat"
                                @click="dialog = false"
                        >
                            Sortir
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-layout>
    </div>
</template>
<script>
export default {
  name: 'Memory',
  data () {
    return {
      dialog: false,
      mem: false
    }
  },
  methods: {
    show () {
      document.getElementById('result').innerHTML = navigator.deviceMemory || 'unknown'
    }
  }
}
</script>

<style scoped>
</style>
