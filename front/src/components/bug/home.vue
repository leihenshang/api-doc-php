<template>
  <div class="bug-home">
    <h4>BUG管理</h4>
    <div class="content">
      <div class="left">
        <ul>
          <li>
            <a href="#">测试的点击菜单</a>
          </li>
          <li>
            <a href="#">测试的点击菜单</a>
          </li>
          <li>
            <a href="#">测试的点击菜单</a>
          </li>
          <li>
            <a href="#">测试的点击菜单</a>
          </li>
          <li>
            <a href="#">测试的点击菜单</a>
          </li>
          <li>
            <a href="#">测试的点击菜单</a>
          </li>
        </ul>
      </div>
      <div class="right">
        <p>段落一</p>
        <p>段落一</p>
        <p>段落一</p>
        <p>段落一</p>
        <p>段落一</p>
        <p>段落一</p>
        <p>段落一</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "bugHome",
  props: {
    id: String,
  },
};
</script>

<style lang="scss" scoped>
.bug-home {
  .content {
    .left {
      border: 1px solid black;
    }

    .right {
      border: 1px solid black;
    }
  }
}
</style>
