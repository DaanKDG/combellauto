<template>
    <div class="container">
        <clip-loader :loading="loading" :color="color" :size="size"></clip-loader>
        <h3 class="ui horizontal divider header mt-5"> <i class="server icon"></i>Hostings</h3>
        <div class="row">
            <div class="col-md-6">
                 <div class="form-group" v-if="accountsLoaded">
                    <div class="ui icon input">
                        <input type="text" placeholder="Search..." id="search" v-on:keyup="searchFunction()">
                    <i class="circular search link icon"></i>
                    </div>
                </div>
                <ul id="account_list" class="d-none">
                    <li v-for="account in accounts" v-bind:key="account.id">{{ account.name }}</li>
                </ul>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 table_container">
                <table class="ui selectable inverted table unstackable" id="overview">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Service ID</th>
                            <th scope="col">Domein naam</th>
                            <th class="" scope="col">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(account, index) in accounts" v-bind:key="account.id" :id="['index_' + index]" class="main_tr">
                            <th scope="row" class="text-center">{{ account.servicepack_id}}</th>
                            <td>
                                <a class="domain-link" target="_blank" v-bind:href="'https://'+ account.domain_name">{{ account.domain_name}}</a>
                                <!-- <a href="{{ url('/detail/' . $account['name'] ) }}">{{ $account["domain_name"] }}</a> -->
                            </td>
                            <td align="center">
                                <a @click="showDetails(account)" class="ui inverted button">Details</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="page_btn_div ui centered grid">
                    <button class="ui button page_btn" v-for="page in pageCount" @click="sort([page])" :id="['page_' + page]">{{ page }}</button>
                </div>
            </div>
            <div class="col-lg-6" id='example1'>
                <div v-if='this.account.domain_name' class="" style="width: 100%;">
                        <table class="ui selectable inverted table unstackable">
                                <tbody>
                                    <tr>
                                        <th scope="row">Domain Name</th>
                                        <td>{{ this.account.domain_name}}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Servicepack ID</th>
                                        <td>{{ this.account.servicepack_id}}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Max size</th>
                                        <td>{{ this.account.max_size}}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row">Actual size</th>
                                        <td>{{ this.account.actual_size }}</td>
                                    </tr>

                                    <tr>
                                        <th scope="row">IP</th>
                                        <td>{{ this.account.ip }}</td>
                                    </tr>
                                </tbody>
                            </table>
                
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import ClipLoader from 'vue-spinner/src/Cliploader.vue'
    export default {

        data() {
            return {
                loading: true,
                size: '100px',
                color: '#1b1c1d',
                accountsLoaded: false,
                accounts: [],
                account: {
                    domain_name : null,
                    servicepack_id : null,
                    max_size: null,
                    actual_size: null,
                    ip : null,
                },
                table: "",
                n: 10,
                firstLoad: true,
                rowCount: "",
                tr: [],
                pageCount: ""
            }
        },
        mounted() {
            console.log('Component mounted.');
            this.getAccounts();
        },
        methods: {
            getAccounts() {
                axios.get('/api/accounts', {
                        headers: {'Accept': 'application/json'}
                    })
                    .then(res => { this.accounts = res.data; })
                    .then(() => {this.loading = false;})
                    .catch(error => console.log(error));
            },
            showDetails(account) {
                axios.get(`/api/accounts/${account.name}`, {
                    headers: {'Accept': 'application/json'}
                })
                .then(res => {
                    this.account.domain_name = res.data.domain_name;
                    this.account.servicepack_id = res.data.servicepack_id;
                    this.account.ip = res.data.ip;
                    this.account.max_size = res.data.max_size;
                    this.account.actual_size = res.data.actual_size;
                })
                .then(() => {})
                .catch(error => console.log(error));
            },
            searchFunction() {
                var input = document.getElementById('search');
                var filter = input.value.toUpperCase();
                var list = document.getElementById("overview");
                var tr = list.getElementsByTagName("tr");
                var pagination = document.getElementsByClassName('page_btn_div')[0];

                if (filter) {
                    pagination.classList.add('d-none');

                    for (var i = 1; i < tr.length; i++) {
                        var a = tr[i].getElementsByTagName("a")[0];
                        var txtValue = a.textContent || a.innerText;
                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].classList.remove("d-none");
                        } else {
                            tr[i].classList.add("d-none");
                        }
                    }
                } else {
                    pagination.classList.remove('d-none');
                    this.sort(1);
                }
            },
            sort(p) {
                // pagination
                var s = ((this.n * p) - this.n);
                var all_rows = document.getElementsByClassName("main_tr");

                var last_row = this.table.rows[ this.table.rows.length - 1 ].id;
                var max_id = last_row.split('_')[1];

                for (var i = 0; i < max_id + 1; i++) {
                    var id = "index_" + i;
                    var el = all_rows[i];
                    
                    if (el) {
                        el.classList.add("d-none");

                        if (i >= s && i < (s + this.n)) {
                            el.classList.remove("d-none");
                        }
                    }
                }

                //set active page btn
                var pg_btns = document.getElementsByClassName("page_btn");
                var pg_btn = document.getElementById("page_" + p);

                for (var j = 0; j < pg_btns.length; j++) {
                    pg_btns[j].classList.remove("secondary");
                }

                if (pg_btn) {
                    pg_btn.classList.add("secondary");
                }
            }
        },
        components: {
            ClipLoader
         },
        updated: function () {
            this.$nextTick(function () {

                var _this = this;

                this.table = document.getElementById("overview");
                this.rowCount = this.table.rows.length;
                this.pageCount = Math.ceil(this.rowCount / this.n);

                // apply pagination
                if (this.firstLoad) {
                    document.getElementById("page_1").classList.add('secondary');
                    this.sort(1);
                    this.firstLoad = false
                }
                
                setTimeout(function() {
                    _this.accountsLoaded = true;
                }, 100);
            })
        }
    }
</script>


