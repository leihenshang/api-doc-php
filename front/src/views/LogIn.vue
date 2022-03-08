<template>
  <div class="log-in-wrap">
    <div class="img">
      <img src="../assets/images/logIn.png" alt="">
    </div>
    <div class="log-in">
      <h3>my-note</h3>
      <n-form :model="userInfo" ref="formRef" label-placement="left" class="long-in-form" size="large">
        <n-form-item path="username" :rule="getRules('用户名')">
          <n-input v-model:value="userInfo.username" placeholder="用户名" />
        </n-form-item>
        <n-form-item path="password" :rule="getRules('密码')">
          <n-input v-model:value="userInfo.password" type="password" placeholder="密码" />
        </n-form-item>
        <n-form-item class="buttons-wrapper">
          <div class="buttons">
            <n-button attr-type="button" @click="longIn">登录</n-button>
            <n-button attr-type="button" @click="longIn">注册</n-button>
          </div>
        </n-form-item>
      </n-form>
    </div>
  </div>
</template>

<script lang="ts">
import { ref, reactive } from 'vue';
import { useRouter } from 'vue-router';

export default {
  name: 'LogIn',
  setup() {
    const userInfo = ref({
      username: '',
      password: ''
    });
    const formRef = ref(null)
    const router = useRouter()
    const longIn = (e: { preventDefault: () => void; }) => {
      e.preventDefault()
      formRef.value.validate((errors) => {
        console.log(errors);
        if (!errors) {
          router.push({ name: 'HomePage' })
        }
      })
    }
    const getRules = (name: string) => {
      return { required: true, trigger: ['blur', 'input'], message: '请输入' + name }
    }
    return { userInfo, longIn, formRef, getRules };
  }
};
</script>

<style scoped lang='scss'>
.log-in-wrap {
  display: flex;
  width: 100%;
  height: 100%;
  > .img{
    display: flex;
    align-items: center;
    justify-content: center;
    width: 70%;
  }

  > .log-in {
    width: 30%;
    background: #ececec;
    display: flex;
    align-items: center;
    flex-direction: column;
    justify-content: center;

    > h3 {
      font-size: 24px;
      text-align: center;
    }

    > .long-in-form {
      margin-top: 16px;
      > ::v-deep(.n-form-item) {
        .n-form-item-blank {
          .buttons{
            width: 100%;
            display: flex;
            justify-content: space-between;
            button {
              width: 150px;
              background-color: #21a497;
              color: #ffffff;
              .n-button__border {
                border: none;
              }
              &:first-child {
                margin-right: 8px;
              }
            }
          }
        }

        .n-input {
          width: 320px;
          .n-input__border {
            border: 1px solid #b8bcbf;
          }
        }
      }
    }
  }
}
</style>