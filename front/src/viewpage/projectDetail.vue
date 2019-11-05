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
      <topBar />
    </div>
    <!-- 头部导航栏结束 -->
    <div class="content">
      <!-- 左侧导航栏开始 -->
      <div class="left">
        <leftMenu :menuList="indesideRoute" />
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
        </div>
        <div class="right-r">
          <message />
        </div>
      </div>
      <!-- 右侧内容结束 -->
    </div>
  </div>
</template>

<script>
import Message from "../components/detail/message";
import LeftMenu from "../components/common/leftMenu";
import TopBar from "../components/common/topBar";

const CODE_OK = 200;
export default {
  name: "projectDetail",
  props: {
    id: String
  },
  created() {
    this.getDetail();
  },
  data() {
    return {
      projectData: {},
      indesideRoute: [
        { title: "项目概况", route: "detail" },
        { title: "API接口", route: "api" }
      ]
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
    jump(name) {
      this.$router.push("/" + name + "/" + this.id);
    }
  },
  components: {
    message: Message,
    leftMenu: LeftMenu,
    topBar: TopBar
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.content {
  width: 100%;
  position: relative;
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
</style>
