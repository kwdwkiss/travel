<template>
    <div>
        <el-row>
            <el-select v-model="search.type" placeholder="请选择类型">
                <el-option v-for="item in taxonomy.info_type"
                           :key="item.id"
                           :label="item.label"
                           :value="item.id">
                </el-option>
            </el-select>
            <el-input v-model="search.name" placeholder="名称" style="width: 150px"></el-input>
            <el-button type="primary" @click="doSearch">搜索</el-button>
            <el-button type="warning" @click="reset">重置</el-button>
            <el-button type="success" @click="doCreate">创建</el-button>

            <el-pagination layout="prev, pager, next"
                           :total="dataList.meta.total"
                           :page-size="dataList.meta.per_page"
                           @current-change="paginate"></el-pagination>
        </el-row>

        <el-row>
            <el-table :data="dataList.data" stripe>
                <el-table-column prop="id" label="ID" min-width="100"></el-table-column>
                <el-table-column prop="name" label="名称" min-width="120"></el-table-column>
                <el-table-column prop="created_at" label="创建时间" min-width="180"></el-table-column>
                <el-table-column label="操作" min-width="200">
                    <template slot-scope="scope">
                        <el-button type="warning" @click="doUpdate(scope.row)">修改</el-button>
                        <el-button type="danger" @click="doDelete(scope.row)">删除</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-row>
    </div>
</template>

<script>
    export default {
        name: "index",
        data: function () {
            return {
                apiList: api.adminInfoIndex,
                apiUpdate: api.adminInfoUpdate,
                apiDelete: api.adminInfoDelete,
                routeCreate: 'infoCreate',
                routeUpdate: 'infoUpdate',
                dataList: {meta: {}},
                search: {},
            }
        },
        computed: {
            taxonomy: function () {
                return this.$store.state.taxonomy;
            }
        },
        created: function () {
            this.search = this.$route.query;
            this.doSearch();
        },
        watch: {
            '$route'(to, from) {
                this.search = this.$route.query;
                this.doSearch();
            }
        },
        methods: {
            doSearch: function () {
                this.search.page = null;
                this.loadData();
            },
            reset: function () {
                this.search = {};
                this.loadData();
            },
            paginate: function (page) {
                this.search.page = page;
                this.loadData();
            },
            loadData: function () {
                let self = this;
                axios.get(self.apiList, {params: self.search}).then(function (res) {
                    self.dataList = res.data;
                });
            },
            doCreate: function () {
                this.$router.push({name: this.routeCreate});
            },
            doUpdate: function (row) {
                this.$router.push({name: this.routeUpdate, params: {id: row.id}});
            },
            doDelete: function (row) {
                let self = this;
                self.$confirm('此操作将永久删除数据, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    type: 'warning'
                }).then(() => {
                    axios.post(self.apiDelete, {id: row.id}).then(function () {
                        self.$message.success('删除成功');
                        self.loadData();
                    });
                }).catch(() => {});
            },
            //self methods
        }
    }
</script>

<style scoped>
</style>