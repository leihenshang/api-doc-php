<template>
  <div class="project">
    <div class="top">
      <topBar />
    </div>
    <div class="content">
      <div class="left">
        <el-menu :default-active="$route.path" :router="true" ref="menu" class="el-menu">
          <el-menu-item :index="item.route" v-for="item in insideRoute" :key="item.id">
            <i :class="item.icon ? item.icon :'el-icon-setting'"></i>
            <span slot="title">{{item.title}}</span>
          </el-menu-item>
        </el-menu>
      </div>
      <div class="right">
        <transition name="el-fade-in-linear" mode="out-in" appear>
          <router-view></router-view>
        </transition>
      </div>
    </div>
  </div>
</template>

<script>
import TopBar from "../components/common/topBar";

const CODE_OK = 200;
const PAGE_SIZE = 5;

export default {
  name: "home",
  created() {},

  data() {
    let route = [
      {
        title: "项目列表",
        route: "/projectList",
        icon: "el-icon-s-fold"
      },
      {
        title: "个人中心",
        route: "/myCenter",
        icon: "el-icon-s-operation"
      }
    ];

    if (this.$store.state.userInfo.type == 2) {
      route.push({
        title: "用户管理",
        route: "/userManager",
        icon: "el-icon-user"
      });
    }

    return {
      projectList: {},
      pageSize: 5,
      currPage: 1,
      addIsHide: true,
      updateData: null,
      itemCount: 0,
      hideShade: true,
      insideRoute: route
    };
  },
  components: {
    topBar: TopBar
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
        .post(
          this.apiAddress + "/project/del",
          {
            id: id
          },
         
        )
        .then(
          res => {
            let response = res.data;
            if (response.code === CODE_OK) {
              this.$message.error("成功!" + response.msg);
              this.getProjectList(this.currPage, this.pageSize);
            } else {
              this.$message.error("失败!" + response.msg);
            }
          },
          res => {
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
    }
  },
  watch: {}
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
