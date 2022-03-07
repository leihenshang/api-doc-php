<template>
  <router-view></router-view>
</template>

<script>
import "./assets/style/reset.scss";
import HelloWorld from './components/HomePage.vue'

export default {
  name: 'App',
  components: {
    HelloWorld
  }
}
</script>
