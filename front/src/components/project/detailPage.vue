<template>
  <div class="detailPage">
    <div class="right-l">
      <div class="info-box">
        <div class="title">
          <span>{{projectData.title}}</span>
        </div>
        <div class="desc">
          <span>{{projectData.description}}</span>
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
          <li @click="jump()" class="api-detail">
            <p>api接口</p>
            <p>
              <el-link type="danger">点击查看详情</el-link>
            </p>
          </li>
        </ul>
      </div>

      <!-- 右侧内容结束 -->
    </div>
    <div class="right-r">
      <message></message>
    </div>
  </div>
</template>

<script>
import Message from "./operationLog";

const CODE_OK = 200;
export default {
  name: "detailPage",
  props: {
    id: String,
  },
  created() {
    this.getDetail();
  },
  data() {
    return {
      loading: false,
      keyword: "",
      projectData: {},
      indesideRoute: [
        { title: "项目概况", route: "detail", child: "detailPage" },
        { title: "API接口", route: "detail", child: "apiPage" },
      ],
    };
  },
  methods: {
    //获取项目详情
    getDetail() {
      this.$http
        .get("/project/detail", {
          params: {
            id: this.$route.params.id,
          },
        })
        .then(
          (response) => {
            response = response.data;
            if (response.code === CODE_OK) {
              this.projectData = response.data;
              this.$store.commit("saveProject", response.data);
            } else {
              this.$message.error("failed:" + response.msg);
            }
          },
          (res) => {
            let response = res.data;
            this.$message.error(
              "获取数据-操作失败!" + !response.msg ? response.msg : ""
            );
          }
        );
    },

    jump() {
      this.$router.push({
        name: "apiPage",
        params: { projectId: this.id, groupId: 0 },
      });
    },
  },
  components: {
    message: Message,
  },
};
</script>

<style lang="scss" scoped>
.detailPage {
  display: flex;
}

.right-l {
  width: 50%;
  height: 100%;
  padding: 5px 5px 5px 0;
  box-sizing: border-box;
  border-radius: 3px;
  overflow: hidden;
  background-color: #fff;
}

.right-l .title {
  height: 100px;
  border: 1px solid #e5e5e5;
  line-height: 100px;
  box-sizing: border-box;
  padding-left: 20px;
  font-weight: 700;
  font-size: 2em;
  color: #4caf50;
}

.desc {
  border-bottom: 1px solid #e5e5e5;
  border-left: 1px solid #e5e5e5;
  border-right: 1px solid #e5e5e5;
  font-size: 18px;
  color: #7e7d7d;
}

.desc span {
  display: block;
  padding: 8px 6px;
  font-size: 12px;
}

.right-l ul {
  width: 100%;
  display: flex;
  margin: 0;
  padding: 0;
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
  list-style: none;
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

.right-r {
  margin-top: 5px;
  box-sizing: border-box;
  width: 50%;
  height: 100%;
  border-left: solid 1px #e6e6e6;
  border-bottom: solid 1px #e6e6e6;
  border-top: solid 1px #e6e6e6;
  box-sizing: border-box;
  padding: 10px;
  overflow-y: scroll;
}

.right-l ul li.api-detail p:last-child {
  color: red;
}
</style>
