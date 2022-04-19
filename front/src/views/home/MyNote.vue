<template>
  <div class="my-note-wrapper">
    <div id="markdown-container"></div>
    <p>xxxx</p>
    <SvgIcon icon-name="shoucang"></SvgIcon>
<!--    <svg class="icon">-->
<!--      <use xlink:href="#icon-shoucang"></use>-->
<!--    </svg>-->
  </div>
</template>
<script>
import Cherry from 'cherry-markdown'
import {onMounted} from 'vue'
import SvgIcon from '../../components/public/SvgIcon.vue'

export default {
  name: 'MyNote',
  components:{SvgIcon},
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