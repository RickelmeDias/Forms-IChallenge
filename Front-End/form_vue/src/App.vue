<template>
  <div id="app">
    <title>Crie sua conta na Memorar</title>

    <!-- Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:wght@100;400;500;600&display=swap"
        rel="stylesheet">

    <FormCreateAccount />
  </div>
</template>

<script>
import FormCreateAccount from './components/FormCreateAccount.vue'

export default {
  name: 'App',
  components: {
    FormCreateAccount
  }
}
</script>

<style>
  #app {
      font-family: 'Montserrat', sans-serif;
      letter-spacing: -0.25px;
  }
</style>
