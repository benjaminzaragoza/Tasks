<template>
    <v-toolbar color="primary" dark app clipped-left clipped-right fixed >
        <v-toolbar-side-icon @click.stop="$emit('toggle-left')"></v-toolbar-side-icon>
        <v-toolbar-title class="hidden-sm-and-down">Menú</v-toolbar-title>
        <img class="hidden-sm-and-down" src="img/task.png" style="margin-left: 1%;height:50%">
        <span class="hidden-sm-and-down" v-role="'SuperAdmin'" style="margin-left: 2%"><git-info></git-info></span>
        <v-spacer class="hidden-sm-and-down"></v-spacer>

        <users-online-widget></users-online-widget>

        <notifications-widget></notifications-widget>

        <h4 class="white-text mb-3 font-italic text-center hidden-sm-and-down" style="margin-top: 1%">{{ user('email') }}&nbsp;&nbsp;&nbsp;&nbsp;</h4>
        <v-avatar  @click="$emit('toggle-right')"  :title="user('name')">
            <img v-if="user('online')" style="border: lawngreen 2px solid; margin: 20px;" :src=userAvatar alt="avatar">
            <img v-else style="border: red 2px solid; margin: 20px;" :src=userAvatar alt="avatar">
        </v-avatar>
        <v-spacer class="hidden-sm-and-up"></v-spacer>
        <v-spacer class="hidden-md-and-up"></v-spacer>

        <v-btn large style="margin-left: 2%" flat icon color="white " href="/"  type="submit">
            <v-icon large>home</v-icon>
        </v-btn>
        <v-form  action="logout" method="POST" >
            <input type="hidden" name="_token" :value="csrfToken">
            <v-btn  type="submit" large style="margin-right: 50%" flat icon color="white " >
                <v-icon large>exit_to_app</v-icon>
            </v-btn>
        </v-form>
    </v-toolbar>
</template>

<script>
import NotificationsWidget from './notifications/NotificationsWidget'
import GitInfoComponent from './git/GitInfoComponent'
export default {
  name: 'MainToolbar',
  components: {
    'notifications-widget': NotificationsWidget,
    'git-info': GitInfoComponent
  },
  data () {
    return {
      userAvatar: window.laravel_user.gravatar
    }
  },
  props: {
    csrfToken: {
      Type: String,
      required: true
    }
  },
  methods: {
    user (prop) {
      return window.laravel_user[prop]
    },
    created () {
      this.user = window.laravel_user
    }
  }
}
</script>
