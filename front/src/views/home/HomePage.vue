<template>
  <div class="homePage-wrapper">
    <Header></Header>
    <n-layout has-sider class="menu-layout">
      <n-layout-sider class="menu-sider" bordered collapse-mode="width" :collapsed-width="64" :width="290"
                      :collapsed="collapsed" @collapse="collapsed = true" @expand="collapsed = false">
        <n-menu class="menu-menu" :collapsed="collapsed" :collapsed-width="64" :collapsed-icon-size="22"
                :options="menuOptions" :indent="24" :render-label="renderMenuLabel" :default-value="route.path"
                :render-icon="renderMenuIcon"/>
      </n-layout-sider>
      <n-layout class="right">
        <router-view></router-view>
      </n-layout>
    </n-layout>
  </div>
</template>

<script lang="ts">
import Header from '../../components/Header.vue';
import {h, ref,onMounted} from 'vue';
import { RouterLink,useRoute} from 'vue-router'
import {NIcon} from 'naive-ui';
import {BookmarkOutline} from '@vicons/ionicons5';

const menuOptions = [
  {
    label: '项目列表',
    pathName:'ProjectList',
    key: '/ProjectList',
    iconName:BookmarkOutline,
  }, {
    label: '用户管理',
    pathName:'UserManagement',
    key: '/UserManagement',
    iconName:BookmarkOutline,
  }, {
    label: '小记',
    key: 'node',
    iconName:BookmarkOutline,
  }, {
    label: '最近浏览',
    key: 'RecentBrowse',
    iconName:BookmarkOutline,
  }, {
    label: '收藏',
    key: 'like',
    iconName:BookmarkOutline,
  }
];

export default {
  name: 'HomePage',
  components: {Header},
  setup() {
    const route = useRoute()
    return {route,
      collapsed: ref(false),
      menuOptions,
      renderMenuLabel(option) {
        if ('pathName' in option) {
          return h(RouterLink,
              {
                to: {
                  name: option.pathName,
                }
              },
              { default: () => option.label });

        }
        return option.label;
      },
      renderMenuIcon(option) {
        // 渲染图标占位符以保持缩进
        // if (option.key === 'sheep-man') return true;
        // 返回 falsy 值，不再渲染图标及占位符
        // if (option.key === 'food') return null;
        // return h(NIcon, null, {default: () => h(BookmarkOutline)});
        return option.iconName && h(NIcon, null, {default: () => h(option.iconName)});
      },
    };
  }
};
</script>

<style scoped lang='scss'>
@import "../../assets/style/helper";

.homePage-wrapper {
  height: 100%;

  > .menu-layout {
    height: calc(100% - #{$headerHeight});

    .menu-sider {
      background: $menuBackground;

      .menu-menu::v-deep {
        .n-menu-item.n-menu-item--selected {
          .n-menu-item-content {
            .n-menu-item-content__icon, .n-menu-item-content-header {
              color: darken($mainColor, 0.5);
            }
          }
        }

        .n-menu-item > .n-menu-item-content:hover {
          .n-menu-item-content__icon, .n-menu-item-content-header {
            color: darken($mainColor, 0.5);
          }
        }

      }
    }
    .right{
      padding: 16px;
    }
  }
}
</style>