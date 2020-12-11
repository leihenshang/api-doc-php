<template>
  <div class="bottom-bar">
    <div class="item-box">
      <div class="item">
        <h5>站点信息</h5>
        <ul>
          <li>
            <span>api-doc是我自己的网站</span>
          </li>
          <li>
            <span>api-doc开源项目2020</span>
          </li>
          <li>
            <span>xxxxxxxxx</span>
          </li>
          <li>
            <span>x公网备案xxxxxx</span>
          </li>
        </ul>
      </div>
      <div class="item">
        <h5>常用链接</h5>
        <ul>
          <li>
            <span>xxxxxxxx</span>
          </li>
          <li>
            <span>xxxxxxxx</span>
          </li>
          <li>
            <span>xxxxxxxx</span>
          </li>
          <li>
            <span>xxxxxxxx</span>
          </li>
        </ul>
      </div>
      <div class="item">
        <h5>关于我们</h5>

        <ul>
          <li>
            <span>地址：xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</span>
          </li>
          <li>
            <span>邮箱：xxxxxxxxxxxxxxxxx</span>
          </li>
          <li>
            <span>电话：xxxxxxxxxxxxxxxxxxxxxx</span>
          </li>
          <li>
            <span>微信：xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "bottomBar",
  created() {},
  props: {},
};
</script>

<style lang="scss" scoped>
.bottom-bar {
  height: 150px;
  width: 100%;
  background-color: #409EFF;
  color: #eeeeee;
  ul {
    margin: 0 20px;
    padding: 0;
    li {
      list-style: none;
      span {
        font-size: 12px;
      }
    }
  }

  .item-box {
    width: 60%;
    margin: 0 auto;
    display: flex;
    .item {
      flex: 1;
    }
  }
}
</style>
