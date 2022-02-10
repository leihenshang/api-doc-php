<template>
  <div >
    <n-data-table :columns="columns" :data="data" :pagination="pagination" :bordered="false" :bottom-bordered="false"
                  :row-class-name="rowClassName" size="small" striped
    />
  </div>

</template>

<script lang="ts">
import { h, defineComponent } from 'vue'
import { NButton, useMessage, DataTableColumns } from 'naive-ui'

// type Song = {
//   no: number,
//   title: string,
//   length: string
// }

// const createColumns = ({play}: {
//   play: (row: Song) => void
// }): DataTableColumns<Song> => {
//   return [
//     {
//       title: 'No',
//       key: 'no',
//       className: 'first'
//     },
//     {
//       title: 'Title',
//       key: 'title',
//       className: 'head'
//     },
//     {
//       title: 'Length',
//       key: 'length',
//       className: 'head'
//     },
//     {
//       title: 'Action',
//       key: 'actions',
//       className: 'head',
//       // render (row) {
//       //   return h(
//       //       NButton,
//       //       {
//       //         strong: true,
//       //         tertiary: true,
//       //         size: 'small',
//       //         onClick: () => play(row)
//       //       },
//       //       { default: () => 'Play' }
//       //   )
//       // }
//     }
//   ]
// }

// const data: Song[] = [
//   { no: 3, title: 'Wonderwall', length: '4:18' },
//   { no: 4, title: "Don't Look Back in Anger", length: '4:48' },
//   { no: 12, title: 'Champagne Supernova', length: '7:27' }
// ]

export default defineComponent({
  props:{
    rowType:{type:Object,required:true}
  },
  setup (props) {
    const message = useMessage()
    console.log(props.rowType);
    let xxx = props.rowType as const
    type Song = {
      no: number,
      title: string,
      length: string
    }
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
    return {
      data,
      columns: createColumns({
        play (row: Song) {
          message.info(`Play ${row.title}`)
        }
      }),
      pagination: false as const,
      rowClassName (row, index) {
        if (index % 2 !== 0){
          return 'xxx'
        }
      }
    }
  }
})
</script>

<style scoped lang="scss">
$striped-color:#f2f2f2;
$table-border-color:#DBDBDB;

::v-deep(.n-data-table-tr th){
  background: $striped-color !important;
  border-top: 1px solid $table-border-color  !important;
  border-bottom: 1px solid $table-border-color  !important;
}
::v-deep(.n-data-table-tr td){
  border-bottom: 1px solid $table-border-color  !important;
}
::v-deep(.head){
  border-right: 1px solid $table-border-color;
}
::v-deep(.first){
  border-left: 1px solid $table-border-color;
  border-right: 1px solid $table-border-color;
}
::v-deep(.xxx td) {
  background: $striped-color !important;
}
</style>