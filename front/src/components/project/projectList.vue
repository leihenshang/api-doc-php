<template>
  <div class="project-list">
    <!-- 遮罩层 -->
    <boxShade :hide="hideShade" />

    <div class="project-list-btn">
      <button @click="create">+新增项目</button>
      <!-- <button>+导入项目</button>
      <button>+开启SDK提交项目</button>-->
    </div>
    <div class="project-list-content">
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
      <div class="page-wrapper">
        <page
          :curr="currPage"
          :itemCount="itemCount"
          :pageSize="pageSize"
          v-on:jump-page="jumpPage"
        />
      </div>
    </div>
    <div class="add-wrapper">
      <add :is-show="addIsHide" :update-data="updateData" v-on:hide-box="onClickHide" />
    </div>
  </div>
</template>

<script>
import add from "./add";
import page from "../common/page";
import boxShade from "../common/boxShade";
const CODE_OK = 200;
const PAGE_SIZE = 5;

export default {
  name: "projectList",
  methods: {
    jump(route) {
      this.$router.push({ path: "/" + route });
    },
    //获取项目列表
    getProjectList(curr, pageSize) {
      this.$http
        .get(this.apiAddress + "/project/list", {
          params: {
            cp: curr,
            ps: pageSize,
            token: this.$store.state.userInfo.token
          }
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
      if (!confirm("确定删除？")) {
        return;
      }

      this.$http
        .post(
          this.apiAddress + "/project/del",
          {
            id: id,
            token: this.$store.state.userInfo.token
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
      this.$router.push("/detail/" + id + "/detailPage");
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
      hideShade: true,
      indesideRoute: []
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

.project-list {
  width: 100%;
  height: auto;
}

.project-list-btn {
  margin: 10px;
  text-align: left;
}

.project-list-btn button {
  border: 1px solid #e5e5e5;
  padding: 8px 20px;
  border-radius: 3px;
  background-color: #fff;
}

.project-list-content {
  border: 1px solid #e5e5e5;
  margin: 10px;
  min-height: 400px;
}

.project-list-content table,
tbody,
tr,
th,
td {
  border: 0;
  border-collapse: collapse;
  text-align: left;
}

.project-list-content table {
  background-color: #fff;
}

.project-list-content tr th {
  border-bottom: 1px solid #e5e5e5;
  text-align: left;
  padding: 15px 0;
}

.project-list-content tr td {
  padding: 15px 0;
}

.project-list-content tr:hover {
  background-color: #efefef;
}

.project-list-content tr th:first-child,
.project-list-content tr td:first-child {
  padding-left: 10px;
}

.project-list-content table {
  width: 100%;
  font-size: 14px;
}

.page-wrapper {
  margin: 50px 0;
}

.project-list-content button {
  padding: 4px 14px;
  margin-right: 2px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  border-radius: 3px;
  font-size: 12px;
}
</style>
