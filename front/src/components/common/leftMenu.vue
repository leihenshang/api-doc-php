<template>
  <div class="left-menu">
    <ul>
      <li @click="jump()" :class="{'current-click' : this.$route.path === '/' ? true : false }">
        <a href="javascript:void(0)">
          <span>◀</span>
          首页-全部项目
        </a>
      </li>
      <li
        v-for="(item,index) in menuListDataComputed"
        :key="item.id"
        @click="jump(item.route,item.child,index)"
        :class="{'is-click' : item.isClick}"
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
    jump(uri, child, index) {
      if (uri) {
        if (child) {
          if (this.menuListData[index].isClick === true) {
            return;
          }

          this.$router.push(
            "/" + uri + "/" + this.$route.params.id + "/" + child
          );
        } else {
          this.$router.push("/" + uri + "/" + this.$route.params.id);
        }
      } else {
        if (this.$route.path !== "/") {
          this.$router.push("/");
        }
        return;
      }

      for (const key in this.menuListData) {
        this.menuListData[key].isClick = false;
      }
      this.menuListData[index].isClick = true;
    },
    change() {
      for (const key in this.menuListData) {
        if (this.$route.name === this.menuListData[key].child) {
          this.menuListData[key].isClick = true;
        }
      }
    }
  },
  data: function() {
    return {
      menuListData: this.menuList
    };
  },
  created: function() {
    this.change();
  },
  computed: {
    menuListDataComputed: function() {
      if (this.menuListData) {
        let tmpData = [];

        for (const key in this.menuListData) {
          if (
            this.$store.state.userInfo.type !== 2 &&
            this.menuListData[key].child === "user"
          ) {
            continue;
          }

          tmpData.push(this.menuListData[key]);
        }
        return tmpData;
      } else {
        return [];
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.left-menu {
  width: auto;
  height: 100%;
  border-right: 1px solid #e5e5e5;
}

.left-menu li {
  padding: 15px 0;
  text-align: left;
}

/* .left-menu li:first-child {
  background-color: #e3f1e5;
}

.left-menu li:first-child a {
  color: #4caf50;
} */

.left-menu ul li:first-child {
  background-color: #5ace5e;
}

.left-menu ul li:first-child a {
  color: #fff;
  font-weight: 700;
}

.left-menu li:hover {
  background-color: #3baf88c4;
}

.is-click {
  background-color: rgba(0, 0, 0, 0.479);
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
