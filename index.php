<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VueJS</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/vue.js"></script>
</head>
<body>
<div id="app">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="float-start"><strong>Users</strong></div>
                <div class="float-end">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add User</button></div>
            </div>
            <div class="card-body">
                <div class="alert alert-danger" role="alert" v-if="rp_error">
                    {{rp_error}}
                </div>
                <div class="alert alert-success" role="alert" v-if="rp_success">
                    {{rp_success}}
                </div>
                <table class="table table-bordered">
                  <thead>
                  <tr>
                      <th>id</th>
                      <th>Name</th>
                      <th>Phone</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                    <tr v-for="(user,i) in users">
                        <td>{{user.id}}</td>
                        <td>{{user.name}}</td>
                        <td>{{user.phone}}</td>
                        <td><button class="btn btn-primary"  data-bs-toggle="modal" @click="updateUser(user)" data-bs-target="#exampleModal2">Edit</button> <button class="btn btn-danger" @click="userDelete(user.id)">Delete</button></td>
                    </tr>
                </table>
            </div>
        </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <form>
                <div class="modal-body">

                        <label>Name</label>
                        <input type="text" class="form-control" v-model="form.name"> <br>
                        <label></label>Phone</label>
                        <input type="text" class="form-control" v-model="form.phone"> <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="addUser()" data-bs-dismiss="modal">Save</button>
                </div>
                    </form>
            </div>
        </div>
    </div>

<!-- Modal -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal2 title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                    <form>
                <div class="modal-body">

                        <label>Name</label>
                        <input type="text" class="form-control" v-model="updatedata.name"> <br>
                        <label></label>Phone</label>
                        <input type="text" class="form-control" v-model="updatedata.phone"> <br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"  data-bs-dismiss="modal" @click="updateStore()">Save</button>
                </div>
                    </form>
            </div>
        </div>
    </div>
    </div>
</div>
<script src="./js/bootstrap.min.js"></script>
<script src="./js/axios.js"></script>

<script>


    let app = new Vue({
        el : ('#app'),
       data : {
           // name : 'Shakil',
           users : [],
           form : {
               name: null,
               phone: null,
           },
           updatedata: {

           },
           rp_error: null,
           rp_success: null,
           empty_data: null,
           rp_msg: false,
       },
        methods : {
            getData(){
                axios({
                    url: 'http://localhost/CRUDS/api.php?action=read',
                    method: 'get',

                }).then(
                    function (response) {
                        if(response.data.error){
                            app.rp_error = response.data.msg;

                        }else {
                            app.users = response.data.users;
                        }
                        if (response.data.empty){
                            app.empty_data = response.data.empty_data;
                        }

                    });
            },
            addUser(){
                let ad = new FormData();
                ad.append('name', this.form.name);
                ad.append('number', this.form.phone);
                axios({
                    url: 'http://localhost/CRUDS/api.php?action=creat',
                    method: 'POST',
                    data : ad,
                }).then(
                    function (response){
                        if(response.data.error){
                            app.rp_error = response.data.msg;

                        }else {
                            app.rp_success = response.data.msg;

                            app.form.name = '';
                            app.form.phone = '';
                        }
                        app.getData();
                });
            },
            updateUser(myuser){

                this.updatedata = myuser;


            },
            updateStore(){
                let storedata = new FormData();
                storedata.append('id',this.updatedata.id);
                storedata.append('name',this.updatedata.name);
                storedata.append('number',this.updatedata.phone);
                axios({
                    url: 'http://localhost/CRUDS/api.php?action=update',
                    method: 'POST',
                    data: storedata,
                }).then(function (response) {
                    if(response.data.error){
                        app.rp_error = response.data.msg;

                    }else {
                        app.rp_success = response.data.msg;

                    }
                    app.getData();
                })
            },
            userDelete(id){
                let mdel = new FormData;
                mdel.append('id',id);
                axios({
                    url: 'http://localhost/CRUDS/api.php?action=delete',
                    method: 'POST',
                    data: mdel,
                }).then(function (response) {
                    if(response.data.error){
                        app.rp_error = response.data.msg;

                    }else {
                        app.rp_success = response.data.msg;

                    }
                    app.getData();
                })
            },
        },
        mounted: function (){
            this.getData();
        }
    })
</script>
</body>
</html>