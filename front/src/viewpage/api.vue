<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="detail">
    <!-- 头部导航栏开始 -->
    <div class="top">
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
        </li>
      </ul>
    </div>
    <!-- 头部导航栏结束 -->
    <div class="content">
      <!-- 左侧导航栏开始 -->
      <div class="left">
        <ul>
          <li>
            <a href="#">
              <span>▢</span> 项目概况
            </a>
          </li>
          <li>
            <a href="#">
              <span>▢</span> API接口
            </a>
          </li>
          <li>
            <a href="#">
              <span>▢</span> 自动化测试
            </a>
          </li>
          <li>
            <a href="#">
              <span>▢</span> 接口错误日志
            </a>
          </li>
          <li>
            <a href="#">
              <span>▢</span> 状态码
            </a>
          </li>
          <li>
            <a href="#">
              <span>▢</span> 项目文档
            </a>
          </li>
          <li>
            <a href="#">
              <span>▢</span> 环境管理
            </a>
          </li>
          <li>
            <a href="#">
              <span>▢</span> 协作管理
            </a>
          </li>
          <li>
            <a href="#">
              <span>▢</span> 项目动态
            </a>
          </li>
        </ul>
      </div>
      <!-- 左侧导航栏结束 -->
      <!-- 右侧内容开始 -->
      <div class="right">
       
      </div>
      <!-- 右侧内容结束 -->
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "api",
  props: {
    id: String
  },
  created() {},
  data() {
    return {};
  },
  methods: {}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.content {
  width: 100%;
  position: relative;
}

/* <!-- 头部导航栏开始 --> */
.top {
  height: 50px;
  line-height: 50px;
  border-bottom: 1px solid #e5e5e5;
  font-size: 14px;
}

.top ul {
  overflow: hidden;
  /* width: 100%; */
}

.top li {
  float: left;
}

.top .t-r {
  float: right;
  border-left: 1px solid #e5e5e5;
}

.top .t-link {
  padding: 0 15px;
  border-right: 1px solid #e5e5e5;
}

.top .t-link a {
  color: #999;
}

.top .name {
  width: 155px;
  padding-left: 10px;
}

.top span {
  color: #999;
}

.top em {
  display: block;
  padding: 0 14px;
  font-style: normal;
}

.top em:hover {
  background-color: #4caf50;
}

/* <!-- 左侧导航栏开始 --> */
.left {
  width: 240px;
  height: 100%;
  border-right: 1px solid #e5e5e5;
  position: fixed;
  top: 51px;
  left: 0;
}

.left li {
  padding: 15px 0;
  text-align: left;
}

.left li:first-child {
  background-color: #e3f1e5;
}

.left li:first-child a {
  color: #4caf50;
}

.left li:hover {
  background-color: #e3f1e5;
}

.left li span {
  display: inline-block;
  padding: 0 32px;
}

.left li a {
  width: 100%;
  display: block;
  font-size: 14px;
  color: black;
}

.message {
  border-bottom: 1px solid #e5e5e5;
}

/* <!-- 右侧内容开始 --> */
.right {
  position: fixed;
  width: 87%;
  height: 100%;
  left: 241px;
  background-color: #f8f8f8;
}



ul:nth-child(5) {
  margin-top: 20px;
  border-top: 1px solid #e5e5e5;
}


</style>
