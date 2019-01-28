<template>
    <v-navigation-drawer
            v-model="drawerRight"
            fixed
            app
            clipped
            right
    >
        <v-toolbar color="secondary" dark class="white--text">
            <v-icon>face</v-icon><v-toolbar-title>Perfil</v-toolbar-title>
        </v-toolbar>
        <v-card flat>
            <v-card-text>
                <h3 style=" margin-left: 2%;text-align: center">
                    <!--<v-avatar  @click="drawerRight=!drawerRight" style="margin-top: 2%;margin-right: 5%;" title="{{ user('name') }}({{ user('email') }})">-->
                        <!--<img src="https://www.gravatar.com/avatar/{{ user('email') }} " alt="avatar" style="margin-left: 15%;margin-right: 40%;margin-top: -11%;">-->
                    <!--</v-avatar>-->
                    <v-avatar  @click="drawerRight=!drawerRight" style="margin-top: 2%;margin-right: 5%;">
                        <img src="https://www.gravatar.com/avatar/" alt="avatar" style="margin-left: 15%;margin-right: 40%;margin-top: -11%;">
                    </v-avatar>
                    {{ user('name') }}</h3>

                <v-list-tile-title style="margin-top: 11%;margin-bottom: 10%; text-align: center" class="font-weight-black font-italic">{{ user('email') }}</v-list-tile-title>
                <h4>Rol</h4>
                <p style="margin-top: 5%;">
                    <v-chip   v-if="user('admin')" color="success darken3" text-color="white" >
                        <v-avatar>
                            <v-icon>check_circle</v-icon>
                        </v-avatar>
                        Super Administrador
                    </v-chip>
                    <v-chip v-if="!user('admin')" color="error darken3" text-color="white">
                        <v-avatar>
                            <v-icon>close</v-icon>
                        </v-avatar>
                        Usuari
                    </v-chip>
                </p>
                <h4>Permisos</h4>
                <template >
                    <p style="margin-top: 5%;">{{ user('permissions').join() }}</p>
                </template>
                <p> </p>
                <h4>Colors Tema</h4>
                <color></color>
            </v-card-text>

        </v-card>

        <v-card>
            <v-toolbar color="secondary" dark class="white--text">
                <v-toolbar-title>Opcions administrador</v-toolbar-title>
            </v-toolbar>
            <v-card flat>
                <v-card-text>
                    <impersonate label="Entrar com ... " url="/api/v1/regular_users"></impersonate>
                </v-card-text>
            </v-card>
        </v-card>
        <!--<v-btn  v-if="impersonating!=null" color="error darken3" dark href="impersonate/leave">Abandonar la suplantació-->
            <!--<v-icon dark right>supervisor_account</v-icon>-->
        <!--</v-btn>-->
    </v-navigation-drawer>

</template>

<script>
export default {
  name: 'NavigationRight',
  props: ['drawerRight'],
  data () {
    return {
      dataDrawerRight: this.drawerRight,
      impersonate: false
    }
  },
  watch: {
    drawerRight (newvalue) {
      this.dataDrawerRight = newvalue
    },
    dataDrawerRight (newdrawer) {
      if (newdrawer != this.drawerRight) this.$emit('changed', newdrawer)
    }
  },
  // computed: {
  //   impersonating () {
  //     return window.laravel_user_impersonating
  //   }
  // },
  methods: {
    impersonat () {
      this.impersonate = false
    },
    user (prop) {
      return window.laravel_user[prop]
    }
  }
}
</script>
