<template>
  <div class="message">
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
</template>

<script>
export default {
  name: 'message',
  props: {
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.message ul {
  margin: 15px;
}

.message li {
  margin: 5px 0;
  text-align: left;
}

.message li p {
  padding-left: 10px;
}

.message li p:last-child {
  border-left: 1px solid #b6b6b6;
  margin-left: 5px;
  font-size: 14px;
  height: 30px;
  line-height: 30px;
}

.message li p:first-child {
  font-size: 12px;
  color: #b6b6b6;
  padding: 0;
}

.message li p:first-child::before {
  content: "●";
  color: #b6b6b6;
  margin-left: 1px;
  margin-right: 5px;
}
.message ul li:first-child p:first-child::before {
  content: "📅";
}

.message ul li:first-child p {
  border: none;
  font-size: 14px;
  color: black;
}

.message ul li:first-child p:last-child {
  height: 10px;
}
</style>
