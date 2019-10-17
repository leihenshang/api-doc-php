<template>
  <div class="page">
    <ul>
      <li>
        <span v-if="current == 1">首页</span>
        <a href="javascript:void(0)" @click="jump(1)" v-else>首页</a>
      </li>
      <li>
        <span v-if="current == 1">上页</span>
        <a href="javascript:void(0)" @click="jump(current -1)" v-else>上页</a>
      </li>
      <li v-for="(item,index) in pageCount " :key="item.id">
        <span v-if="(index+1) == current">{{index + 1 }}</span>
        <a href="javascript:void(0)" @click="jump(index+1)" v-else>{{index + 1 }}</a>
      </li>
      <li>
        <span v-if="current == pageCount">下页</span>
        <a href="javascript:void(0)"  @click="jump(current+1)" v-else>下页</a>
      </li>
      <li>
        <span v-if="current == pageCount">尾页</span>
        <a href="javascript:void(0)" @click="jump(pageCount)" v-else>尾页</a>
      </li>
      <li>
        <span>{{ pageCount }}/{{current}}</span>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "page",
  props: {
    itemCount: Number,
    curr: Number,
    pageSize: Number
  },
  computed: {
    pageCount: function() {
      return Math.ceil(this.itemCount / this.pageSize);
    }
  },
  methods:{
      jump(page){
          this.current = page;
          this.$emit('jump-page',page);
      }
  },
  data:function(){
     return { current:this.curr};
  },
  watch:{
    curr:function(val){
      this.current = val;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.page ul {
  overflow: hidden;
  display: flex;
  flex-flow: row;
  justify-content: center;
}
.page ul li {
  border: 1px solid black;
  width: 40px;
  height: 35px;
  margin-left: 5px;
  font-size: 15px;
  font-weight: bold;
  line-height: 35px;
  text-align: center;
}

.page ul li a {
  display: block;
  height: 100%;
  color: white;
  background-color: gray;
}

.page ul li span {
  height: 100%;
  display: block;
}
</style>
