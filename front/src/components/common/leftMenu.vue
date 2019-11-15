<template>
  <div class="left-menu">
    <ul>
      <li @click="jump()" :class="{'current-click' : this.$route.path === '/' ? true : false }">
        <a href="javascript:void(0)">
          <span>▢</span>
          首页
        </a>
      </li>
      <li v-for="item in menuList" :key="item.id" @click="jump(item.route,item.child,$event)" >
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
  name: "left-menuMenu",
  props: {
    menuList: Array
  },
  computed: {},
  methods: {
    jump(uri, child) {

      // if(clild === this.$route.)

      if (uri) {
        if (child) {
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
    }
  },
  data: function() {
    return {
      menuListData:this.menuList
    };
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.left-menu {
  width: auto;
  height: 100%;
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

.left-menu li:hover {
  background-color: #e3f1e5;
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
  color: #fff!important;
}


</style>
