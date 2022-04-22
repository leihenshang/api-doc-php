<template>
  <div class="collect-wrapper">
    <div class="left">
      <div class="title">
        <span>收藏列表</span>
        <SvgIcon icon-name="add"></SvgIcon>
      </div>
      <ul class="list">
        <li v-for="item in collectionList" :key="item.id"
            :class="{'selectedCollection':selectedCollectionId === item.id}"
            @click="viewCollectionList(item.id)">
          <p class="title">
            <span>{{ item.title }}</span>
            <n-popselect v-model:value="handleType" :options="collectionHandleOptions" trigger="hover"
                         :on-update:value="changeHandleType">
              <div>
                <SvgIcon icon-name="more" v-if="item.type!=='all'"></SvgIcon>
              </div>
            </n-popselect>
          </p>
          <p class="content">{{ item.count }}条内容</p>
        </li>
      </ul>
    </div>
    <div class="right">
      <div class="title">
        <h3>{{ selectedGroupName }}</h3>
        <div class="search">
          <n-input v-model:value="searchData.data1" type="text" size="small" placeholder="基本的 Input">
            <template #prefix>
              <SvgIcon icon-name="search"></SvgIcon>
            </template>
          </n-input>
          <SvgIcon icon-name="filter"></SvgIcon>
        </div>
      </div>
      <n-data-table :columns="columns" :data="data" :pagination="pagination" :bordered="false"/>
    </div>
  </div>
  <n-modal v-model:show="showModal" preset="dialog" title="Dialog" :show-icon="false" class="modal-dialog"
           :mask-closable=false style="position: fixed; left: 50%;transform: translateX(-50%);top: 100px">
    <template #header>
      <div>编辑分组</div>
    </template>
    <div class="dialog-content">
      <label>分组名称</label>
      <n-input v-model:value="newGroupName" type="text" placeholder="分组名称"></n-input>
    </div>
    <template #action>
      <n-button type="primary">确定</n-button>
      <n-button>取消</n-button>
    </template>
  </n-modal>
</template>

<script lang="ts">
import SvgIcon from '../../components/public/SvgIcon.vue';
import {h, defineComponent, computed, ref} from 'vue';
import {NButton, useMessage, DataTableColumns} from 'naive-ui';

type Song = {
  no: number
  title: string
  length: string
}
type search = {
  data1?: string
  data2?: string
}

const createColumns = ({play}: { play: (row: Song) => void }): DataTableColumns<Song> => {
  return [
    {
      title: 'No',
      key: 'no'
    },
    {
      title: 'Title',
      key: 'title'
    },
    {
      title: 'Length',
      key: 'length'
    },
    {
      title: 'Action',
      key: 'actions',
      render(row) {
        return h(
            NButton,
            {
              strong: true,
              tertiary: true,
              size: 'small',
              onClick: () => play(row)
            },
            {default: () => 'Play'}
        );
      }
    }
  ];
};

const data: Song[] = [
  {no: 3, title: 'Wonderwall', length: '4:18'},
  {no: 4, title: 'Don\'t Look Back in Anger', length: '4:48'},
  {no: 12, title: 'Champagne Supernova', length: '7:27'}
];

export default {
  name: 'Collection',
  components: {SvgIcon},
  setup() {
    const collectionList = [{title: '全部', type: 'all', count: 100, id: '1'}
      , {title: 'javaScript', type: '', count: 50, id: '2'}, {title: '好看的花花们', type: '', count: 50, id: '3'},];
    const searchData = ref<search>({});
    const selectedCollectionId = ref('1');
    const showModal = ref(false);
    const newGroupName = ref('');
//选中收藏的某个分类，并保存分类的id
    const viewCollectionList = (collectionId: string) => {
      selectedCollectionId.value = collectionId;
    };
//左侧收藏分类的编辑删除操作
    const handleType = ref('update');
    const collectionHandleOptions = [{label: '编辑', value: 'update'}, {label: '删除', value: 'delete'}];
    const changeHandleType = (value: string) => {
      console.log(value);
      if (value === 'update') {
        newGroupName.value = ''
        showModal.value = true;
      }
    };
    //弹出编辑对话框

//获取右侧表格的标题
    const selectedGroupName = computed(() => {
      return collectionList.filter((item) => item.id === selectedCollectionId.value)[0]?.title;
    });
//渲染右侧表格
    const message = useMessage();
    return {
      collectionList,
      viewCollectionList,
      handleType,
      collectionHandleOptions,
      changeHandleType,
      showModal,
      newGroupName,
      selectedCollectionId,
      selectedGroupName,
      data,
      searchData,
      columns: createColumns({
        play(row: Song) {
          message.info(`Play ${row.title}`);
        }
      }),
      pagination: false as const
    };
  }
};
</script>

<style scoped lang='scss'>
$grey-color: #8A8F8D;
$grey-background: #eff0f0;
//.pop-select-options{
//  margin-left: -20px;
//  margin-right: -32px;
//  > li{
//    padding: 4px 0;
//
//    &:hover{
//      background: $grey-background;
//    }
//  }
//}
.collect-wrapper {
  display: flex;
  height: 100%;

  .title {
    color: $grey-color;
    display: flex;
    justify-content: space-between;
    align-items: center;

    > .icon {
      color: #000000;
      cursor: pointer;
    }
  }

  > .left {
    width: 204px;
    padding: 20px 12px;
    border-right: 1px solid #f4f5f5;

    > .title {
      margin-bottom: 20px;

      > .icon {
        margin-right: 12px;
      }
    }

    > .list > li {
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 4px;
      cursor: pointer;

      &.selectedCollection {
        background: $grey-background;
      }

      &:hover {
        background: $grey-background
      }

      > .title {
        color: #585A5A;
      }

      > .content {
        font-size: 12px;
        color: $grey-color;
        margin-top: 1em;
      }
    }
  }

  > .right {
    width: calc(100% - 204px);
    padding: 10px 24px 20px;

    > .title {
      display: flex;
      color: #262626;
      padding: 10px 0;
      align-items: center;

      h3 {
        font-size: 16px;
      }

      > .search {
        display: flex;
        align-items: center;

        > .n-input {
          background: #fafafa;

          &::v-deep(.n-input__border), &::v-deep(.n-input__state-border) {
            display: none;
          }

          &.n-input--focus {
            border: none;
          }
        }

        > .icon {
          color: #585A5A;
          font-size: 18px;
          margin-left: 4px;
        }
      }
    }
  }
}

.dialog-content {
  > label {
    display: inline-flex;
    margin-bottom: 4px;
  }
}
</style>