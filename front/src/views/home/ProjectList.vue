<template>
  <n-message-provider>
    <n-data-table :columns="columns" :data="data" :pagination="pagination" :bordered="false" :bottom-bordered="false" class="custom-table"
                  size="small" striped/>
  </n-message-provider>
</template>

<script lang="ts">
import {h,defineComponent} from 'vue';
import { NButton, useMessage, DataTableColumns } from 'naive-ui'
type Song = {
  no: number
  title: string
  length: string
}

export default defineComponent({
  name: 'ProjectList',
  components: {},
  setup(){
    // const message = useMessage()
    const createColumns = ({play}: {
      play: (row: Song) => void
    }): DataTableColumns<Song> => {
      return [
        {
          title: 'No',
          key: 'no',
          className: 'first'
        },
        {
          title: 'Title',
          key: 'title',
          className: 'head'
        },
        {
          title: 'Length',
          key: 'length',
          className: 'head'
        },
        {
          title: 'Action',
          key: 'actions',
          className: 'head',
          // render (row) {
          //   return h(
          //       NButton,
          //       {
          //         strong: true,
          //         tertiary: true,
          //         size: 'small',
          //         onClick: () => play(row)
          //       },
          //       { default: () => 'Play' }
          //   )
          // }
        }
      ]
    }
    const data: Song[] = [
      { no: 3, title: 'Wonderwall', length: '4:18' },
      { no: 4, title: "Don't Look Back in Anger", length: '4:48' },
      { no: 12, title: 'Champagne Supernova', length: '7:27' }
    ]
    return{
      columns: createColumns({
        play (row: Song) {
          // message.info(`Play ${row.title}`)
        }
      }),
      pagination: false,
      data
    }
  }
});
</script>

<style scoped lang='scss'>

</style>