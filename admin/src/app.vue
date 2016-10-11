<template>
  <div id="app">

  </div>
</template>

<script>
  export default {
    methods: {
      startHacking() {
        this.$notify({
          title: 'It Works',
          message: 'We have laid the groundwork for you. Now it\'s your time to build something epic!',
          duration: 6000
        });
      }
    },
    data: function() {
      return {
        msg: 'my first test!'
      };
    }
  };
</script>
<style>
  body{padding: 0;margin: 0}
</style>