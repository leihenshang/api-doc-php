<template>
  <div class="my-note-wrapper">
    <div id="markdown-container"></div>
    <p>xxxx</p>
    <svg class="icon" aria-hidden="true">
      <use xlink:href="#icon-shoucang"></use>
    </svg>
  </div>
</template>
<script>
import Cherry from 'cherry-markdown'
import {onMounted} from 'vue'

export default {
  name: 'MyNote',
  setup() {
    // onMounted(()=>{
    //   const cherryInstance = new Cherry({
    //     id: 'markdown-container',
    //     value: '# welcome to cherry editor!',
    //   })
    // })
  }
}
</script>

<style scoped lang='scss'>

</style>