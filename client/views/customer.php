<?php 
    include "header.php";
    include "leftmenu.php";
?>
            <div class="content-inner" id="app">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">Master Customer</h2>
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
                                            <button type="button" class="btn btn-primary" v-on:click="search">
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
                                                    <label>Nama Customer</label>
                                                    <input type="text" v-model="customer_name" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Alamat Kantor</label>
                                                    <input type="text" v-model="address" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Alamat Pengiriman</label>
                                                    <input type="text" v-model="address_shipping" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Kota</label>
                                                    <input type="text" v-model="city" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Negara</label>
                                                    <input type="text" v-model="country" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Phone</label>
                                                    <input type="text" v-model="phone" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" v-model="email" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>NPWP</label>
                                                    <input type="text" v-model="npwp" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Tax Default</label>
                                                    <div class="col-sm-9">
                                                        <div>
                                                            <input id="optionsRadios1" type="radio" checked="" value="0" v-model="tax_status">
                                                            <label for="optionsRadios1">Exclude</label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input id="optionsRadios2" type="radio" value="1" v-model="tax_status">
                                                            <label for="optionsRadios2">Include</label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input id="optionsRadios3" type="radio" value="2" v-model="tax_status">
                                                            <label for="optionsRadios3">Non Tax</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>PKP Status</label>
                                                    <div class="col-sm-9">
                                                        <div>
                                                            <input id="pkp1" type="radio" checked="" value="0" v-model="pkp_status">
                                                            <label for="pkp1">Non PKP</label>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <input id="pkp2" type="radio" value="1" v-model="pkp_status">
                                                            <label for="pkp2">PKP</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Currency Code</label>
                                                    <select v-model="currency_code" class="form-control">
                                                        <option v-for="currency in currencys" v-bind:value="currency.currency_code">
                                                            {{ currency.currency_name }}
                                                        </option>
                                                    </select>
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
                                                <th width="5%">#</th>
                                                <th width="15%">Nama Customer</th>
                                                <th width="15%">Alamat Kantor</th>
                                                <th width="10%">No Telp</th>
                                                <th width="10%">Tax Status</th>
                                                <th width="10%">Pkp Status</th>
                                                <th width="10%">Currency</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(grid, index) in list">
                                                <th scope="row">{{ index+1 }}</th>
                                                <td>{{grid.customer_name}}</td>
                                                <td>{{grid.address}}</td>
                                                <td>{{grid.phone}}</td>
                                                <td>{{grid.tax_status}}</td>
                                                <td>{{grid.pkp_status}}</td>
                                                <td>{{grid.currency_code}}</td>
                                                <td>
                                                    <button class="btn btn-primary"  v-if="view == 1"  data-toggle="modal" data-target="#myMaster" v-on:click="action('view',grid.customer_id)">
                                                        <i class="icon-eye-open"></i>
                                                    </button>
                                                    <button class="btn btn-warning" v-if="edit == 1"  data-toggle="modal" data-target="#myMaster" v-on:click="action('edit',grid.customer_id)">
                                                        <i class="icon-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-danger"  v-if="del == 1"  v-on:click="removeRow(grid)">
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
                //Basic Params
                errors:[],
                show: false, // display content after API request
                offset: 1, // items to display after scroll
                display: 10, // initial items
                trigger: 10, // how far from the bottom to trigger infinite scroll
                list: [], // server response data
                end: false, // no more resources
                act : '',
                view:0,
                del:0,
                del:0,
                xid: '', //parameter untuk edit
                //END Basic Params
                currencys: [],

                customer_name: '',
                address: '',
                address_shipping: '',
                city: '',
                country: '',
                phone: '',
                email: '',
                npwp: '',
                tax_status: '',
                pkp_status: '',
                currency_code: ''
            },
            computed: {
                // slice the array of data to display
                sliced() {
                    return this.list.slice(0, this.display);
                },
            },
            mounted() {
                this.scroll();
                axios.get('../../server/ajax.php?act=selectCurrency').then(response => this.currencys = response.data);
                axios.get('../../server/ajax.php?act=cekMenu&id=7').then(response => {
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
                removeRow: function(grid) {
                    swal({
                        title: "Apakah anda yakin?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        axios.get('../../server/ajax.php?act=DeleteEvent&table=customer&primary_id=customer_id&id='+grid.customer_id).then(
                        this.list.splice(this.list.indexOf(grid), 1)
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
                    axios.get('../../server/ajax.php?act=ViewEvent&table=customer&primary_id=customer_id&id=' +
                    id).then(
                    response =>{

                        this.customer_name= response.data[0].customer_name,
                        this.address= response.data[0].address,
                        this.address_shipping= response.data[0].address_shipping,
                        this.city= response.data[0].city,
                        this.country= response.data[0].country,
                        this.phone= response.data[0].phone,
                        this.email= response.data[0].email,
                        this.npwp= response.data[0].npwp,
                        this.tax_status= response.data[0].tax_status,
                        this.pkp_status= response.data[0].pkp_status,
                        this.currency_code= response.data[0].currency_code
                        this.xid = id
                    });
                },
                search: function (event) {
                    window.setTimeout(() => {
                        let paramsSearch = document.getElementById('paramsSearch').value;
                        axios.get('../../server/ajax.php?act=selectDataCust&paramsSearch=' +
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
                            if (this.display < this.list.length) {
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
                        axios.get('../../server/ajax.php?act=selectDataCust').then(response => this.list =
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
                        var action = 'insertDataCust';
                    else
                        var action = 'editDataCust';
                    
                       let parameter = 'act='+action+
                        '&customer_name=' + this.customer_name+
                        '&address=' + this.address+
                        '&address_shipping=' + this.address_shipping+
                        '&city=' + this.city+
                        '&country=' + this.country+
                        '&phone=' + this.phone+
                        '&email=' + this.email+
                        '&npwp=' + this.npwp+
                        '&tax_status=' + this.tax_status+
                        '&pkp_status=' + this.pkp_status+
                        '&xid=' + this.xid+
                        '&currency_code=' + this.currency_code;

                    window.setTimeout(() => {
                        axios.get('../../server/ajax.php?' + parameter)
                            .then(response => this.list = response.data,
                                $('#myMaster').modal('hide'),
                                swal({
                                    title: "Selamat!",
                                    text: "Data berhasil tersimpan!",
                                    icon: "success",
                                }),

                                // this.customer_name= '',
                                // this.address= '',
                                // this.address_shipping= '',
                                // this.city= '',
                                // this.country= '',
                                // this.phone= '',
                                // this.email= '',
                                // this.npwp= '',
                                // this.tax_status= '',
                                // this.pkp_status= '',
                                // this.xid= '',
                                // this.currency_code= ''
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