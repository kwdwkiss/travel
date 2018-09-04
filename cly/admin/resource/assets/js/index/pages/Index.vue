<template>
    <div>
        <div class="card">
            <h5 class="card-header">资料查询</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 my-2">
                        <select class="form-control" v-model.number="form.type">
                            <option :value="item.id" v-for="item in taxonomy.info_type">{{item.label}}</option>
                        </select>
                    </div>
                    <div class="col-md-5 my-2">
                        <input class="form-control" type="text" placeholder="请输入查询内容的名称" v-model="form.name">
                    </div>
                    <div class="col-md-2 my-2">
                        <button class="btn btn-primary" style="width: 100%" @click="doSearch">查询</button>
                    </div>
                    <div class="col-md-2 my-2">
                        <button class="btn btn-success" style="width: 100%" @click="typeIn">录入</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <h5 class="card-header">查询结果</h5>
            <div class="card-body border-bottom" v-for="item in dataList.data">
                <div>名称：{{item.name}}</div>
                <div>类型：{{item.type_label}}</div>
                <div>电话：{{item.phone}}</div>
                <div>地址：{{item.address}}</div>
                <div><pre style="font-size: 100%">{{item.remark}}</pre></div>
            </div>
        </div>
        <div class="modal detail-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">资料详情</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">类型</label>
                                <div class="col-md-7">
                                    <label class="col-form-label">{{item.type_label}}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">名称</label>
                                <div class="col-md-7">
                                    <label class="col-form-label">{{item.name}}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">地址</label>
                                <div class="col-md-7">
                                    <label class="col-form-label">{{item.address}}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">内容</label>
                                <div class="col-md-7">
                                    <label class="col-form-label">{{item.content}}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">备注</label>
                                <div class="col-md-7">
                                    <label class="col-form-label">{{item.remark}}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label text-md-right">更新时间</label>
                                <div class="col-md-7">
                                    <label class="col-form-label">{{item.created_at}}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-7 offset-md-3">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index",
        data: function () {
            return {
                form: {},
                dataList: {
                    meta: {}
                },
                item: {}
            }
        },
        created: function () {
            this.form.type = 1;
        },
        computed: {
            user: function () {
                return this.$store.state.user;
            },
            taxonomy: function () {
                return this.$store.state.taxonomy;
            },
        },
        methods: {
            doSearch: function () {
                let self = this;
                self.typeInDisplay = false;
                axios.get(api.indexInfoSearch, {params: this.form}).then(function (res) {
                    self.dataList = res.data;
                })
            },
            doDetail: function (item) {
                this.item = item;
                $('.detail-modal').modal('show');
            },
            typeIn: function () {
                if (!this.user) {
                    this.$message.error('请登录后再录入资料');
                    return;
                }
                this.$router.push({name: 'infoTypeIn'});
            }
        }
    }
</script>

<style scoped>
</style>