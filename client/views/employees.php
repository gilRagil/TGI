<?php 
    include "header.php";
    include "leftmenu.php";
?>
            <div class="content-inner" id="app">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">Master Employees</h2>
                    </div>
                </header>
                <!-- Dashboard Cards Section -->
                <section class="dashboard-counts no-padding-bottom">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <div class="col-lg-9">
                                    <form class="form-inline">
                                        <div class="form-group">
                                            <input id="paramsSearch" type="text" placeholder="Search" class="mr-3 form-control">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" v-on:click="search">
                                                <i class="icon-search"></i>
                                            </button>
                                        </div>&nbsp;
                                        <div class="form-group">
                                            <button type="button" @click="act = 'add'" class="btn btn-info" data-toggle="modal" data-target="#myMaster">
                                                <i title="Add Product" class="icon-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div id="myMaster" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" class="modal fade text-left" style="display: none;"
                                aria-hidden="true">
                                <div role="document" class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 id="exampleModalLabel" class="modal-title">Input Data</h4>
                                            <button type="button" data-dismiss="modal" aria-label="Close" class="close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <small class="help-block-none" style="color:red" v-for="error in errors">{{ error }}</small>
                                        <div class="modal-body">
                                            <form name="frm-trans" name="frm-trans">
                                                                                     
                                                <div class="form-group">
                                                    <label>Nama Lengkap</label>
                                                    <input type="text" v-model="full_name" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" v-model="username" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Password</label>
                                                    <input type="password" v-model="password" class="form-control">
                                                </div>
                                                <div class="form-group" v-if="!image">
                                                    <label>Photo</label>
                                                    <input type="file" @change="onFileChange" id="photo" class="form-control-file">
                                                </div>
                                                <div class="form-group" v-else>
                                                    <label>Photo</label>
                                                    <img :src="image" alt="..." class="img-fluid rounded-circle" style="width:150px;height:150px;border:3px solid #28a745">
                                                </div>
                                                <div class="form-group">
                                                    <label>Gender</label>
                                                    <div class="col-sm-9">
                                                        <div>
                                                            <input id="optionsRadios1" type="radio" checked="" value="L" v-model="gender">
                                                            <label for="optionsRadios1">Laki Laki</label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input id="optionsRadios2" type="radio" value="P" v-model="gender">
                                                            <label for="optionsRadios2">Perempuan</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Agama</label>
                                                    <select v-model="religion" class="form-control">
                                                        <option value="1">ISLAM</option>
                                                        <option value="2">KRISTEN</option>
                                                        <option value="3">KATOLIK</option>
                                                        <option value="4">PROTESTAN</option>
                                                        <option value="5">BUDHA</option>
                                                        <option value="6">HINDU</option>
                                                        <option value="7">KONGHUCHU</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Level Position</label>
                                                    <select v-model="level_id" class="form-control">
                                                        <option v-for="level in levels" v-bind:value="level.level_id">
                                                            {{ level.level_name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>NIK</label>
                                                    <input type="text" v-model="nik" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Alamat</label>
                                                    <textarea name="address" v-model="address" cols="30" rows="3" class="form-control"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label>Contract Start</label>
                                                    <input type="text" v-model="contract_start_date" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Mobile Phone</label>
                                                    <input type="text" v-model="mobile_phone" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Email Kantor</label>
                                                    <input type="text" v-model="email_office" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Email Personal</label>
                                                    <input type="text" v-model="email_personal" class="form-control">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" v-model="xid" class="form-control">
                                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                            <button type="button" class="btn btn-primary" v-if="act == 'add'" v-on:click="handleData">Save</button>
                                            <button type="button" class="btn btn-primary" v-if="act == 'edit'" v-on:click="handleData">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th width="10%">NIK</th>
                                                <th width="20%">Nama Lengkap</th>
                                                <th width="10%">Level</th>
                                                <th width="10%">No Hp</th>
                                                <th width="25%">Alamat</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(employee, index) in sliced">
                                                <th scope="row">{{ index+1 }}</th>
                                                <td>{{employee.nik}}</td>
                                                <td>{{employee.full_name}}</td>
                                                <td>{{employee.level_name}}</td>
                                                <td>{{employee.mobile_phone}}</td>
                                                <td>{{employee.address}}</td>
                                                <td>
                                                    <button class="btn btn-primary"  v-if="view == 1"  data-toggle="modal" data-target="#myMaster" v-on:click="action('view',employee.employees_id)">
                                                        <i class="icon-eye-open"></i>
                                                    </button>
                                                    <button class="btn btn-warning" v-if="edit == 1"  data-toggle="modal" data-target="#myMaster" v-on:click="action('edit',employee.employees_id)">
                                                        <i class="icon-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-danger"  v-if="del == 1"  v-on:click="removeRow(employee)">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Feeds Section-->

                <!-- Page Footer-->
                <footer class="main-footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <p>Rumah Koding&copy; 2017</p>
                            </div>
                            <div class="col-sm-6 text-right">
                                <p>Created With Bismillah</p>
                                <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)-->
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- Javascript files-->
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../vendor/popper.js/umd/popper.min.js"> </script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/jquery.cookie/jquery.cookie.js"> </script>
    <script src="../vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Main File-->
    <script src="../js/front.js"></script>
    <script src="../js/axios.min.js"></script>
    <script type="text/javascript" src="../js/vue.js"></script>
    <script src="../js/sweetalert.min.js"></script>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                errors:[],
                show: false, // display content after API request
                offset: 1, // items to display after scroll
                display: 10, // initial items
                trigger: 10, // how far from the bottom to trigger infinite scroll
                employees: [], // server response data
                end: false, // no more resources
                levels: [],
                image: '',
                full_name: '',
                username: '',
                password: '',
                gender: '',
                level_id: '',
                nik: '',
                address: '',
                contract_start_date: '',
                religion: '',
                mobile_phone: '',
                email_office: '',
                email_personal: '',
                act : '',
                view:0,
                del:0,
                del:0,
                xid: '' //parameter untuk edit
            },
            computed: {
                // slice the array of data to display
                sliced() {
                    return this.employees.slice(0, this.display);
                },
            },
            mounted() {
                this.scroll();
                axios.get('../../server/ajax.php?act=selectLevel').then(response => this.levels = response.data);
                axios.get('../../server/ajax.php?act=cekMenu&id=3').then(response => {
                    this.view = response.data[0].view,
                    this.edit = response.data[0].edit,
                    this.del = response.data[0].del
                })
            },
            created() {
                // get the data by performing API request
                this.fetch();
            },
            methods: {
                removeRow: function(employee) {
                    swal({
                        title: "Apakah anda yakin?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        axios.get('../../server/ajax.php?act=DeleteEvent&table=employees&primary_id=employees_id&id='+employee.employees_id).then(
                        this.employees.splice(this.employees.indexOf(employee), 1)
                    );
                        swal("Hapus Berhasil", {
                        icon: "success",
                        });
                    } else {
                        swal("Penghapusan dibatalkan!");
                    }
                    }); 
                },
                action(act,id){
                    this.act = act;
                    axios.get('../../server/ajax.php?act=ViewEvent&table=employees&primary_id=employees_id&id=' +
                    id).then(
                    response =>{
                        this.full_name = response.data[0].full_name,
                        this.username= response.data[0].username,
                        this.gender= response.data[0].gender,
                        this.level_id= response.data[0].level_id,
                        this.nik= response.data[0].nik,
                        this.address= response.data[0].address,
                        this.contract_start_date= response.data[0].contract_start_date,
                        this.religion= response.data[0].religion,
                        this.mobile_phone= response.data[0].mobile_phone,
                        this.email_office= response.data[0].email_office,
                        this.xid = id
                    });
                },
                search: function (event) {
                    window.setTimeout(() => {
                        axios.get('../../server/ajax.php?act=view&paramsSearch=' +
                            paramsSearch).then(
                            response => this.list =
                            response.data);
                        this.show = true;
                    }, 0);
                },
                scroll() {
                    window.onscroll = ev => {
                        if (
                            window.innerHeight + window.scrollY >=
                            (document.body.offsetHeight - this.trigger)
                        ) {
                            if (this.display < this.employees.length) {
                                this.display = this.display + this.offset;
                            } else {
                                this.end = true;
                            }
                        }
                    };
                },
                // preform API request to the server
                fetch() {
                    window.setTimeout(() => {
                        // example response data
                        axios.get('../../server/ajax.php?act=selectEmployee').then(response => this.employees =
                            response.data);
                        this.show = true;
                    }, 0);
                },
                onFileChange(e) {
                    var files = e.target.files || e.dataTransfer.files;
                    if (!files.length)
                        return;
                    this.createImage(files[0]);
                },
                createImage(file) {
                    var image = new Image();
                    var reader = new FileReader();
                    var vm = this;

                    reader.onload = (e) => {
                        vm.image = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },
                handleData: function () {
                    this.errors = [];
                    if(this.act == 'add')
                        var action = 'insertEmployee';
                    else
                        var action = 'editEmployee';
                    
                    let parameter = 'act='+action+'&full_name=' + this.full_name + '&gender=' + this.gender
                        + '&religion=' + this.religion + '&level_id=' + this.level_id + '&nik=' + this.nik
                        + '&address=' + this.address + '&contract_start_date=' + this.contract_start_date
                        + '&mobile_phone=' + this.mobile_phone + '&email_office=' + this.email_office
                        + '&email_personal=' + this.email_personal+ '&username=' + this.username
                        + '&password=' + this.password+ '&xid=' + this.xid;
                    window.setTimeout(() => {
                        axios.get('../../server/ajax.php?' + parameter)
                            .then(response => this.employees = response.data,
                                $('#myMaster').modal('hide'),
                                swal({
                                    title: "Selamat!",
                                    text: "Data berhasil tersimpan!",
                                    icon: "success",
                                }),
                                this.full_name= '',
                                this.username= '',
                                this.password= '',
                                this.gender= '',
                                this.level_id= '',
                                this.nik= '',
                                this.address= '',
                                this.contract_start_date= '',
                                this.religion= '',
                                this.mobile_phone= '',
                                this.email_office= '',
                                this.email_personal= '' 
                            )
                            .catch(function (error) {
                                // resultElement.innerHTML = generateErrorHTMLOutput(error);
                            });
                    }, 0);
                }
            }
        })

    </script>
</body>

</html>