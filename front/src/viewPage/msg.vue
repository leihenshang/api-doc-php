<template>
  <div class="msg">
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
          <span>消息管理</span>
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
    <!-- 头部导航栏结束 -->
    <div class="content">
  
      <!-- 左侧导航栏结束 -->
      <!-- 右侧内容开始 -->
      <div class="right">
        <div class="right-btn">
          <button>消息列表</button>
          <button>清空消息</button>
        </div>
        <div class="right-content">
          <table>
            <tr>
              <th>类型</th>
              <th>消息</th>
              <th>时间</th>
            </tr>

            <tr>
              <td>项目</td>
              <td>您已经被加入项目：电子社-工信书院，现在你可以参与项目的开发协作工作。</td>
              <td>2019-08-19 09:44:00</td>
            </tr>
            <tr>
              <td>测试项目1</td>
              <td>您已经被加入项目：电子社-工信书院，现在你可以参与项目的开发协作工作。</td>
              <td>2019-08-19 09:44:00</td>
            </tr>
            <tr>
              <td>测试项目1</td>
              <td>您已经被加入项目：电子社-工信书院，现在你可以参与项目的开发协作工作。</td>
              <td>2019-08-19 09:44:00</td>
            </tr>
            <tr>
              <td>测试项目1</td>
              <td>您已经被加入项目：电子社-工信书院，现在你可以参与项目的开发协作工作。</td>
              <td>2019-08-19 09:44:00</td>
            </tr>
            <tr>
              <td>测试项目1</td>
              <td>您已经被加入项目：电子社-工信书院，现在你可以参与项目的开发协作工作。</td>
              <td>2019-08-19 09:44:00</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- 右侧内容结束 -->
    </div>
  </div>
</template>

<script>
export default {
  name: "app"
};
</script>

<style>
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
  list-style: none;
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

.top .t-r:hover {
  background-color: #4caf50;
}


.message {
  border-bottom: 1px solid #e5e5e5;
}

/* <!-- 右侧内容开始 --> */
.right {
  position: absolute;
  width: 87%;
  height: 100%;
  left: 241px;
  background-color: #f8f8f8;
}

.right-btn {
  margin: 10px;
}

.right-btn button {
  border: 1px solid #e5e5e5;
  padding: 8px 20px;
  border-radius: 3px;
  background-color: #fff;
}

.right-content {
  border: 1px solid #e5e5e5;
  margin: 10px;
}

.right-content table,
tbody,
tr,
th,
td {
  border: 0;
  border-collapse: collapse;
}

.right-content table {
  background-color: #fff;
}

.right-content tr th {
  border-bottom: 1px solid #e5e5e5;
  text-align: left;
  padding: 15px 0;
}

.right-content tr td {
  padding: 15px 0;
}

.right-content tr:hover {
  background-color: #efefef;
}

.right-content tr th:first-child,
.right-content tr td:first-child {
  padding-left: 10px;
}

.right-content table {
  width: 100%;
  font-size: 14px;
}

.user-lay {
  border: 1px solid #e5e5e5;
  width: 200px;
  height: 200px;
  background-color: #fff;
  position: absolute;
  right: 0;
  /* margin: 5px 0; */
  z-index: 1;
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.12);
  display: none;
}

.user-lay ul {
  overflow: hidden;
}

.user-lay ul li {
  box-sizing: border-box;
  width: 100%;
  float: none;
  height: 50px;
}

.user-lay ul li a {
  display: block;
  color: black;
  padding-left: 10px;
  width: 100%;
  height: 100%;
}

.user-lay ul li a:hover {
  background-color: #f0f0f0;
}

.top .t-r:hover .user-lay {
  display: block;
}
</style>
