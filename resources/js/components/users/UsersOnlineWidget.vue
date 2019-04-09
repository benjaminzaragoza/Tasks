<template>
    <v-menu offset-y>
        <v-badge slot="activator" left overlap color="error" class="ml-3 mr-2">
            <span slot="badge" v-text="counter"></span>
            <v-btn icon color="white" :loading="loading" :disabled="loading">
                <v-icon color="primary">person</v-icon>
            </v-btn>
        </v-badge>
        <v-list>
            todo
        </v-list>
    </v-menu>

</template>

<script>
export default {
  name: 'UsersOnlineWidget',
  data () {
    return {
      loading: false,
      users: []
    }
  },
  props: {
    channel: {
      type: String,
      default: 'App.Counter'
    }
  },
  computed: {
    counter () {
      if (this.users) return this.users.length
      return 0
    }
  },
  mounted () {
    window.Echo.join(this.channel)
      .here((users) => {
        this.users = users
      })
      .joining((user) => {
        // TODO -> USER ALREADY EXISTS?
        if (!this.users.find(u => u.id === user.id)) this.users.push(user)
      })
      .leaving((user) => {
        this.users.splice(this.users.indexOf(user), 1)
      })
  }
}
</script>
