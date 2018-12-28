<template>
  <div class="container">
    <h3 class="ui horizontal divider header mt-5">
      <i class="file excel icon"></i>Bestand upload
    </h3>

    <form action method="post" class="ui form" @submit="checkForm">
      <div class="upload-wrap">
        <button
          type="button"
          class="ui secondary button upload-btn-2"
        >Bestand {{this.fileName ? '(' + this.fileName + ')' : "kiezen" }}</button>
        <input type="file"  @change="onFileUpload" name="excel" id="excel-upload" class="upload-btn">
      </div>
      <div class="mt-2" v-if="this.file">
        <h3 class="ui horizontal divider header mt-5">
          <i class="clipboard list icon"></i>Kies het pakket
        </h3>
        <select class="ui fluid dropdown" id="pack">
          <option v-for="pack in packs" v-bind:key="pack.id">{{pack.name}}</option>
        </select>
        <div class="submit">
          <button id="submit-btn" class="ui secondary button mt-3">Pakketten aanmaken</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      packs: [],
      fileName: null,
      file: false
    };
  },
  mounted() {
    console.log("Component mounted.");
    this.getServices();
  },
  methods: {
    getServices() {
      axios
        .get("/api/servicepacks", {
          headers: { Accept: "application/json" }
        })
        .then(res => {
          this.packs = res.data;
        })
        .then(res => {
          console.log(this.packs);
        })
        .catch(error => console.log(error));
    },
    onFileUpload(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (files.length) {
        this.file = true;
        this.fileName = files[0].name;
      } else {
        this.file = false;
        this.fileName = null;
      }
    }
  }
};
</script>

