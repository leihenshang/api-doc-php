<template>
  <n-message-provider>
    <TableDemo :row-type="RowType"/>
  </n-message-provider>
</template>

<script lang="ts">
import {defineComponent} from 'vue';
import TableDemo from '../../components/public/TableDemo.vue';

export default defineComponent({
  name: 'ProjectList',
  components: {TableDemo},
  setup(){
    type RowType = {
      no: number,
      title: string,
      length: string
    }
    return{
      RowType:{no: 'number',
        title: 'string',
        length: 'string'}
    }
  }
});
</script>

<style scoped lang='scss'>

</style>