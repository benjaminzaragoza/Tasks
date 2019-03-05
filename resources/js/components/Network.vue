<template>
    <div>
        <v-layout >
            <v-flex  xs6 sm2 lg2>
                <i class="color material-icons btn btn-default" slot="activator"
                   @click="show"
                   @click.stop="dialog = true"
                >wifi_tethering</i>
            </v-flex>
            <v-dialog
                    v-model="dialog"
                    max-width="450"
            >
                <v-card>
                    <v-card-title class="headline primary white--text"
                                  primary-title
                    >La teva xarxa<v-icon class="white--text" style="margin-left: 2%">wifi_tethering</v-icon></v-card-title>

                    <v-card-text>
                        <p>Tipus de xarxa teorica : <b id="networkType">?</b>.</p>
                        <p>Tipus de xarxa : <b id="effectiveNetworkType">?</b>.</p>
                        <p>Velocitat de baixada : <b id="downlinkMax">?</b>.</p>

                        <onlinestatus></onlinestatus>
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
    name: 'Speed',
    data () {
      return {
        spee: false,
        dialog: false
      }
    },
    methods: {
      show () {
        function getConnection () {
          return navigator.connection || navigator.mozConnection ||
            navigator.webkitConnection || navigator.msConnection
        }
        function updateNetworkInfo (info) {
          document.getElementById('networkType').innerHTML = info.type
          document.getElementById('effectiveNetworkType').innerHTML = info.effectiveType
          document.getElementById('downlinkMax').innerHTML = info.downlinkMax
        }
        var info = getConnection()
        if (info) {
          info.addEventListener('change', updateNetworkInfo)
          updateNetworkInfo(info)
        }
      }
    }
  }
</script>
<style scoped>

</style>
