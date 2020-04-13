<template>
  <div class="info">
    <ul>
      <li>
        <span class="span-label">分组:</span>
        <el-select v-model="content.groupId" size="small" placeholder="请选择">
          <el-option v-for="item in groupList" :key="item.id" :label="item.title" :value="item.id"></el-option>
        </el-select>
      </li>
      <li>
        <span class="span-label">标题:</span>
        <el-input v-model="content.title" size="small" placeholder="请输入标题" style="width:90%"></el-input>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    groupList: [Array, Object],
    doc: Object
  },
  data() {
    return {
      content: {
        groupId: "",
        title: ""
      }
    };
  },
  created() {},
  watch: {
    content: {
      handler: function(val) {
        this.$emit("update-info", val);
      },
      deep: true
    },
    doc: function(val) {
      this.content.groupId =  val.group_id;
      this.content.title = val.title;
    }
  }
};
</script>
<style>
.info ul li {
  padding: 5px 0;
  list-style: none;
}

.info li .span-label {
  display: inline-block;
  min-width: 50px;
  text-align: right;
  padding-right: 20px;
  font-size: 12px;
  font-weight: 600;
}
</style>