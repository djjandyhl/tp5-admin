<template>
  <div>
    <h1>Admin Page</h1>
    <p>A vue project.</p>
    <p>{{ msg }}</p>
  </div>
</template>

<script>
  export default {
    name: 'app',
    data() {
      return {
        msg: "hello"
      }
    }
  };
</script>
