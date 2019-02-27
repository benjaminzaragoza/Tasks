<template>
        <i class="color material-icons" @click="vibrate">vibration</i>
</template>

<script>
export default {
  name: 'Vibrate',
  methods: {
    vibrate () {
      console.log('hola')
      navigator.vibrate(200)
    }
  }
}
</script>

<style>
/*@import "../../../public/css/function.css";*/
</style>
