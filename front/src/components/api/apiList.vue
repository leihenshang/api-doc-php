<template>
  <div class="api-list">
    <table v-show="!hideMe">
      <tr>
        <th>名称</th>
        <th>请求方法</th>
        <th>url</th>
        <th>协议</th>
        <th>语言</th>
        <th>创建时间</th>
        <th>操作</th>
      </tr>
      <tr v-for="item in apiList.resItem" :key="item.id">
        <td>
          <span class="span-dot"></span>
          {{item.api_name}}
        </td>
        <td>{{item.http_method_type}}</td>
        <td>{{item.url}}</td>
        <td>{{item.protocol_type}}</td>
        <td>{{item.develop_language}}</td>
        <td>{{item.create_time}}</td>
        <td class="api-list-btn">
          <button @click="jumpPage('edit',item.id)">编辑</button>
          <button @click="jumpPage('detail',item.id)">详情</button>
          <el-popconfirm
            title="确定要删除这个api?"
            placement="top"
            @onConfirm="delApi(item.id)"
            width="200"
          >
            <el-button slot="reference">删除</el-button>
          </el-popconfirm>
        </td>
      </tr>
    </table>
    <div class="container" v-show="hideMe">
      <div class="container-detail" v-if="currContainer == 'detail'">
        <apiDetail
          :apiId="apiId"
          v-on:childHideMe="childHideMe()"
          v-on:updateApi="currContainer = 'edit'"
        />
      </div>
      <div class="container-edit" v-if="currContainer == 'edit'">
        <apiEdit
          :apiId="apiId"
          v-on:childHideMe="childHideMe()"
          v-on:saveUpdate="currContainer = 'detail'"
        />
      </div>
    </div>
  </div>
</template>

<script>
import apiDetail from "./apiDetail";
import apiEdit from "./apiEdit";

const CODE_OK = 200;

export default {
  name: "apiList",
  props: {
    apiList: Object
  },
  created() {},
  data() {
    return {
      apiId: 0,
      hideMe: false,
      currContainer: "",
      del: 0
    };
  },
  methods: {
    delApi(id) {
      this.$http
        .post(
          this.apiAddress + "/api/del",
          {
            id: id,
            token: this.$store.state.userInfo.token
          },
          { emulateJSON: true }
        )
        .then(
          response => {
            response = response.body;
            if (response.code === CODE_OK) {
              this.$message.success("成功~");
              this.$emit("api-delete");
            } else {
              this.$message.error("失败:" + response.msg);
            }
          },
          () => {
            this.$message.error("失败~");
          }
        );
    },
    jumpPage(name, id) {
      this.apiId = parseInt(id);
      this.hideMe = true;
      this.currContainer = name;
    },
    childHideMe() {
      this.hideMe = false;
    }
  },
  computed: {
    getapiId() {
      return this.$route.params.apiId;
    }
  },
  components: {
    apiDetail,
    apiEdit
  }
};
</script>

<style scoped>
.api-list {
  background-color: #fff;
  height: auto;
}

.api-list td,
.api-list th {
  padding: 8px 8px;
  font-size: 12px;
  font-weight: 700;
  color: #666;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.api-list tr:hover {
  background-color: #e3f1e5;
}

.api-list th {
  font-size: 14px;
  font-weight: 700;
  text-align: left;
}

.api-list table {
  border-collapse: collapse;
  width: 100%;
}

.api-list table button {
  height: 28px;
  padding: 0 10px;
  margin-right: 2px;
  background-color: #fff;
  border: 1px solid #e5e5e5;
  border-radius: 3px;
  font-size: 12px;
}

.span-dot {
  width: 10px;
  height: 10px;
  display: inline-block;
  border-radius: 10px;
  background-color: #4caf50;
  margin-right: 5px;
}
</style>
