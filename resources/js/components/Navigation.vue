<template>
    <v-navigation-drawer
            v-model="dataDrawer"
            :mini-variant.sync="mini"
            fixed
            app
            clipped
            left
    >
        <v-toolbar flat class="transparent " >
            <v-list class="pa-0 " >
                <v-list-tile avatar >
                    <v-list-tile-avatar >
                        <img :src=userAvatar alt="avatar">
                    </v-list-tile-avatar>
                    <v-list-tile-content>
                        <v-list-tile-title>{{ user('name') }}</v-list-tile-title>
                    </v-list-tile-content>
                    <v-list-tile-action class="hidden-sm-and-down">
                        <v-btn
                                icon
                                @click.stop="mini = !mini"
                        >
                            <v-icon >chevron_left</v-icon>
                        </v-btn>
                    </v-list-tile-action>
                </v-list-tile>
            </v-list>
        </v-toolbar>

        <v-list class="pt-0" dense >
            <v-divider></v-divider>
            <template v-for="item in items">
                <v-layout
                        v-if="item.heading"
                        :key="item.heading"
                        row
                        align-center
                >
                    <v-flex xs6>
                        <v-subheader v-if="item.heading">
                            {{ item.heading }}
                        </v-subheader>
                    </v-flex>

                    <v-flex xs6 class="text-xs-center">
                        <a href="#!" class="body-2 black--text">EDIT</a>
                    </v-flex>
                </v-layout>

                <v-list-group
                        v-else-if="item.children"
                        v-model="item.model"
                        :key="item.text"
                        :prepend-icon="item.model ? item.icon : item['icon-alt']"
                        append-icon=""
                >
                    <v-list-tile slot="activator" :href="item.url"  >
                        <v-list-tile-content>
                            <v-list-tile-title>
                                {{ item.text }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                    <v-list-tile
                            v-for="(child, i) in item.children"
                            :key="i"
                            :href="child.url"
                            :style="selectedStyle(child)"
                    >
                        <v-list-tile-action v-if="child.icon"  >
                            <v-icon >{{ child.icon }}</v-icon>
                        </v-list-tile-action>
                        <v-list-tile-content :href="item.url">
                            <v-list-tile-title >
                                {{ child.text }}
                            </v-list-tile-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </v-list-group>

                <v-list-tile :style="selectedStyle(item)" v-else :key="item.text" :href="item.url">
                    <v-list-tile-action >
                        <v-icon >{{ item.icon }}</v-icon>
                    </v-list-tile-action>
                    <v-list-tile-content>
                        <v-list-tile-title>
                            {{ item.text }}
                        </v-list-tile-title>
                    </v-list-tile-content>
                </v-list-tile>
            </template>
        </v-list>
    </v-navigation-drawer>

</template>

<script>
export default {
  name: 'Navigation',
  data () {
    return {
      userAvatar: window.laravel_user.gravatar,
      dataDrawer: this.drawer,
      mini: this.mini,
      nom: '',
      items: [
        { icon: 'home', text: 'Tasques', url: '/tasks' },
        {
          icon: 'keyboard_arrow_up',
          'icon-alt': 'keyboard_arrow_down',
          text: 'Tipus de Tasca',
          model: false,
          children: [
            { icon: 'assignment_turned_in', text: 'Tasques amb PHP', url: '/tasks' },
            { icon: 'assignment', text: 'Tasques amb Tailwind', url: '/tasks_vue' },
            { icon: 'insert_chart', text: 'Tasques amb Vue', url: '/tasques' }
          ]
        },
        { icon: 'local_offer', text: 'Tags', url: '/tags' },
        { icon: 'help', text: 'Sabem mes', url: '/about' },
        { icon: 'camera', text: 'Perfil', url: '/profile' },
        { icon: 'notifications', text: 'Notificacions', url: '/notifications' },
        { icon: 'add_alert', text: 'Registre Activitats', url: '/changelog' },
        { icon: 'photo', text: 'Imatges', url: '/contact' },
        { icon: 'phonelink_setup', text: 'Functions', url: '/functions' },
        { icon: 'contact_mail', text: 'Newsletter', url: '/newsletters' },
        { icon: 'watch_later', text: 'Clock', url: '/clock' },
        { icon: 'chat', text: 'Chat', url: '/chat' },
        { icon: 'person', text: 'Users', url: '/users' },
        { icon: 'games', text: 'Game', url: '/game' },
        { icon: 'play_arrow', text: 'Multimedia', url: '/multimedia' }
      ]
    }
  },
  props: {
    drawer: {
      Type: Boolean,
      default: false
    }
  },
  watch: {
    dataDrawer (drawer) {
      this.$emit('input', drawer)
    },
    drawer (drawer) {
      this.dataDrawer = drawer
    }
  },
  model: {
    prop: 'drawer',
    event: 'input'
  },
  methods: {
    user (prop) {
      return window.laravel_user[prop]
    },
    isSelectedItem (item) {
      const currentPath = window.location.pathname
      return currentPath === item.url
    },
    selectedStyle (item) {
      if (this.isSelectedItem(item)) {
        return {
          'border-left': '5px solid #4828d7',
          'background-color': '#F0F4F8',
          'font-size': '1em'
        }
      }
    }
  }
}
</script>
