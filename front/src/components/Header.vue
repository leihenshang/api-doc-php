<template>
  <header>
    <section class="left">
      <img src="../assets/images/duck.png" class="favicon" alt="" width="32" height="33"/>
      <h3>apiDoc</h3>
    </section>
    <section class="right">
      <div class="breadcrumb">项目列表</div>
      <div class="avatar-wrapper">
        <n-avatar class="avatar" round size="medium" src="https://07akioni.oss-cn-beijing.aliyuncs.com/07akioni.jpeg"/>
        <n-icon size="18">
          <chevron-down />
        </n-icon>
      </div>
    </section>
  </header>
</template>

<script lang="ts">
import { ChevronDown } from '@vicons/ionicons5'

export default {
  name: 'Header',
  components: {ChevronDown}

};
</script>

<style scoped lang='scss'>
$menuWidth:256px;
header {
  width: 100%;
  height: 60px;
  background: #00acc1;
  color: #ffffff;
  display: flex;
  align-items: center;
  padding: 0 32px;
  > .left{
    display: flex;
    width: $menuWidth;
    > h3{
      font-size: 24px;
      margin-left: 8px;
    }
  }
  > .right{
    display: flex;
    width: calc(100% - #{$menuWidth});
    align-items: center;
    > .avatar-wrapper{
      margin-left: auto;
      display: flex;
      align-items: center;
      > .avatar{
        margin-right: 8px;
      }
    }
  }
}
</style>