<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">

                <div class="form-group" v-if="accountsLoaded">
                    <label for="search">Search</label>

                    <input type="text" class="form-control" id="search">
                </div>

                <ul id="account_list" class="d-none">
                    <li v-for="account in accounts" v-bind:key="account.id">{{ account.name }}</li>
                </ul>

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Servicepack ID</th>
                            <th scope="col">Domain Name</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="account in accounts" v-bind:key="account.id">
                            <th scope="row">{{ account.servicepack_id}}</th>
                            <td>
                                <a href="#">{{ account.domain_name}}</a>
                                <!-- <a href="{{ url('/detail/' . $account['name'] ) }}">{{ $account["domain_name"] }}</a> -->
                            </td>
                            <td>
                                <a @click="showDetails(account)" class="btn btn-outline-info">Details</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <div v-if='this.account.domain_name' class="card">
                    <div class="card-header">
                       Hosting details
                    </div>
                    <div class="card-body">
                        <table class="table">
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
    </div>

</template>

<script>
    export default {
        data() {
            return {
                accountsLoaded: false,
                accounts: [],
                account: {
                    domain_name : null,
                    servicepack_id : null,
                    max_size: null,
                    actual_size: null,
                    ip : null,
                }
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
                .catch(error => console.log(error));
            }
        },
        updated: function () {
            this.$nextTick(function () {

                //load search element once data is loaded

                var _this = this;

                setTimeout(function() {

                    _this.accountsLoaded = true;
                    var input = document.getElementById('search');
                    var awesome = new Awesomplete(input, {list: "#account_list"});

                }, 100);
            })
        }
    }
</script>
