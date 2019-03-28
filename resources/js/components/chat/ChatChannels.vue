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
              <v-list subheader two-line>
                  <v-subheader>Recent channels</v-subheader>
                    <template v-for="(item, index) in items">
                      <v-list-tile
                              :key="item.title"
                              avatar
                              ripple
                              @click="toggle(index)"
                      >
                          <v-list-tile-avatar>
                                <img style="margin-left: 25%;height: 120%;width: 120%" :src="item.avatar">
                          </v-list-tile-avatar>

                        <v-list-tile-content style="margin-left: 1%">
                            <v-list-tile-title style="margin-top: -2%">{{ item.title }}</v-list-tile-title>
                            <v-list-tile-sub-title style="margin-top: 1%;">{{ item.subtitle }}</v-list-tile-sub-title>
                        </v-list-tile-content>

                        <v-list-tile-action>
                          <v-list-tile-action-text>{{ item.action }}</v-list-tile-action-text>

                                <v-menu class="mt-0 " offset-y transition="slide-y-transition" v-if="item.msgcount==0" color="grey">
                                    <v-btn style="margin-top: -50%" slot="activator" icon>
                                        <v-icon color="grey">keyboard_arrow_down</v-icon>
                                    </v-btn>
                                    <v-list class="pr-lg-5 pl-2">
                                        <v-list-tile>
                                            <v-list-tile-title>Arxivar xat</v-list-tile-title>
                                        </v-list-tile>
                                        <v-list-tile >
                                            <v-list-tile-title>Silenciar</v-list-tile-title>
                                        </v-list-tile>
                                        <v-list-tile >
                                            <v-list-tile-title>Esborrar Chat</v-list-tile-title>
                                        </v-list-tile>
                                        <v-list-tile >
                                            <v-list-tile-title>Ancorar Chat</v-list-tile-title>
                                        </v-list-tile>
                                        <v-list-tile >
                                            <v-list-tile-title>Marcar com a llegit</v-list-tile-title>
                                        </v-list-tile>
                                    </v-list>
                                </v-menu>
                            <v-badge v-else color="green accent-4" class="mr-4 ml-3 mb-4 ">
                                <span slot="badge">{{ item.msgcount }}</span>
                            </v-badge>
                        </v-list-tile-action>

                      </v-list-tile>
                      <v-divider
                              class="grey lighten-5"
                              style="margin-top: 0;margin-bottom: 0;margin-right: 8px;margin-left: 75px"
                              v-if="index + 1 < items.length"
                              :inset="inset"
                      ></v-divider>
                    </template>
              </v-list>
            </v-flex>
          </v-layout>
        </v-container>
    </span>
</template>

<script>
export default {
  name: 'ChatChannels',
  data () {
    return {
      index: true,
      inset: true,
      userAvatar: window.laravel_user.gravatar,
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
  props: {
    channels: {
      type: Array,
      required: true
    }
  },
  created () {
    this.user = window.laravel_user
  }
}
</script>
<style>

</style>
