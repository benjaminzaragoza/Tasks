<template>
    <!--<span>-->
        <!--<ul style="list-style:none">-->
            <!--<li><a href="https://mailchimp.com/">https://mailchimp.com/</a></li>-->
            <!--<li>Usuari: benjaminzaragoza@iesebre.com</li>-->
            <!--<li>Password: Personal (mireu fitxer .env)</li>-->
            <!--<li><a href="https://us20.admin.mailchimp.com/lists/">https://us20.admin.mailchimp.com/lists/</a></li>-->
            <!--<li>Nom de la llista: Ies del Ebre</li>-->
            <!--<li>Id de la llista: Vegeu .env file</li>-->
        <!--</ul>-->
    <!--</span>-->
    <div id="app">
        <ul style="list-style:none">
        <li><a href="https://mailchimp.com/">https://mailchimp.com/</a></li>
        <li>Usuari: benjaminzaragoza@iesebre.com</li>
        <li>Password: Personal (mireu fitxer .env)</li>
        <li><a href="https://us20.admin.mailchimp.com/lists/">https://us20.admin.mailchimp.com/lists/</a></li>
        </ul>
        <v-app id="inspire">
            <v-layout row>
                <v-flex xs12 sm6 offset-sm3>
                    <v-card>
                        <v-toolbar color="primary" dark>
                            <v-toolbar-title class="text-xs-center">Dades</v-toolbar-title>

                            <v-spacer></v-spacer>

                        </v-toolbar>
                        <v-list >
                            <v-list-tile >
                                <v-list-tile-action>
                                    <v-icon color="indigo">face</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Usuari: benjaminzaragoza@iesebre.com</v-list-tile-title>
                                    <v-list-tile-sub-title>Password: Personal (mireu fitxer .env)</v-list-tile-sub-title>
                                </v-list-tile-content>

                            </v-list-tile>

                            <v-divider inset></v-divider>

                            <v-list-tile >
                                <v-list-tile-action>
                                    <v-icon color="indigo">mail</v-icon>
                                </v-list-tile-action>

                                <v-list-tile-content>
                                    <v-list-tile-title>Nom de la llista: Tasques</v-list-tile-title>
                                    <v-list-tile-sub-title>Id de la llista: Vegeu .env file</v-list-tile-sub-title>
                                </v-list-tile-content>
                            </v-list-tile>

                        </v-list>
                    </v-card>
                    <v-card>
                        <v-toolbar color="primary" dark>
                            <v-toolbar-title class="text-xs-center">Llista Usuaris</v-toolbar-title>

                            <v-spacer></v-spacer>

                        </v-toolbar>

                        <v-list subheader>
                            <v-subheader>Usuaris insertats llista</v-subheader>
                            <v-list-tile
                            >
                                <v-list-tile-avatar>
                                    <img :src=userAvatar>
                                </v-list-tile-avatar>

                                <v-list-tile-content>
                                    <v-list-tile-title v-for="member in newsletter.members" v-text="member.email_address" :key="member.email_address"></v-list-tile-title>
                                </v-list-tile-content>

                                <v-list-tile-action>
                                    <v-icon color="green">check</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                        </v-list>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-app>
    </div>
</template>

<script>
export default {
  name: 'Newsletters',
  props: {
    newsletter: {
      required: true
    }
  },
  data () {
    return {
      userAvatar: window.laravel_user.gravatar
    }
  }
}
</script>
