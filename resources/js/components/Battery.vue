<template>
    <div>
        <v-layout >
            <v-flex  xs6 sm2 lg2>
                <i class="color material-icons btn btn-default" slot="activator"
                   @click="show"
                   @click.stop="dialog = true"
                   :loading="batter"

                >battery_charging_full</i>
            </v-flex>
    <v-dialog
            v-model="dialog"
            width="500"
    >
      <v-card>
        <v-card-title
                class="headline primary white--text"
                primary-title
        >
          Estat de la bateria<v-icon class="white--text" style="margin-left: 2%">battery_charging_full</v-icon>
        </v-card-title>

        <v-card-text class="text-xs-center">
            <p>Estat en el que es troba la bateria: <b id="charging">unknown</b></p>
            <p>Temps per a carregar la bateria: <b id="chargingTime">unknown</b></p>
            <p>Temps per a que es descarregue la bateria: <b id="dischargingTime">unknown</b></p>
            <p>Nivell de bateria: <b id="level">unknown</b>.</p>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
                  color="primary"
                  flat
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
  name: 'Battery',
  data () {
    return {
      batter: false,
      dialog: false
    }
  },
  methods: {
    show () {
      if ('getBattery' in navigator || ('battery' in navigator && 'Promise' in window)) {
        var target = document.getElementById('target')

        function handleChange (change) {
          var timeBadge = new Date().toTimeString().split(' ')[0]
          var newState = document.createElement('p')
          newState.innerHTML = '<span class="badge">' + timeBadge + '</span> ' + change + '.'
          target.appendChild(newState)
        }

        function onChargingChange () {
          handleChange('Battery charging changed to <b>' + (this.charging ? 'Carregant' : 'Descarregant') + '</b>')
        }
        function onChargingTimeChange () {
          handleChange('Battery charging time changed to <b>' + this.chargingTime + ' s</b>')
        }
        function onDischargingTimeChange () {
          handleChange('Battery discharging time changed to <b>' + this.dischargingTime + ' s</b>')
        }
        function onLevelChange () {
          handleChange('Battery level changed to <b>' + this.level + '</b>')
        }

        var batteryPromise

        if ('getBattery' in navigator) {
          batteryPromise = navigator.getBattery()
        } else {
          batteryPromise = Promise.resolve(navigator.battery)
        }

        batteryPromise.then(function (battery) {
          document.getElementById('charging').innerHTML = battery.charging ? 'carregant' : 'descarregant'
          document.getElementById('chargingTime').innerHTML = battery.chargingTime + ' s'
          document.getElementById('dischargingTime').innerHTML = battery.dischargingTime + ' s'
          document.getElementById('level').innerHTML = battery.level

          battery.addEventListener('chargingchange', onChargingChange)
          battery.addEventListener('chargingtimechange', onChargingTimeChange)
          battery.addEventListener('dischargingtimechange', onDischargingTimeChange)
          battery.addEventListener('levelchange', onLevelChange)
        })
      }
    }
  }
}
</script>

<style scoped>

</style>
