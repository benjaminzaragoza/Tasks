<template>
    <span>
        <v-toolbar color="primary" class="ml-2">
            <v-avatar :src="user.avatar" size="52px" @click="$emit('toggleright')">
                <img :src=userAvatar alt="avatar">
            </v-avatar>
            <v-toolbar-title>Channels</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-tooltip bottom>
                <v-btn icon slot="activator">
                    <v-icon>channel</v-icon>
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
        <v-container fluid text-xs-center class="ma-0 pa-0">
          <v-layout row wrap>
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
            <v-flex xs12 class="scroll-y" style="max-height: calc(100vh - 64px - 64px - 64px - 64px)">
                <v-list subheader>
                    <v-subheader>Recent channels</v-subheader>
                    <v-list-tile
                            v-for="channel in dataChannels"
                            :key="channel.id"
                            avatar
                            @click=""
                    >
                      <v-list-tile-avatar>
                        <img style="width: 45px;height: 120%;margin-left: 25%;" :src="channel.avatar">
                      </v-list-tile-avatar>

                      <v-list-tile-content>
                        <v-list-tile-title class="name" v-html="channel.name"></v-list-tile-title>
                         <v-list-tile-title class="message" v-html="channel.message"></v-list-tile-title>
                      </v-list-tile-content>

                      <v-list-tile-action>
                        <v-list-tile-title class="time" v-html="channel.time"></v-list-tile-title>
                      </v-list-tile-action>
                    </v-list-tile>
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
      userAvatar: window.laravel_user.gravatar,
      dataChannels:
          [
            {
              id: 1,
              name: 'Channel 1',
              avatar: 'http://i.pravatar.cc/300',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 2,
              name: 'Channel 2',
              avatar: 'http://i.pravatar.cc/300?sadsda',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 3,
              name: 'Channel 3',
              avatar: 'http://i.pravatar.cc/300?sadsdasadsad',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 4,
              name: 'Channel 2',
              avatar: 'http://i.pravatar.cc/300?sadsda',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 5,
              name: 'Channel 3',
              avatar: 'http://i.pravatar.cc/300?sadsdasadsad',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 6,
              name: 'Channel 3',
              avatar: 'http://i.pravatar.cc/300?sadsdasadsad',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 7,
              name: 'Channel 3',
              avatar: 'http://i.pravatar.cc/300?sadsdasadsad',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 8,
              name: 'Channel 3',
              avatar: 'http://i.pravatar.cc/300?sadsdasadsad',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 9,
              name: 'Channel 3',
              avatar: 'http://i.pravatar.cc/300?sadsdasadsad',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 10,
              name: 'Channel 3',
              avatar: 'http://i.pravatar.cc/300?sadsdasadsad',
              message: 'hola',
              time:'18:21'
            },
            {
              id: 11,
              name: 'Channel 3',
              avatar: 'http://i.pravatar.cc/300?sadsdasadsad',
              message: 'hola',
              time:'18:21'
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

    .edit *{
        color: #555;
        float: right;
        margin: 10px;
        font-size: 30px;
    }
    .name{
        display: block;
    }
    .time{
        float: right;
        margin-top: -15px;
        font-size: 10px;
        color: grey;
    }

    .details .message{
        color: grey;
    }

</style>
