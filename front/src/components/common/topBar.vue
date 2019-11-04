<template>
  <div class="top-bar">
      <ul>
        <li class="t-link">
          <a href="#">(●'◡'●)</a>
        </li>
        <li class="name">
          <span>apiDoc开源版本</span>
        </li>
        <li>
          <span>API接口>电子社-工信书院>项目概况</span>
        </li>
         <li class="t-r">
          <em>😉</em>
          <div class="user-lay" id="user-lay">
            <ul>
              <li>
                <a href="#">用户操作</a>
              </li>
              <li>
                <a href="#">用户操作</a>
              </li>
              <li>
                <a href="#">用户操作</a>
              </li>
              <li>
                <a href="#">用户操作</a>
              </li>
            </ul>
          </div>
        </li>
        
      </ul>
  </div>
</template>

<script>
export default {
  name: "topBar",
  props: {
    menuList: Array
  },
  computed: {},
  methods: {},
  data: function() {
    return {};
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
/* <!-- 头部导航栏开始 --> */
.top-bar {
  height: 50px;
  line-height: 50px;
  border-bottom: 1px solid #e5e5e5;
  font-size: 14px;
}

.top-bar ul {
  overflow: hidden;
  /* width: 100%; */
}

.top-bar li {
  float: left;
}

.top-bar .t-r {
  float: right;
  border-left: 1px solid #e5e5e5;
}

.top-bar .t-link {
  padding: 0 15px;
  border-right: 1px solid #e5e5e5;
}

.top-bar .t-link a {
  color: #999;
}

.top-bar .name {
  width: 155px;
  padding-left: 10px;
}

.top-bar span {
  color: #999;
}

.top-bar em {
  display: block;
  padding: 0 14px;
  font-style: normal;
}

.top-bar em:hover {
  background-color: #4caf50;
}
</style>
