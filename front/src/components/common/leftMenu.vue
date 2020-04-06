<template>
  <div class="left-menu">
    <ul>
      <li @click="jump()">
        <a href="javascript:void(0)">
          <span>▢</span>
          首页-全部项目
        </a>
      </li>
      <li
        v-for="(item,index) in menuListData"
        :key="item.id"
        @click="jump(item.route,item.child,index)"
        :class="{'is-click' : item.isClick }"
      >
        <a href="javascript:void(0)">
          <span>▢</span>
          {{item.title}}
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "left-menu",
  props: {
    menuList: Array
  },
  methods: {
    //跳转
    jump(uri, child, index) {
      //跳转到首页开始页
      if (!uri) {
        if (this.$route.path !== "/") {
          for (const key in this.menuListData) {
            if (key == index) {
              this.menuListData[key].isClick = true;
            } else {
              this.menuListData[key].isClick = false;
            }
          }

          this.$router.push({ path: "/" });
        }
        return;
      }

      //已跳转过禁止跳转
      if (this.menuListData[index].isClick === true) {
        return;
      }

      //跳转到其他页面
      if (uri) {
        if (child) {
          if (this.menuListData[index].isClick === true) {
            return;
          }

          this.$router.push({
            path: "/" + uri + "/" + this.$route.params.id + "/" + child
          });
        } else {
          if (this.$route.params.id) {
            this.$router.push({
              path: "/" + uri + "/" + this.$route.params.id
            });
          } else {
            this.$router.push({ path: "/" + uri });
          }
        }
      }

      this.resetClick(index);
    },
    //重置点击值
    resetClick(index) {
      if (index !== null) {
        for (const key in this.menuListData) {
          if (key == index) {
            this.menuListData[key].isClick = true;
          } else {
            this.menuListData[key].isClick = false;
          }
        }
      }
    }
  },
  data: function() {
    return {
      menuListData: this.menuList
    };
  },
  created: function() {},
  computed: {
    //计算属性，用户权限过滤菜单显示
    // menuListDataComputed: function() {
    //   let tmpData = [];
    //   if (!this.menuListData) {
    //     return tmpData;
    //   }
    //   for (const key in this.menuListData) {
    //     this.menuListData[key].isClick = false;
    //     if (
    //       this.$store.state.userInfo.type !== 2 &&
    //       this.menuListData[key].child === "user"
    //     ) {
    //       continue;
    //     }
    //     tmpData.push(this.menuListData[key]);
    //   }
    //   return tmpData;
    // }
  },
  watch: {
    $route: function(val) {
      this.$nextTick(() => {
        if (
          /^\/detail\/((?:[^\/]+?))\/apiPage(?:\/(?=$))?$/i.test(val.fullPath)
        ) {
          for (let key in this.menuListData) {
            if (this.menuListData[key].child == "apiPage") {
              this.menuListData[key].isClick = true;
            } else {
              this.menuListData[key].isClick = false;
            }
          }
        }
      });
    }
  }
};
</script>

<style scoped>
.left-menu {
  width: auto;
  height: 100%;
  border-right: 1px solid #e5e5e5;
}

.left-menu li {
  padding: 15px 0;
  text-align: left;
  border-top: 1px dashed black;
}

.left-menu li:last-child {
  border-bottom: 1px dashed black;
}

.left-menu li:first-child {
  margin-bottom: 10px;
  border: none;
}

.left-menu ul li:first-child {
  background-color: #9dde94;
}

.left-menu ul li:first-child a {
  color: #fff;
  font-weight: 700;
}

.left-menu li:hover {
  background-color: #3baf88c4;
}

.is-click {
  background-color: rgb(108, 202, 123);
}

.is-click a {
  color: #fff !important;
}

.left-menu li:hover a {
  color: #fff;
}

.left-menu li span {
  display: inline-block;
  padding: 0 32px;
}

.left-menu li a {
  width: 100%;
  display: block;
  font-size: 14px;
  color: black;
}

.message {
  border-bottom: 1px solid #e5e5e5;
}

.current-click {
  background-color: #9bcf9d;
}

.current-click a {
  color: #fff !important;
}
</style>
