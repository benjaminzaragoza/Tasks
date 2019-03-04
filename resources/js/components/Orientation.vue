<template>
    <div>
        <v-layout >
            <v-flex  xs6 sm2 lg2>
                <i class="color material-icons btn btn-default" slot="activator"
                   @click="show"
                   id="askButton"
                   @click.stop="dialog = true"

                >screen_rotation</i>
            </v-flex>
    <v-dialog
            v-model="dialog"
            width="500"

    >
      <v-card>
        <v-card-title
                class="headline primary white--text"
                primary-title

        >  Quina es la posicio del teu telefon?
        </v-card-title>
          <div style="text-align: center">
        <p class="font-weight-bold subheading justify-center">Posició dispositiu<v-btn icon @click="show" :loading="po"> <v-icon>cached</v-icon></v-btn></p>
        <p class="font-weight-light font-italic">Actualitza si no obtens la posició correctament</p>
        </div>
        <div id="device" class="primary"></div>
        <p style="text-align: center;margin-top: 5%">La teva orientació és <b id="orientationType">unknown</b>.</p>
        <p>
            <button class="btn btn-default" id="lock"></button>
            <button class="btn btn-default" id="unlock"></button>
        </p>
        <p class="font-italic font-weight-light" id="logTarget"></p>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
                  color="primary"
                  flat
                  @click="dialog = false"
                  style="margin-top: -10%"
          >
            Sortir
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
        </v-layout>
    </div>
</template>

<script>
export default {
  name: 'ScreenOrientation',
  data () {
    return {
      orientation: false,
      dialog: false,
      po: false

    }
  },
  methods: {
    show () {
      var $ = document.getElementById.bind(document)
      var orientKey = 'orientation'
      if ('mozOrientation' in screen) {
        orientKey = 'mozOrientation'
      } else if ('msOrientation' in screen) {
        orientKey = 'msOrientation'
      }
      var target = $('logTarget')
      var device = $('device')
      var orientationTypeLabel = $('orientationType')
      function logChange (event) {
        var timeBadge = new Date().toTimeString().split(' ')[0]
        var newState = document.createElement('p')
        newState.innerHTML = '<span class="badge">' + timeBadge + '</span> ' + event + '.'
        target.appendChild(newState)
      }
      if (screen[orientKey]) {
        function update () {
          var type = screen[orientKey].type || screen[orientKey]
          orientationTypeLabel.innerHTML = type
          var landscape = type.indexOf('landscape') !== -1
          if (landscape) {
            device.style.width = '150px'
            device.style.height = '100px'
          } else {
            device.style.width = '100px'
            device.style.height = '120px'
          }
          var rotate = type.indexOf('secondary') === -1 ? 0 : 180
          var rotateStr = 'rotate(' + rotate + 'deg)'
          device.style.webkitTransform = rotateStr
          device.style.MozTransform = rotateStr
          device.style.transform = rotateStr
        }
        update()
        var onOrientationChange = null
        if ('onchange' in screen[orientKey]) { // newer API
          onOrientationChange = function () {
            update()
          }
          screen[orientKey].addEventListener('change', onOrientationChange)
        } else if ('onorientationchange' in screen) { // older API
          onOrientationChange = function () {
            update()
          }
          screen.addEventListener('orientationchange', onOrientationChange)
        }
        // browsers require full screen mode in order to obtain the orientation lock
        var goFullScreen = null
        var exitFullScreen = null
        if ('requestFullscreen' in document.documentElement) {
          goFullScreen = 'requestFullscreen'
          exitFullScreen = 'exitFullscreen'
        } else if ('mozRequestFullScreen' in document.documentElement) {
          goFullScreen = 'mozRequestFullScreen'
          exitFullScreen = 'mozCancelFullScreen'
        } else if ('webkitRequestFullscreen' in document.documentElement) {
          goFullScreen = 'webkitRequestFullscreen'
          exitFullScreen = 'webkitExitFullscreen'
        } else if ('msRequestFullscreen') {
          goFullScreen = 'msRequestFullscreen'
          exitFullScreen = 'msExitFullscreen'
        }
        $('lock').addEventListener('click', function () {
          document.documentElement[goFullScreen] && document.documentElement[goFullScreen]()
          var promise = null
          if (screen[orientKey].lock) {
            promise = screen[orientKey].lock(screen[orientKey].type)
          } else {
            promise = screen.orientationLock(screen[orientKey])
          }
          promise
            .then(function () {
              logChange('Screen lock acquired')
              $('unlock').style.display = 'block'
              $('lock').style.display = 'none'
            })
            .catch(function (err) {
              logChange('Cannot acquire orientation lock: ' + err)
              document[exitFullScreen] && document[exitFullScreen]()
            })
        })
        $('unlock').addEventListener('click', function () {
          document[exitFullScreen] && document[exitFullScreen]()
          if (screen[orientKey].unlock) {
            screen[orientKey].unlock()
          } else {
            screen.orientationUnlock()
          }
          logChange('Screen lock removed.')
          $('unlock').style.display = 'none'
          $('lock').style.display = 'block'
        })
      }
    }
  }
}
</script>

<style scoped>

    #device {
        margin-left: 35%;
        border: 1px solid black;
        border-radius: 10px;
    }
    #device:after {
        background-image: url('../../img/task.png');
        font: 80px serif;
        display: block;
        text-align: center;
    }
    #unlock {
        display: none;
    }
    .container {
        perspective: 300;
        -webkit-perspective: 300;
    }

    #imgLogo {
        width: 275px;
        margin-left: auto;
        margin-right: auto;
        display: block;
        padding: 15px;
    }
</style>
