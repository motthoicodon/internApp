<template>

    <div>
    <a class="btn btn-primary pull-right">Create New Member</a>

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
                })
                .catch(e => {

                })
        },
        data: function () {
            return {
                members: []
            }
        },

    }
</script>

<style scoped>

</style>