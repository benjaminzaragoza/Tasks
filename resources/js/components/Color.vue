<template>
        <div class="text-xs-center form__input">
  <h4>Principal:</h4> <swatches colors="text-advanced" v-model="colorPrincipal"></swatches>
  <h4>Secundari:</h4><swatches colors="text-advanced" v-model="colorSecundari"></swatches>
            <v-btn
                    color="success"
                    value="Refresh Page"
                    class="white--text"
                    onClick="window.location.reload()"
            >
                Guardar
                <v-icon right dark>save</v-icon>
            </v-btn>
        </div>
</template>

<script>
import Swatches from 'vue-swatches'
import 'vue-swatches/dist/vue-swatches.min.css'
export default {
  name: 'Color',
  components: { Swatches },
  data () {
    return {
      colorPrincipal: window.localStorage.getItem('PRIMARY_COLOR_KEY'),
      colorSecundari: window.localStorage.getItem('SECONDARY_COLOR_KEY')
    }
  },
  watch: {
    colorPrincipal () {
      window.localStorage.setItem('PRIMARY_COLOR_KEY', this.colorPrincipal)
    },
    colorSecundari () {
      window.localStorage.setItem('SECONDARY_COLOR_KEY', this.colorSecundari)
    }
  }
}
</script>
