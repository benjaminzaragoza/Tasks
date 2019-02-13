<template>
<v-footer    height="auto" class="primary">
        <v-container grid-list-sm class="primary">
            <v-layout row wrap pt-7 pb-0 style="text-align: center">
                <v-flex offset-xs1 offset-md0 offset-lg2 xs10 sm5 md3 lg2>
                    <div class="pb-2 pt-4">
                        <v-icon color="secondary" >help</v-icon>
                    </div>
                    <div class="pb-2">
                        <p class="white--text">Descobreix</p>
                    </div>
                    <v-divider dark></v-divider>

                </v-flex>
                <v-flex offset-xs1 offset-sm0 xs10 sm5 md3 lg2>
                    <div class="pb-2 pt-4">
                        <v-icon color="secondary" >info</v-icon>
                    </div>
                    <div class="pb-2">
                        <p class="white--text">Interactua</p>
                    </div>
                    <v-divider dark></v-divider>
                </v-flex>
                <v-flex offset-xs1 offset-sm1 offset-md0 xs10 sm5 md3 lg2>
                    <div class="pb-2 pt-4 ">
                        <v-icon color="secondary" >extension</v-icon>
                    </div>
                    <div class="pb-2 ">
                        <p class="white--text">Composa</p>
                    </div>
                    <v-divider dark></v-divider>

                </v-flex>
                <v-flex offset-xs1 offset-sm0 xs10 sm5 md3 lg2>
                    <div class="pb-2 pt-4">
                        <v-icon color="secondary" >email</v-icon>
                    </div>
                    <div class="pb-2">
                        <p class="white--text">Coneix</p>
                    </div>
                    <v-divider dark></v-divider>
                    <div class="pb-2 pt-4" style="margin-left: -80%">
                        <v-text-field
                                name="input-1-3"
                                label="Email de contacte"
                                dark
                        ></v-text-field>
                        <v-btn class="right mr-0" color='secondary' bottom>Enviar</v-btn>
                    </div>
                </v-flex>
            </v-layout>
            <v-layout row  pt-4 pb-4>
                <v-flex lg8 offset-lg2>
                    <v-divider dark></v-divider>
                </v-flex>
            </v-layout>
            <v-layout row pb-2>
                <v-flex lg8 offset-lg2>
                    <div class="text-xs-center white--text">
                        © Vuetify 2018
                    </div>
                </v-flex>
            </v-layout>
        </v-container>
    </v-footer>
</template>
