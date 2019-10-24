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
          <li @click="jump('api')">
            <a href="javascript:void;">
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
        <div class="right-l">
          <div class="title">
            <span>{{projectData.title}}</span>
          </div>
          <ul>
            <li>
              <p>项目类型</p>
              <p>{{projectData.type}}</p>
            </li>
            <li>
              <p>项目版本</p>
              <p>{{projectData.version}}</p>
            </li>
            <li>
                <p>创建时间</p>
              <p>{{projectData.create_time}}</p>
            </li>
            <li>
              <p>项目描述</p>
              <p>{{projectData.description}}</p>
            </li>
          </ul>
          <ul class="two">
            <li>
              <p>测试项目1</p>
              <p>完成了1个</p>
            </li>
            <li>
              <p>测试项目1</p>
              <p>完成了1个</p>
            </li>
            <li>
              <p>测试项目1</p>
              <p>完成了1个</p>
            </li>
            <li>
              <p>测试项目1</p>
              <p>完成了1个</p>
            </li>
          </ul>
          <p>特色功能</p>
          <ul>
            <li>
              <p>测试项目1</p>
              <p>完成了1个</p>
            </li>
            <li>
              <p>测试项目1</p>
              <p>完成了1个</p>
            </li>
            <li>
              <p>测试项目1</p>
              <p>完成了1个</p>
            </li>
            <li>
              <p>测试项目1</p>
              <p>完成了1个</p>
            </li>
          </ul>
        </div>
        <div class="right-r">
          <ul>
            <li>
              <p>项目动态</p>
              <p></p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
            <li>
              <p>2019-09-17 17:52:32</p>
              <p>XXX 添加项目文档分组:'test'</p>
            </li>
          </ul>
        </div>
      </div>
      <!-- 右侧内容结束 -->
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;
export default {
  name: "detail",
  props: {
    id: String
  },
  created() {
    this.getDetail();
  },
  data() {
    return {
      test: 0,
      projectData: {}
    };
  },
  methods: {
    getDetail() {
      this.$http
        .get(this.apiAddress + "/project/detail", {
          params: { id: this.$route.params.id }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.projectData = response.data;
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    jump(name){
        this.$router.push("/api/"+this.id);
    }
  }
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

.right-l {
  width: 50%;
  height: 100%;
  float: left;
  padding: 5px;
  box-sizing: border-box;
  border-radius: 3px;
  overflow: hidden;
}

.right-l .title {
  height: 130px;
  border: 1px solid #e5e5e5;
  line-height: 130px;
  padding-left: 20px;
  font-weight: 700;
  font-size: 2em;
  color: #4caf50;
  background-color: #fff;
}

.right-l ul {
  width: 100%;
  display: flex;
  background-color: #fff;
}

.right-l ul.two {
  margin: 20px 0;
  border-top: 1px solid #e5e5e5;
}

.right-l ul li {
  flex: 1;
  height: 80px;
  border-right: 1px solid #e5e5e5;
  border-bottom: 1px solid #e5e5e5;
}

.right-l ul li:first-child {
  border-left: 1px solid #e5e5e5;
}

.right-l ul li p:first-child {
  font-size: 18px;
  margin: 10px 15px;
}

.right-l ul li p:last-child {
  font-size: 12px;
  color: gray;
  margin: 10px 15px;
}

ul:nth-child(5) {
  margin-top: 20px;
  border-top: 1px solid #e5e5e5;
}

.right-r {
  width: 50%;
  height: 100%;
  float: left;
  background-color: #f3f3f3;
}

.right-r ul {
  margin: 15px;
}

.right-r li {
  margin: 5px 0;
  text-align: left;
}

.right-r li p {
  padding-left: 10px;
}

.right-r li p:last-child {
  border-left: 1px solid #b6b6b6;
  margin-left: 5px;
  font-size: 14px;
  height: 30px;
  line-height: 30px;
}

.right-r li p:first-child {
  font-size: 12px;
  color: #b6b6b6;
  padding: 0;
}

.right-r li p:first-child::before {
  content: "●";
  color: #b6b6b6;
  margin-left: 1px;
  margin-right: 5px;
}
.right-r ul li:first-child p:first-child::before {
  content: "📅";
}

.right-r ul li:first-child p {
  border: none;
  font-size: 14px;
  color: black;
}

.right-r ul li:first-child p:last-child {
  height: 10px;
}
</style>
