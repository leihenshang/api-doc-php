<template>
  <div class="project">
    <div class="content">
      <div class="right">
        <transition name="el-fade-in-linear" mode="out-in" appear>
          <router-view></router-view>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
const CODE_OK = 200;
const PAGE_SIZE = 5;

export default {
  name: "home",
  created() {},

  data() {


    return {
      projectList: {},
      pageSize: 5,
      currPage: 1,
      addIsHide: true,
      updateData: null,
      itemCount: 0,
      hideShade: true,
    };
  },
  methods: {
    jump(route) {
      this.$router.push({ path: "/" + route });
    },
    //点击隐藏
    onClickHide(val) {
      if (val === "flush") {
        this.currPage = 1;
        this.getProjectList(this.currPage, this.pageSize);
      }
      this.addIsHide = !this.addIsHide;
    },
    //删除项目
    del(id) {
      this.$http
        .post("/project/del", {
          id: id,
        })
        .then(
          (res) => {
            let response = res.data;
            if (response.code === CODE_OK) {
              this.$message.error("成功!" + response.msg);
              this.getProjectList(this.currPage, this.pageSize);
            } else {
              this.$message.error("失败!" + response.msg);
            }
          },
          (res) => {
            let response = res.data;
            this.$message.error("操作失败!" + response.msg);
          }
        );
    },
    update(item) {
      this.updateData = item;
      this.addIsHide = !this.addIsHide;
    },
    //跳页
    jumpPage(page) {
      this.currPage = page;
      this.hideShade = false;
      this.getProjectList(page, PAGE_SIZE);
    },
    detail(id) {
      this.$router.push("/detail/" + id);
    },
  },
  watch: {},
};
</script>

<style scoped>
.project {
  width: 100%;
  height: 100%;
}

.el-menu {
  height: 100%;
}
</style>
