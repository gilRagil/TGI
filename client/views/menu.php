<?php 
    include "header.php";
    include "leftmenu.php";
?>
            <div class="content-inner" id="app">
                <!-- Page Header-->
                <header class="page-header">
                    <div class="container-fluid">
                        <h2 class="no-margin-bottom">Master Product</h2>
                    </div>
                </header>
                <!-- Dashboard Cards Section -->
                <section class="dashboard-counts no-padding-bottom">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <div class="col-lg-9">
                                    <form class="form-inline" id="bookform" name="bookform">
                                        <div class="form-group">
                                            <input id="paramsSearch" type="text" placeholder="Search" class="mr-3 form-control">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary" v-on:click="search" >
                                                <i class="icon-search"></i>
                                            </button>
                                        </div>&nbsp;
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myMaster">
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
                                        <div class="modal-body">
                                            <form id="form_input">
                                                <div class="form-group">
                                                    <label>Level Name</label>
                                                    <input type="text" v-model="level_name" class="form-control">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Close</button>
                                            <button type="button" class="btn btn-primary" v-on:click="handleInsertData">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-sm" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="1%">#</th>
                                                <th width="50%">Nama Level</th>
                                                <th width="10%">Setting</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(grid, index) in list">
                                                <th scope="row">{{ index+1 }}</th>
                                                <td>{{grid.level_name}}</td>
                                                <td>
                                                    <button class="btn btn-success" v-if="edit == 1" v-on:click="winpopup(grid.level_id)">
                                                        <i class="icon-pencil" ></i>
                                                    </button>
                                                    <button class="btn btn-danger" v-if="del == 1"  v-on:click="removeRow(grid)">
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
                show: false, // display content after API request
                offset: 1, // items to display after scroll
                display: 10, // initial items
                trigger: 10, // how far from the bottom to trigger infinite scroll
                list: [], // server response data
                end: false, // no more resources
                level_name: "",
                edit:0,
                del:0
                //headerMenu

            },
            computed: {
                // slice the array of data to display
                sliced() {
                    return this.list.slice(0, this.display);
                },
            },
            mounted() {
                this.scroll();
                axios.get('../../server/ajax.php?act=selectLevel').then(response => this.list = response.data);
                axios.get('../../server/ajax.php?act=cekMenu&id=47').then(response => {
                    this.edit = response.data[0].edit,
                    this.del = response.data[0].del
                })
                .catch(function (error) {
                    // window.location.href = 'login.html'
                });
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
                        axios.get('../../server/ajax.php?act=DeleteEvent&table=menu_level&primary_id=level_id&id='+grid.level_id);
                        axios.get('../../server/ajax.php?act=DeleteEvent&table=level&primary_id=level_id&id='+grid.level_id).then(
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
                search: function (event) {
                    console.log('Test2');
                    window.setTimeout(() => {
                        // example response data
                        let paramsSearch = document.getElementById('paramsSearch').value;
                        axios.get('../../server/ajax.php?act=selectLevel&paramsSearch=' +
                            paramsSearch).then(
                            response => this.list =
                            response.data);
                        this.show = true;
                    }, 0);
                    console.log('Test');
                },
                winpopup(level_id){
                    var win_items;
                    var dimensi="toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=1,resizable=0,fullscreen=1";
                    var url ='my_level.php?x='+level_id; 
                    if (win_items!=null) {
                        if (!win_items.closed) {
                            win_items.focus();
                        }else{
                            win_items = window.open(url,"Dimensi"+level_id,dimensi);
                        }
                    }else{
                        win_items = window.open(url,"Dimensi"+level_id,dimensi);
                    }
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
                        axios.get('../../server/ajax.php?act=selectLevel').then(response => this.list =
                            response.data);
                        this.show = true;
                    }, 0);
                },
                handleInsertData: function () {
                    let parameter = 'act=insertLevel&level_name=' + this.level_name;
                    window.setTimeout(() => {
                        axios.get('../../server/ajax.php?' + parameter)
                            .then(response => this.list = response.data,
                            $('#myMaster').modal('hide'),
                            swal({
                                title: "Selamat!",
                                text: "Data berhasil tersimpan!",
                                icon: "success",
                            }))
                            .catch(function (error) {
                                document.getElementById("form_input").reset();
                            });
                    }, 0);
                }
            }
        })

    </script>
</body>

</html>