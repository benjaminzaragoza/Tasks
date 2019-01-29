<template>
<span>
    <v-menu>
         <v-badge slot="activator" left color="red" overlap>
        <span slot="badge" >6</span>
            <v-btn fab small color="primary">
                <v-icon  >notifications</v-icon>
            </v-btn>
    </v-badge>
    <v-list>
            <v-list-tile>
            <v-list-tile-title @click="notify">
                     </v-list-tile-title>
                </v-list-tile>
            <v-list-tile>
            <v-list-tile-title>Notification 2</v-list-tile-title>
                </v-list-tile>
            <v-list-tile>
            <v-list-tile-title>Notification 3</v-list-tile-title>
                </v-list-tile>
            <v-list-tile>
            <v-list-tile-title>Notification 4</v-list-tile-title>
                </v-list-tile>
        </v-list>
    </v-menu>

</span>
</template>

<script>
export default {
  name: 'NotificationsWidget',
  data () {
    return {
      data: ''
    }
  },
  methods: {
    notify () {
      if (!('Notification' in window)) {
        this.$snackbar.showError('asda')
      } else {
        if (Notification.permission === 'default') {
          Notification.requestPermission().then(function (result) {
            console.log(result)
            new Notification('Hola caracola')
          })
        }
        if (Notification.permission === 'granted') {
          new Notification('Hola caracola')
        }
      }
    }
  }
}
</script>
