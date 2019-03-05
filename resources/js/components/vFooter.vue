<template>
<v-footer    height="auto" class="primary">
        <v-container grid-list-sm class="primary">
            <v-layout row wrap pt-7 pb-0 style="text-align: center">
                <v-flex offset-xs1 offset-md0 offset-lg2 xs10 sm5 md3 lg2>
                    <a class="footer-icons" target="_blank" href="https://www.facebook.com/benjamin.zaragozapla?ref=bookmarks">
                        <img alt="facebook"  rel="noopener" src="/img/welcome/facebook.svg">
                    </a>
                    <div class="pb-2" >
                        <p class="white--text">Descobreix</p>
                    </div>
                    <v-divider dark class="hidden-lg-and-down"></v-divider>
                    <div class="footer-left hidden-sm-and-down">
                        <h3 style="margin-top: 28%" class="adeu">By Benjamin Zaragoza Pla © 2019</h3>
                    </div>

                </v-flex>
                <v-flex offset-xs1 offset-sm0 xs10 sm5 md3 lg2>
                    <a class="footer-icons" rel="noopener" target="_blank" href="https://twitter.com/Benja__97">
                        <img alt="twitter"  src="/img/welcome/gorjeo.svg">
                    </a>
                    <div class="pb-2">
                        <p class="white--text">Interactua</p>
                    </div>
                    <v-divider dark class="hidden-lg-and-down"></v-divider>
                </v-flex>
                <v-flex offset-xs1 offset-sm1 offset-md0 xs10 sm5 md3 lg2>
                    <a class="footer-icons" rel="noopener" target="_blank" href="https://www.instagram.com/benjaminzaragoza">
                        <img alt="instagram"  src="/img/welcome/instagram.svg">
                    </a>
                    <div class="pb-2 ">
                        <p class="white--text">Composa</p>
                    </div>
                    <v-divider dark class="hidden-lg-and-down"></v-divider>

                </v-flex>
                <v-flex offset-xs1 offset-sm0 xs10 sm5 md3 lg2>
                    <a class="footer-icons" rel="noopener" target="_blank" href="https://github.com/benjaminzaragoza">
                        <img alt="github"  src="/img/welcome/git.svg">
                    </a>
                    <div class="pb-2">
                        <p class="white--text">Coneix</p>
                    </div>
                    <v-divider dark class="hidden-lg-and-down"></v-divider>

                    <div class="pb-2 pt-4 hola" >
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
<style>

    @media  only screen and (max-width: 350px) {
        .hola{
            margin-left: -9022%;
        }
    }
    @media  only screen and (min-width: 1000px) {
        .hola{
            margin-left: -125%;
        }
    }

    .footer-icons img {
        display: inline-block;
        width: 50px;
        height: 50px;
        cursor: pointer;
        border-radius: 2px;
margin-bottom: 5%;
        font-size: 20px;
        color: #ffffff;
        text-align: center;
        line-height: 35px;

    }
    .adeu{
        color: white;
        text-align: center;
        font:  16.5px Arial;
    }

</style>
