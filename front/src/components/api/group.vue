<!--
 * @Description: In User Settings Edit
 * @Author: your name
 * @Date: 2019-10-10 18:12:37
 * @LastEditTime: 2019-10-10 18:12:37
 * @LastEditors: your name
 -->
<template>
  <div class="group">
 我是分组组件
 <div class="box" >

   <ul v-if="groupList">
     <li v-for="item in groupList" :key="item.id" ><a href="javascript:void();">{{item.title}}</a> <button>删除</button> </li>
   </ul>

 </div>
  </div>
</template>

<script>
// const CODE_OK = 200;
export default {
  name: "group",
  props: {
    id: String,
    groupList:Array
  },
  created() {},
  data() {
    return {};
  },
  methods: {}
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
