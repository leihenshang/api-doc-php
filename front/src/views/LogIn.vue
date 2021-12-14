<template>
  <div class="log-in-wrap">
    <div class="log-in">
      <h3>用户登录</h3>
      <n-form :model="userInfo" ref="formRef" label-placement="left" class="long-in-form">
        <n-form-item path="username" :rule="getRules('用户名')">
          <n-input v-model:value="userInfo.username" placeholder="用户名" />
        </n-form-item>
        <n-form-item path="password" :rule="getRules('密码')">
          <n-input v-model:value="userInfo.password" type="password" placeholder="密码"/>
        </n-form-item>
        <n-form-item>
          <n-button attr-type="button" @click="longIn">登录</n-button>
        </n-form-item>
      </n-form>
    </div>
  </div>
</template>

<script lang="ts">
import {ref, reactive} from 'vue';
import {useRouter} from 'vue-router';

export default {
  name: 'LogIn',
  setup() {
    const userInfo = ref({
      username: '',
      password: ''
    });
    const formRef = ref(null)
    const router = useRouter()
    const longIn = (e)=>{
      e.preventDefault()
      formRef.value.validate((errors) => {
        if (!errors) {
          router.push({name:'HomePage'})
        }
      })
    }
    const getRules = (name)=>{
      return {required: true, trigger: ['blur', 'input'], message: '请输入' + name}
    }
    return {userInfo,longIn,formRef,getRules};
  }
};
</script>

<style scoped lang='scss'>
.log-in-wrap {
  position: relative;
  width: 100%;
  height: 100%;

  > .log-in {
    width: 472px;
    height: 337px;
    border: 1px solid rgba(0, 0, 0, 0.4);
    border-radius: 30px;
    position: absolute;
    top: 20%;
    left: 50%;
    transform: translateX(-50%);
    box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
    display: flex;
    align-items: center;
    flex-direction: column;

    > h3 {
      font-size: 20px;
      text-align: center;
      margin-top: 26px;
    }

    > .long-in-form {
      margin-top: 38px;
      //width: 312px;

      > .n-form-item::v-deep {

        .n-form-item-blank {
          > .n-button{
            width: 100%;
            border-radius: 16px;
            background-color: #21a497;
            color: #ffffff;
            .n-button__border{border: none}
          }
        }

        .n-input {
          width: 300px;
          border-radius: 16px;
          .n-input__border{
            border: 1px solid #b8bcbf;
          }
        }
      }
    }
  }


}
</style>