<template>
    <div class="doc-create">
        <div class="doc-wrapper">
            <div class="title">
                <span>标题:</span>
                <input type="text" name id v-model="title"/>
            </div>
            <div class="info">
                <span>分组:</span>
                <select name id v-model="groupId" v-bind:disabled="groupList.length < 1">
                    <option value disabled selected>-选择分组-</option>
                    <option :value="group.id" v-for="group in groupList" :key="group.id">{{group.title}}</option>
                </select>
            </div>

            <div class="description">
                <span>描述:</span>
                <input type="text" name id v-model="description" style="width:700px;"/>
            </div>

            <div class="doc-content">
                <span>内容:</span>
                <mavon-editor v-model="content"/>
            </div>
            <div class="btn">
                <button @click="createDoc()">提交</button>
            </div>
        </div>
    </div>
</template>
<script>
    const CODE_OK = 200;

    export default {
        name: "docCreate",
        data() {
            return {
                title: "",
                content: "",
                description: "",
                groupId: null,
                groupList: [],
                isCreate: true
            };
        },
        methods: {
            //获取分组列表
            getGroup(pageSize = 10, curr = 1, projectId) {
                this.$http
                    .get(this.apiAddress + "/group/list", {
                        params: {
                            cp: curr,
                            type: 3,
                            ps: pageSize,
                            projectId: projectId ? projectId : 0
                        }
                    })
                    .then(
                        response => {
                            response = response.body;
                            if (response.code === CODE_OK) {
                                if (response.data) {
                                    this.groupList = response.data;
                                }
                            } else {
                                this.$message.error("获取数据-操作失败!" + !response.msg ? response.msg : "");
                            }
                        },
                        () => {
                            this.$message.error("获取数据-操作失败!");
                        }
                    );
            },
            //创建文档
            createDoc() {
                if (!this.groupId) {
                    this.$message.error("请选择分组");
                    return;
                }

                if (!confirm("确认?")) {
                    return;
                }

                this.$http
                    .post(this.apiAddress + "/doc/create", {
                        title: this.title,
                        content: this.content,
                        group_id: this.groupId
                    })
                    .then(
                        res => {
                            res = res.body;
                            if (res.code === CODE_OK) {
                                if (res.data) {
                                    this.$message.error("创建成功！");
                                    this.$router.go(-1);
                                } else {
                                    this.$message.error("创建文档失败:" + res.msg);
                                }
                            }
                        },
                        () => {
                            this.$message.error("创建文档失败");
                        }
                    );
            }
        },
        created() {
            this.getGroup();
        }
    };
</script>
<style scoped>
    .doc-wrapper {
        width: 75%;
        margin: 20px auto;
        border: 1px solid gray;
        min-height: 1200px;
    }

    .doc-wrapper span {
        display: inline-block;
        width: 100px;
        text-align: right;
        padding-right: 20px;
    }

    .doc-wrapper input,
    .doc-wrapper select {
        height: 25px;
        width: 200px;
    }

    .doc-content .v-note-wrapper {
        margin: 10px;
        height: 1000px;
    }

    .doc-wrapper input,
    .doc-wrapper textarea {
        width: 300px;
    }

    .doc-wrapper textarea {
        width: 1200px;
        min-height: 600px;
    }

    .doc-wrapper div {
        margin: 20px 0;
    }

    .btn {
        width: 100%;
        text-align: center;
    }

    .doc-wrapper button {
        width: 80px;
        height: 30px;
    }
</style>