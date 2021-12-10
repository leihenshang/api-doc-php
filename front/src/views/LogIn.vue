<template>
  <div class="log-in-wrap">
    <lay-form @submit="submit" :model="model">
      <lay-form-item label="账户">
        <lay-input v-model="model.username"></lay-input>
      </lay-form-item>
      <lay-form-item label="密码">
        <lay-input v-model="model.password"></lay-input>
      </lay-form-item>
      <lay-form-item>
        <lay-button naive-type="submit">提交</lay-button>
      </lay-form-item>
    </lay-form>
  </div>
</template>

<script lang="ts">
import { ref, reactive } from 'vue'

export default {
  name: 'LogIn',
  setup() {
    const model = reactive({
      username: "admin",
      password: "admin"
    })

    const submit = function(val) {
      alert(JSON.stringify(val))
    }

    return {model, submit}
  }
};
</script>

<style scoped lang='scss'>

</style>