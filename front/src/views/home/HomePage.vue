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
import SvgIcon from '../../components/public/SvgIcon.vue';

const menuOptions = [
  {
    label: '收藏',
    key: 'like',
    pathName: 'Collection',
    iconName: 'collect',
  }, {
    label: '我的笔记',
    key: 'notes',
    iconName: 'notes',
    children: [
      {
        label: '工作',
        key: 'work',
        pathName: 'Work',
        iconName: 'work',
      }, {
        label: '生活',
        pathName: 'Life',
        key: 'life',
        iconName: 'life',
      }, {
        label: '经验',
        key: 'experience',
        pathName: 'Experience',
        iconName: 'experience',
      }
    ]
  }, {
    label: '日常计划',
    key: 'plan',
    pathName: 'Plane',
    iconName: 'plan',
  }, {
    label: '我的日记本',
    key: 'diary',
    pathName: 'Diary',
    iconName: 'diary',
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
        return option.iconName && h(SvgIcon, {iconName:option.iconName});
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
  }
}
</style>