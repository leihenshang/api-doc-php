<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="detailPage">
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

      <ul>
        <li @click="jump()" class="api-detail">
          <p>api接口</p>
          <p>点击查看详情</p>
        </li>
        <li></li>
        <li></li>
        <li></li>
      </ul>

      <!-- 右侧内容结束 -->
    </div>
    <div class="right-r">
      <message />
    </div>
  </div>
</template>

<script>
import Message from "./message";

const CODE_OK = 200;
export default {
  name: "detailPage",
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
        { title: "项目概况", route: "detail", child: "detailPage" },
        { title: "API接口", route: "detail", child: "apiPage" }
      ]
    };
  },
  methods: {
    //获取项目详情
    getDetail() {
      this.$http
        .get(this.apiAddress + "/project/detail", {
          params: {
            id: this.$route.params.id,
            token: this.$store.state.userInfo.token
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.projectData = response.data;
              this.$store.commit("saveProject", response.data);
            } else {
              alert("failed:" + response.msg);
            }
          },
          res => {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    },
    jump() {
      this.$router.push({ name: "apiPage", params: { id: this.id } });
    }
  },
  components: {
    message: Message
  }
};
</script>

<style scoped>
.detailPage {
  display: flex;
  width: 100%;
  height: 100%;
}

.right-l {
  width: 50%;
  height: 100%;
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
  background-color: #f3f3f3;
}

.api-detail {
  background-color: #5ace5e6e;
}

.api-detail:hover {
  background-color: #5ace5e;
}
</style>
