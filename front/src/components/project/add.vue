<template>
  <div class="add">
    <h4>添加项目</h4>
    <ul>
      <li>
        <span>项目名称</span>
        <input type="text" />
      </li>
      <li>
        <span>版本号</span>
        <input type="text" />
      </li>
      <li>
        <span>项目类型</span>
        <select name="1" id="2">
          <option value="1">web</option>
          <option value="2">pc</option>
        </select>
      </li>
      <li>
        <span>项目描述</span>
        <textarea name="desc" cols="50" rows="10"></textarea>
      </li>
      <li>
        <button>确定</button>
        <button>取消</button>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "HelloWorld",
  props: {
    msg: String
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.add {
  width: 500px;
  height: 400px;
  position: absolute;
  background-color: #fff;
  top: 50%;
  left: 50%;
  border: 1px solid black;
  transform: translate(-50%, 50%);
}
</style>
