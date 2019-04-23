<template>
    <span>
         <v-container fluid text-xs-center class="ma-0 pa-0">
          <v-layout row wrap>
        <v-toolbar color="primary" class="ml-3">
            <v-avatar>
                    <img :src="user.gravatar">
                </v-avatar>
            <v-toolbar-title>Channels</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-tooltip bottom>
                <v-btn icon slot="activator">
                    <v-icon color="secondary">channel</v-icon>
                </v-btn>
                <span>Nova conversació</span>
            </v-tooltip>
            <v-tooltip bottom>
                <v-btn icon slot="activator">
                    <v-icon>more_vert</v-icon>
                </v-btn>
                <span>Menú</span>
            </v-tooltip>
        </v-toolbar>

            <v-flex xs12 style="height: 64px;">
              <v-card dark color="cyan" style="height: 64px;">
                <v-card-text class="px-0">TODO activar notificacions d'escriptori</v-card-text>
              </v-card>
            </v-flex>
            <v-flex xs12>
              <v-card dark style="height: 64px;">
                  search here
              </v-card>
            </v-flex>
            <v-flex xs12 class="scroll-y ml-4" style="max-height: calc(100vh - 64px - 64px - 64px - 64px)">
                <contacts-list :channels="items"></contacts-list>
            </v-flex>
          </v-layout>
        </v-container>
    </span>
</template>

<script>
import ContactsList from './ContactsList'

export default {
  name: 'ChatChannels',
  components: { ContactsList },
  data () {
    return {
      items:
        [ {
          avatar: 'https://cdn.vuetifyjs.com/images/lists/1.jpg',
          msgcount: 0,
          action: '15 min ago',
          headline: 'Brunch this weekend?',
          title: 'Ali Connors',
          subtitle: "I'll be in your neighborho?"
        },
        {
          avatar: 'https://cdn.vuetifyjs.com/images/lists/2.jpg',
          msgcount: 2,
          action: '18:50',
          headline: 'Summer BBQ',
          title: 'Jennifer',
          subtitle: 'Wish I couldeekend.'
        },
        {
          avatar: 'https://cdn.vuetifyjs.com/images/lists/3.jpg',
          msgcount: 4,
          action: '19:00',
          headline: 'Oui oui',
          title: 'Sandra Adams',
          subtitle: 'Do youever been?'
        },
        {
          avatar: 'https://cdn.vuetifyjs.com/images/lists/4.jpg',
          msgcount: 9,
          action: '20:10',
          headline: 'Birthday gift',
          title: 'Trevor Hansen',
          subtitle: 'Have her birthday?'
        },
        {
          avatar: 'https://cdn.vuetifyjs.com/images/lists/5.jpg',
          msgcount: 6,
          action: 'Ahir',
          headline: 'Recipe to try',
          title: 'Britta Holt',
          subtitle: 'We should eat this: , Squash, Corn, and tomatillo Tacos.'
        }
        ]
    }
  },
  created () {
    this.user = window.laravel_user
  }
}
</script>
<style scoped>

</style>
