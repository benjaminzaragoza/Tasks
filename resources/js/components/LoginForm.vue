<template>
    <v-form action="/login" method="POST">
        <v-toolbar dark color="primary">
            <v-toolbar-title class="font-weight-bold text-xs-center text-uppercase">Login form &nbsp;<v-icon>face</v-icon></v-toolbar-title>
        </v-toolbar>
        <v-card-text>
            <input type="hidden" name="_token" :value="csrfToken">
            <v-text-field
                    prepend-icon="person"
                    name="email"
                    label="Login"
                    type="text"
                    v-model="dataEmail"
                    :error-messages="emailErrors"
                    @input="$v.dataEmail.$touch()"
                    @blur="$v.dataEmail.$touch()"
            ></v-text-field>
            <v-text-field
                    id="password"
                    prepend-icon="lock"
                    name="password"
                    label="Password"
                    type="password"
                    v-model="password"
                    :error-messages="passwordErrors"
                    @input="$v.password.$touch()"
                    @blur="$v.password.$touch()"
            ></v-text-field>
            <a href="/register">No tens compte d'usuari? Registrat </a>
        </v-card-text>
        <v-card-actions>
            <v-btn href="/" type="submit" color="primary">
                <v-icon class="mr-2" >home</v-icon>
            </v-btn>
            <v-spacer></v-spacer>
            <v-btn color="primary" type="submit" :disabled="$v.$invalid" >Login</v-btn>
        </v-card-actions>
    </v-form>
</template>

<script>
import { validationMixin } from 'vuelidate'
import { required, email, minLength } from 'vuelidate/lib/validators'
import VListTile from "vuetify/lib/components/VList/VListTile"

export default {
  name: 'LoginForm',
  components: {VListTile},
  mixins: [validationMixin],
  validations: {
    dataEmail: { required, email },
    password: { required, minLength: minLength(6) }
  },
  data () {
    return {
      dataEmail: this.email,
      password: ''
    }
  },
  props: ['email', 'csrfToken'],
  computed: {
    emailErrors () {
      const errors = []
      if (!this.$v.dataEmail.$dirty) return errors
      !this.$v.dataEmail.email && errors.push('El camp email a de tipus email')
      !this.$v.dataEmail.required && errors.push('El camp email es obligatori')
      return errors
    },
    passwordErrors () {
      const errors = []
      if (!this.$v.password.$dirty) return errors
      !this.$v.password.minLength && errors.push('El camp password a de tenir una mida minima de 6 caracters')
      !this.$v.password.required && errors.push('El camp email es obligatori')
      return errors
    }
  }
}
</script>
