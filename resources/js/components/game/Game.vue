<template>
<span>
    <p>Press a button to activate your game controller.</p>
    <div id="ball"></div>
</span>
</template>

<script>
export default {
  name: 'Game',
  data () {
    return {
      value: ''
    }
  }
}
</script>

<style>
    #ball {
        position: absolute;
        left: calc(50vw - 25px);
        top: calc(50vh - 25px);
        background-color: red;
        width: 50px;
        height: 50px;
        border-radius: 25px;
    }
</style>
