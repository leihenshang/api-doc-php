<template>
  <div class="message">
    <ul>
      <li>
        <p>项目动态</p>
        <p></p>
      </li>
      <li v-for="item in operationLog" :key="item.id">
        <p>{{item.create_time}}</p>
        <p> 用户:{{item.nick_name}}, {{item.content}}</p>
      </li>
    </ul>
  </div>
</template>

<script>
const CODE_OK = 200;

export default {
  name: "message",
  created() {
    this.getOperationLog();
  },
  props: {},
  data() {
    return {
      operationLog: [],
      ps: 18,
      cp: 1
    };
  },
  methods: {
    //获取操作日志
    getOperationLog() {
      this.$http
        .get(this.apiAddress + "/operation-log/list", {
          params: {
            object_id: this.$route.params.id,
            token: this.$store.state.userInfo.token,
            type: '1,2,3,4',
            ps: this.ps,
            cp: this.cp
          }
        })
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.operationLog = response.data;
            } else {
              this.$message.error("获取数据失败");
            }
          },
         res =>  {
            let response = res.body;
            this.$message.error("获取数据-操作失败!" + !response.msg ? response.msg : "");
          }
        );
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.message ul {
  margin: 15px;
}

.message li {
  margin: 5px 0;
  text-align: left;
  list-style: none;
}

.message li p {
  padding-left: 10px;
}

.message li p:last-child {
  border-left: 1px solid #b6b6b6;
  margin-left: 5px;
  font-size: 14px;
  height: 30px;
  line-height: 30px;
}

.message li p:first-child {
  font-size: 12px;
  color: #b6b6b6;
  padding: 0;
}

.message li p:first-child::before {
  content: "●";
  color: #b6b6b6;
  margin-left: 1px;
  margin-right: 5px;
}
.message ul li:first-child p:first-child::before {
  content: "📅";
}

.message ul li:first-child p {
  border: none;
  font-size: 14px;
  color: black;
}

.message ul li:first-child p:last-child {
  height: 10px;
}
</style>
