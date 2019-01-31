<template>
    <v-menu offset-y>
        <v-list two-line>
            <v-list-tile avatar @click="notify">
                <v-list-tile-avatar>
                    <v-icon>notifications</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-title>Notification 1</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile avatar @click="notify">
                <v-list-tile-avatar>
                    <v-icon>notifications</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-title>Notification 2</v-list-tile-title>
                </v-list-tile-content>
            </v-list-tile>
            <v-list-tile avatar>
                <v-list-tile-avatar>
                    <v-icon>notifications</v-icon>
                </v-list-tile-avatar>
                <v-list-tile-content>
                    <v-list-tile-title>Notification 3</v-list-tile-title>
                </v-list-tile-content>

            </v-list-tile>
        </v-list>
        <v-btn flat icon slot="activator" style="margin-left: -80%;">
            <v-badge right color="red">
                <span slot="badge">6</span>
                <v-icon>notifications</v-icon>
            </v-badge>
        </v-btn>
    </v-menu>
</template>

<script>
  export default {
    name: 'NotificationsWidget',
    methods: {
      notify () {
        if (!('Notification' in window)) {
          this.$snackbar.showError('This browser does not support desktop notification')
        } else {
          if (Notification.permission === 'default') {
            Notification.requestPermission().then(function (result) {
              console.log(result)
              new Notification('Hi there!')
            })
          }
          console.log(Notification.permission)
          if (Notification.permission === 'granted') {
            new Notification('Hi there!')
          }
        }
      }
    }
  }
</script>
