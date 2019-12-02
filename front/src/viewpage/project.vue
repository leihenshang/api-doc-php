<template>
  <div class="project">
    <div class="top">
      <topBar />
    </div>
    <div class="content">
      <div class="left">
        <leftMenu :menuList="indesideRoute" />
      </div>
      <div class="right">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import TopBar from "../components/common/topBar";
import LeftMenu from "../components/common/leftMenu";

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
    topBar: TopBar,
    leftMenu: LeftMenu
  }
};
</script>

<style scoped>
.project {
  width: 100%;
  height: 100%;
}
</style>
