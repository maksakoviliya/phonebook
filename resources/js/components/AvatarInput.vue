<template>
  <div>
    <img class="avatar" :src="filePath" />
    <input type="file" name="file" class="btn btn-primary" @change="onFileChange" />
  </div>
</template>

<script>
export default {
  name: "avatar-input",
  data() {
    return {
      file: null,
      filePath: "/img/no-photo.svg",
    };
  },
  methods: {
    onFileChange(e) {
      const file = e.target.files[0];
      this.file = file.name;
      this.filePath = URL.createObjectURL(file);
    },
  },
};
</script>

<style lang="scss">
.avatar {
  width: 60%;
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 1rem;
  display: block;
}
</style>