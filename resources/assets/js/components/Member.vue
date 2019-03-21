<template>
    <div>

        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search">
                    <div class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <a onclick="$('#myModal').modal();" class="btn btn-primary pull-right">Create New Member</a>
            </div>
        </div>


        <table class="table table-striped" style="margin-top: 20px;">
            <thead>
            <tr>
                <th>Name</th>
                <th>Phone number</th>
                <th>Date of birth</th>
                <th>Position</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            <tr v-for="(item, index) in members">
                <td>{{ item.name }} </td>
                <td>{{ item.phone }} </td>
                <td>{{ item.birthday }} </td>
                <td>{{ item.position }} </td>
                <td>{{ item.gender }} </td>
                <td>
                    <button class="btn btn-info btn-sm">Edit</button>
                    <button class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>

            </tbody>
        </table>

        <div class="row pages" >
            <div class="input-group col-md-4 col-md-offset-4">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default pageInfo" disabled="disabled">Page {{current_page}} of {{total_page}}</button>
                    <button type="button" class="btn btn-default goPrevious"
                            :disabled="!isPrev || loading"
                            @click="prevPage()">&laquo; Previous</button>
                </div>
                <select v-model="current_page"
                        class="form-control" id="currentPage"
                        @change="updatePage">
                    <option v-for="n in total_page" :value="n">Page {{n}} </option>
                </select>
                <div class="input-group-btn">
                    <button type="button" class="btn btn-default goNext"
                            :disabled="!isNext || loading"
                            @click="nextPage()">Next &raquo;</button>
                </div>
            </div>
        </div>

        <form-member></form-member>

    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        mounted(){
            axios.get('/api/members')
                .then(resp => {
                    console.log("Member Component: Call back function after call AJAX get all members");
                    this.members = resp.data.data;
                    this.total_page = resp.data.data.last_page;
                })
                .catch(e => {
                })
        },
        data: function () {
            return {
                members: [],
                current_page: 1,
                total_page: 1,
                loading: false
            }
        },
        methods: {
            nextPage: function(){
                if(this.isNext){
                    this.loading = true;

                }
            },
            prevPage: function(){
                if(this.isPrev){
                    this.loading = true;

                }
            },
            updatePage: function (event) {
                let page = event.target.value
            }
        },
        computed:{
            isNext: function () {
                return this.current_page == this.total_page ? false : true;
            },
            isPrev: function () {
                return this.current_page == 1 ? false : true;
            }
        },
        components:{
        },
        watch:{
        }
    }
</script>

<style scoped>
    .pagination>li {
        cursor: pointer;
    }
    #currentPage{
        min-width: 100px;
    }
</style>