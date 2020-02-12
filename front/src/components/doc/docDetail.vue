<template>
    <div class="doc-wrapper">
        <div class="doc-detail" v-if="doc">
            <div class="title">
                <h3>{{doc.title}}</h3>
            </div>
            <div class="info">
                <span>作者:{{doc.nick_name}}</span>
                <span>{{doc.create_time}}</span>
                <span>阅读次数:{{doc.view_count}}</span>
                <span>点赞次数:{{doc.like_count}}</span>
            </div>
            <div class="doc-content">
                <mavon-editor v-model="doc.content" ref=md  :subfield = "false" :editable="false" :toolbarsFlag="false" :defaultOpen="'preview'" />
            </div>
        </div>
    </div>
</template>
<script>
    const CODE_OK = 200;

    export default {
        name: "docDetail",
        props: {
            docId: Number
        },
        data() {
            return {
                doc: Object
            };
        },
        methods: {
            getDocDetail() {
                this.$http
                    .get(this.apiAddress + "/doc/detail", {
                        params: {
                            id: this.docId
                            // token: this.$store.state.userInfo.token
                        }
                    })
                    .then(
                        res => {
                            let response = res.body;
                            if (response.code === CODE_OK) {
                                this.doc = response.data;
                            }
                        },
                        () => {
                            alert("获取数据失败");
                        }
                    );
            }
        },
        created() {
          this.getDocDetail();
        }
    };
</script>
<style scoped>
    .doc-detail {
        width: 75%;
        margin: 10px auto;
        background-color: #fff;
        height: 100%;
        box-shadow: 6px 6px 5px #888888;
        border: 1px solid rgb(202, 202, 202);
        min-height: 800px;
    }

    .doc-detail .title {
        margin: 20px 0;
        text-align: center;
    }

    .doc-detail .info span {
        margin-right: 10px;
        font-size: 12px;
        color: gray;
    }

    .doc-detail .info {
        padding-left: 20px;
    }

    .doc-content .v-note-wrapper {
      margin: 10px;
      height: 1000px;
    }

    .doc-detail .doc-content {
        margin: 20px 10px;
      box-sizing: border-box;
    }
</style>