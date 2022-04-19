<template>
  <div class="collect-wrapper">
    <div class="left">
      <div class="title">
        <span>收藏列表</span>
        <SvgIcon icon-name="add"></SvgIcon>
      </div>
      <ul class="list">
        <li>
          <p class="title">
            <span>收藏分类标题</span>
            <SvgIcon icon-name="add"></SvgIcon>
          </p>
          <p class="content">xxx条内容</p>
        </li>
      </ul>
    </div>
    <div class="right"></div>
  </div>
</template>

<script>
import SvgIcon from '../../components/public/SvgIcon.vue'
export default {
  name: 'Collection',
  components:{SvgIcon},
}
</script>

<style scoped lang='scss'>
$grey-color:#8A8F8D;
.collect-wrapper{
  display: flex;
  height: 100%;
  .title{
    color: $grey-color;
    display: flex;
    justify-content: space-between;
    align-items: center;
    > .icon{
      color:#000000;
    }
  }
  > .left{
    width: 204px;
    padding: 20px 12px;
    border-right: 1px solid #f4f5f5;
    > .title{
      margin-bottom: 20px;
      > .icon{
        margin-right: 12px;
      }
    }
    > .list> li{
      padding: 10px;
      background: #eff0f0;
      border-radius: 8px;
      > .title{
        color: #585A5A;
      }
      > .content{
        font-size: 12px;
        color: $grey-color;
        margin-top: 1em;
      }
    }
  }
  > .right{
    width: calc(100% - 204px);
  }
}
</style>