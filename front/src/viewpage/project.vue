<template>
  <div class="project">
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
          <span>接口管理</span>
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
      <!-- 左侧导航栏开始 -->
      <div class="left">
        <ul>
          <li>
            <a href="javascript:void;" @click="jump('project')">
              <span>▢</span> 接口管理
            </a>
          </li>
          <li>
            <a href="#">
              <!-- <span>▢</span> 数据库管理 -->
            </a>
          </li>
          <li>
            <a href="#">
              <!-- <span>▢</span> 账户管理 -->
            </a>
          </li>
          <li class="message">
            <a href="javascript:void;" @click="jump('msg')">
              <!-- <span>▢</span> 消息管理 -->
            </a>
          </li>
          <li>
            <a href="#">
              <!-- <span>▢</span> 官方网站 -->
            </a>
          </li>
          <li>
            <a href="#">
              <!-- <span>▢</span> 用户讨论群 -->
            </a>
          </li>
        </ul>
      </div>
      <!-- 左侧导航栏结束 -->

      <!-- 右侧内容开始 -->
      <div class="right">
        <!-- 遮罩层 -->
        <boxShade :hide="hideShade" />

        <div class="right-btn">
          <button @click="create">+新增项目</button>
          <!-- <button>+导入项目</button>
          <button>+开启SDK提交项目</button>-->
        </div>
        <div class="right-content">
          <table>
            <tr>
              <th>项目名称</th>
              <th>描述</th>
              <th>版本号</th>
              <th>类型</th>
              <th>修改时间</th>
              <th>操作</th>
            </tr>
            <tr v-for="item in projectList" :key="item.id">
              <td>{{item.title}}</td>
              <td>{{item.description}}</td>
              <td>v{{item.version}}</td>
              <td>{{item.type}}</td>
              <td>{{item.create_time}}</td>
              <td>
                <button @click="detail(item.id)">详情</button>
                <button @click="update(item)">修改</button>
                <button @click="del(item.id)">删除</button>
              </td>
            </tr>
          </table>
        </div>
        <div class="page-wrapper">
          <page
            :curr="currPage"
            :itemCount="itemCount"
            :pageSize="pageSize"
            v-on:jump-page="jumpPage"
          />
        </div>
      </div>
      <!-- 右侧内容结束 -->
    </div>
    <div class="add-wrapper">
      <add :is-show="addIsHide" :update-data="updateData" v-on:hide-box="onClickHide" />
    </div>
  </div>
</template>

<script>
import add from "../components/project/add";
import page from "../components/common/page";
import boxShade from "../components/common/boxShade";
const CODE_OK = 200;
const PAGE_SIZE = 5;

export default {
  name: "projectPage",
  methods: {
    jump(route) {
      this.$router.push({ path: "/" + route });
    },
    getProjectList(curr, pageSize) {
      this.$http
        .get(this.apiAddress + "/project/list", {
          params: { cp: curr, ps: pageSize }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.projectList = response.data.res;
              this.itemCount = Number(response.data.count);
              this.hideShade = true;
            }
          },
          function(res) {
            let response = res.body;
            alert("获取数据-操作失败!" + !response.msg ? response.msg : "");
            this.hideShade = true;
          }
        );
    },
    create() {
      this.addIsHide = !this.addIsHide;
    },
    onClickHide(val) {
      if (val === "flush") {
        this.currPage = 1;
        this.getProjectList(this.currPage, this.pageSize);
      }
      this.addIsHide = !this.addIsHide;
    },
    del(id) {
      this.$http
        .post(
          this.apiAddress + "/project/del",
          {
            id: id
          },
          { emulateJSON: true }
        )
        .then(
          function(res) {
            let response = res.body;
            if (response.code === CODE_OK) {
              alert("成功!" + response.msg);
              this.getProjectList(this.currPage, this.pageSize);
            } else {
              alert("失败!" + response.msg);
            }
          },
          function(res) {
            let response = res.body;
            alert("操作失败!" + response.msg);
          }
        );
    },
    update(item) {
      this.updateData = item;
      this.addIsHide = !this.addIsHide;
    },
    jumpPage(page) {
      this.currPage = page;
      this.hideShade = false;
      this.getProjectList(page, PAGE_SIZE);
    },
    detail(id) {
      this.$router.push("/detail/"+id);
    }
  },
  created() {
    this.getProjectList(this.currPage, this.pageSize);
  },
  data() {
    return {
      projectList: {},
      pageSize: 5,
      currPage: 1,
      addIsHide: true,
      updateData: null,
      itemCount: 0,
      hideShade: true
    };
  },
  components: {
    add,
    page,
    boxShade
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.isHide {
  display: none;
}

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
  text-align: left;
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
  text-align: left;
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

.box-shade {
  width: 100%;
  height: 100%;
  background-color: rgba(94, 88, 88, 0.2);
  position: absolute;
}

.box-shade span {
  position: absolute;
  background-color: #fff;
  height: 100px;
  width: 200px;
  line-height: 100px;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.right-btn {
  margin: 10px;
  text-align: left;
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
  min-height: 400px;
}

.right-content table,
tbody,
tr,
th,
td {
  border: 0;
  border-collapse: collapse;
  text-align: left;
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
