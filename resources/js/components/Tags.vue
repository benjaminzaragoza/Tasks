<template>
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h3>TAGS ({{ this.dataTags.length }})</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <input type="text" class="form-control col-12" placeholder="Search...">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <ul>
                                <li v-for="tag in dataTags" :key="tag.id">{{tag.name}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  name: 'Tags',
  data () {
    return {
      data: 'Tags',
      dataTags: [],
      errorMsg: ''
    }
  },
  created () {
    if (this.dataTags.length === 0) {
      window.axios.get('/api/v1/tags').then((response) => {
        this.dataTags = response.data
      }).catch((error) => {
        this.errorMsg = error.message
      })
    }
  }
}
</script>
<style scoped>
</style>
