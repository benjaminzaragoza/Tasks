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
        <v-app id="inspire">
            <v-layout row>
                <v-flex xs12 sm6 offset-sm3 style="margin-top: 3%">
                    <v-card>
                        <v-toolbar color="primary" dark>
                            <v-toolbar-title class="text-xs-center" style="margin-right: 5%;font-size: 30px"> <v-icon color="yellow" large >account_circle</v-icon> Perfil</v-toolbar-title>

                            <v-spacer></v-spacer>

                            <v-btn small fab color="primary" href="https://mailchimp.com/"
                            ><img src="img/mail.png" height="40">
                            </v-btn>
                            <v-btn small fab color="primary" href="https://us20.admin.mailchimp.com/lists/"
                            ><img src="img/list.png" height="40">
                            </v-btn>
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


                <v-card style="margin-top: 5%">
                        <v-toolbar color="primary" dark>
                            <v-toolbar-title class="text-xs-center" style="margin-right: 5%;font-size: 30px"> <v-icon color="yellow" large >view_list</v-icon> Llista Usuaris</v-toolbar-title>

                            <v-spacer></v-spacer>

                        </v-toolbar>

                        <v-list subheader>
                            <v-subheader>Usuaris insertats llista</v-subheader>
                            <v-list-tile v-for="member in newsletter.members" :key="member.email_address"
                            >
                                <v-list-tile-avatar >
                                    <img :src="'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRn3qmREi6Bag9BxxTvSCdXKqL8G2mBNjSFMi1nBZ1r92jNniSwnw'">
                                </v-list-tile-avatar>

                                <v-list-tile-content>

                                    <v-list-tile-title v-text="member.email_address" ></v-list-tile-title>

                                </v-list-tile-content>

                                <v-list-tile-action>
                                    <v-icon color="green">check</v-icon>
                                </v-list-tile-action>
                            </v-list-tile>
                            <v-spacer></v-spacer>

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
