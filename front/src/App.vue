<template>
  <n-message-provider>
  <router-view></router-view>
  </n-message-provider>
</template>

<script>
import './assets/style/reset.scss'
import HelloWorld from './components/HomePage.vue'

export default {
  name: 'App',
  components: {
    HelloWorld
  }
}
</script>
<style type="text/css">
.icon {
  width: 1em; height: 1em;
  vertical-align: -0.15em;
  fill: currentColor;
  overflow: hidden;
}
</style>
