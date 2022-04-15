<template>
  <div class="homePage-wrapper">
    <Header></Header>
    <n-layout has-sider class="menu-layout">
      <n-layout-sider
          class="menu-sider"
          bordered
          collapse-mode="width"
          :collapsed-width="64"
          :width="290"
          :collapsed="collapsed"
          @collapse="collapsed = true"
          @expand="collapsed = false"
      >
        <n-menu
            class="menu-menu"
            :collapsed="collapsed"
            :collapsed-width="64"
            :collapsed-icon-size="22"
            :options="menuOptions"
            :indent="24"
            :render-label="renderMenuLabel"
            :default-value="route.path"
            :render-icon="renderMenuIcon"
        />
      </n-layout-sider>
      <n-layout class="right">
        <router-view></router-view>
      </n-layout>
    </n-layout>
  </div>
</template>

<script lang="ts">
import Header from '../../components/Header.vue';
import {h, ref, Component } from 'vue';
import type {MenuOption} from 'naive-ui';
import {useRoute, RouterLink} from 'vue-router';
import {NIcon} from 'naive-ui';
import {BookmarkOutline} from '@vicons/ionicons5';
import {ComponentOptions} from '@vue/runtime-core';

const menuOptions = [
  {
    label: '收藏',
    key: 'like',
    pathName: 'ProjectList',
    iconName: BookmarkOutline,
  }, {
    label: '我的笔记',
    pathName: 'MyNote',
    key: '/MyNote',
    iconName: BookmarkOutline,
    children: [
      {
        label: '工作',
        key: 'work',
        iconName: BookmarkOutline,
      }, {
        label: '生活',
        key: 'life',
        iconName: BookmarkOutline,
      }, {
        label: '经验',
        key: 'experience',
        iconName: BookmarkOutline,
      }
    ]
  }, {
    label: '日常计划',
    key: 'node',
    iconName: BookmarkOutline,
  }, {
    label: '我的日记本',
    key: 'node',
    iconName: BookmarkOutline,
  },
];

export default {
  name: 'HomePage',
  components: {Header},
  setup() {
    const route = useRoute();
    return {
      route,
      collapsed: ref(false),
      menuOptions,
      renderMenuLabel(option: MenuOption) {
        if ('pathName' in option) {
          return h(RouterLink,
              {
                to: {
                  name: option.pathName,
                }
              },
              {default: () => option.label}
          );
        }
        return option.label as string;
      },
      renderMenuIcon(option: MenuOption) {
        return option.iconName && h(NIcon, null, {default: () => h(option.iconName as Component)});
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

      .menu-menu ::v-deep(.n-menu-item.n-menu-item--selected) {
        .n-menu-item-content {
          .n-menu-item-content__icon,
          .n-menu-item-content-header {
            color: darken($mainColor, 0.5);
          }
        }

        .n-menu-item > .n-menu-item-content:hover {
          .n-menu-item-content__icon,
          .n-menu-item-content-header {
            color: darken($mainColor, 0.5);
          }
        }

      }
    }

    .right {
      padding: 16px;
    }
  }
}
</style>