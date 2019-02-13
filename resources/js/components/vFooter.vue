<template>
<v-footer    height="auto" class="primary">
        <v-container grid-list-sm class="primary">
            <v-layout row wrap pt-7 pb-0 style="text-align: center">
                <v-flex offset-xs1 offset-md0 offset-lg2 xs10 sm5 md3 lg2>
                    <div class="pb-2">
                        <v-icon color="secondary" >help</v-icon>
                    </div>
                    <div class="pb-2 pt-4">
                        <p class="white--text">Poser une question</p>
                    </div>
                    <v-divider dark></v-divider>
                    <div class="pb-2 pt-4 hidden-md-and-down ">
                        <p class="white--text">FAQ</p>
                        <p class="white--text">CGU / CGV / Mentions légales</p>
                        <p class="white--text">Espace carrière</p>
                        <v-btn color="primary" class="ml-0">Nous contacter</v-btn>
                    </div>
                </v-flex>
                <v-flex offset-xs1 offset-sm0 xs10 sm5 md3 lg2>
                    <div class="pb-2 pt-4">
                        <v-icon color="secondary" >info</v-icon>
                    </div>
                    <div class="pb-2">
                        <p class="white--text">Mieux nous connaître</p>
                    </div>
                    <v-divider dark></v-divider>
                    <div class="pb-2 pt-4">
                        <p class="white--text hidden-md-and-down">Bienvenue</p>
                        <p class="white--text hidden-md-and-down">Accueil</p>
                        <p class="white--text hidden-md-and-down" >À propos</p>
                        <p class="white--text hidden-md-and-down">Notre équipe</p>
                        <p class="white--text hidden-md-and-down">Notre vision</p>
                    </div>
                </v-flex>
                <v-flex offset-xs1 offset-sm1 offset-md0 xs10 sm5 md3 lg2>
                    <div class="pb-2">
                        <v-icon color="secondary" >extension</v-icon>
                    </div>
                    <div class="pb-2">
                        <p class="white--text">Nos outils</p>
                    </div>
                    <v-divider dark></v-divider>
                    <div class="pb-2 pt-4" >
                        <p class="white--text hidden-md-and-down">Gestion de biens patrimoniaux</p>
                        <p class="white--text hidden-md-and-down">Investissement immobilier</p>
                        <p class="white--text hidden-md-and-down">Syndic de copropriété</p>
                    </div>
                </v-flex>
                <v-flex offset-xs1 offset-sm0 xs10 sm5 md3 lg2>
                    <div class="pb-2">
                        <v-icon color="secondary" >email</v-icon>
                    </div>
                    <div class="pb-2">
                        <p class="white--text">S’abonner </p>
                    </div>
                    <v-divider dark></v-divider>
                    <div class="pb-2 pt-4" style="margin-left: 4%">
                        <v-text-field
                                name="input-1-3"
                                label="Votre E-mail"
                                dark
                        ></v-text-field>
                        <v-btn class="right mr-0" color='secondary' bottom>Envoyer</v-btn>
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
