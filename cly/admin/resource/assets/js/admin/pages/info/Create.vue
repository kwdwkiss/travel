<template>
    <div class="card">
        <h5 class="card-header">创建</h5>
        <div class="card-body">
            <form class="form-horizontal">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">类型</label>
                    <div class="col-md-7">
                        <select class="form-control" v-model.number="form.type">
                            <option :value="item.id" v-for="item in taxonomy.info_type">{{item.label}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">名称</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" placeholder="请输入名称"
                               v-model="form.name">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">地址</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" placeholder="请输入地址"
                               v-model="form.address">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">电话</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" placeholder="请输入电话"
                               v-model="form.phone">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">备注</label>
                    <div class="col-md-7">
                            <textarea class="form-control" placeholder="请输入备注" rows="10"
                                      v-model="form.remark"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7 offset-md-3">
                        <button type="button" class="btn btn-primary" @click="doSubmit">提交</button>
                        <button type="button" class="btn btn-dark" @click="doReturn">返回</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "create",
        data: function () {
            return {
                apiCreate: api.adminInfoCreate,
                routeIndex: 'infoIndex',
                form: {},
            }
        },
        computed: {
            taxonomy: function () {
                return this.$store.state.taxonomy;
            }
        },
        created: function () {
            this.form.type = 1;
        },
        methods: {
            doReturn: function () {
                this.$router.push({name: this.routeIndex});
            },
            doSubmit: function () {
                let self = this;
                axios.post(self.apiCreate, self.form).then(function () {
                    self.$message.success('成功');
                    self.doReturn();
                });
            },
        }
    }
</script>

<style scoped>

</style>