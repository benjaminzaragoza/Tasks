<template>
    <div class="chat-new-msg">
        <v-btn icon>
            <v-icon>face</v-icon>
        </v-btn>
        <label class="m-2">
            <input @keyup.enter="save" v-model="message" type="text" class="search" placeholder="Escribe un mensaje aquí">
        </label>
        <v-btn icon class="mic">
            <v-icon>mic</v-icon>
        </v-btn>
    </div>
</template>
<script>
export default {
  name: 'ChatMessageAdd',
  data () {
    return {
      message: '',
      loading: false
    }
  },
  props: {
    channel: {
      type: Object,
      required: true
    }
  },
  methods: {
    save () {
      this.loading = true
      if (this.channel) {
        window.axios.post('/api/v1/channel/' + this.channel.id + '/messages', {
          'text': this.message
        }).then((response) => {
          this.loading = false
          this.$emit('added', response.data)
          this.message = ''
        }).catch(() => {
          this.loading = false
        })
      }
    }
  }
}
</script>
<style>
    .mic{
        position: relative;
        left: -10px;
    }
    .chat-new-msg{
        background-color: #EEEEEE;
        padding: 1px;
    }
    .chat-new-msg label{
        -webkit-align-items: center;
        align-items: center;
        box-sizing: border-box;
        display: inline-flex;
        height: 35px;
        top: 7px;
        left: 12px;
        margin-left: 65px;
        padding-left: 10px;
        padding-right: 70%;
        right: 14px;
        background-color: #fff;
        border-radius: 18px;
    }
    .chat-new-msg input.search{
        font-size: 15px;
        font-weight: normal;
        line-height: 20px;
        min-height: 20px;
        outline: none;
        -webkit-user-select: text;
        -moz-user-select: text;
        -ms-user-select: text;
        user-select: text;
        width: 100%;
        z-index: 1;
        border: none;
        padding: 0;
    }
</style>
