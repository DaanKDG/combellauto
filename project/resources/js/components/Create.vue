<template>
  <div class="container">
    <clip-loader :loading="loading" :color="color" :size="size"></clip-loader>
        <div class="create-section" v-if='!this.submit'>
            <h3 class="ui horizontal divider header mt-5">
              <i class="file excel icon"></i>Bestand upload
            </h3>

            <form action method="post" class="ui form">
              <div class="upload-wrap">
                <button
                  type="button"
                  class="ui secondary button upload-btn-2"
                >Bestand {{this.fileName ? '(' + this.fileName + ')' : "kiezen" }}</button>
                <input
                  type="file"
                  ref="file"
                  @change="onFileUpload"
                  name="excel-upload"
                  id="excel-upload"
                  class="upload-btn"
                >
              </div>
              <div class="mt-2" v-if="this.file">
                <h3 class="ui horizontal divider header mt-5">
                  <i class="clipboard list icon"></i>Kies het pakket
                </h3>
                <select class="ui fluid dropdown" id="pack" v-model="pack">
                  <option v-for="pack in packs" v-bind:key="pack.id" :value='pack.id'>{{pack.name}}</option>
                </select>
                <div class="submit">
                  <button
                    id="submit-btn"
                    v-on:click="submitFile"
                    class="ui secondary button mt-3"
                  >Pakketten aanmaken</button>
                  <p v-if="this.status"> {{this.status}}</p>
                </div>
              </div>
            </form>
        </div>
  <status :submit="submit" :finished="finished"> </status>
  </div>
</template>

<script>

import ClipLoader from 'vue-spinner/src/Cliploader.vue'
import Status from './Status.vue'

export default {
  data() {
    return {
      loading: true,
      size: '100px',
      color: '#1b1c1d',
      packs: [],
      fileName: null,
      file: null,
      pack: null,
      status: null,
      submit: false,
      finished: false,
      error: false,
    };
  },
  mounted() {
    this.getServices();
  },
  components: {
     ClipLoader,
     Status
  },
  methods: {
    getServices() {
      this.loading = true;
      axios
        .get("/api/servicepacks", {
          headers: { Accept: "application/json" }
        })
        .then(res => {
          this.packs = res.data;
          this.loading = false;
        })
        .catch(error => {
          console.log(error);
          this.loading = false;
          });
    },
    submitFile(e) {
      this.status = 'Trying to send file to the server'
      this.submit = true,
      e.preventDefault();
      let formData = new FormData();
      formData.append("file", this.file);
      formData.set("package", this.pack);
      axios
        .post("/api/accounts/create", formData, {
          headers: {
            "Content-Type": "multipart/form-data"
          }
        })
        .then(res => {this.finished = true;})
        .catch(error => {this.error = true;})
    },
    onFileUpload(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (files.length) {
        this.file = this.$refs.file.files[0];
        this.fileName = files[0].name;
      } else {
        this.file = null;
        this.fileName = null;
      }
    }
  }
};
</script>

