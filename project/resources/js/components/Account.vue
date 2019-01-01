<template>
    <div class="container">
        <clip-loader :loading="loading" :color="color" :size="size"></clip-loader>
        <h3 class="ui horizontal divider header mt-5"> <i class="server icon"></i>Hostings</h3>
        <div class="row">
            <div class="col-md-6">
                 <div class="form-group" v-if="accountsLoaded">
                    <div class="ui icon input">
                        <input type="text" placeholder="Search...">
                    <i class="circular search link icon"></i>
                    </div>
                </div>
                <ul id="account_list" class="d-none">
                    <li v-for="account in accounts" v-bind:key="account.id">{{ account.name }}</li>
                </ul>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <table class="ui selectable inverted table unstackable">
                    <thead>
                        <tr>
                            <th class="text-center" scope="col">Service ID</th>
                            <th scope="col">Domein naam</th>
                            <th class="" scope="col">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="account in accounts" v-bind:key="account.id">
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
            }
        },
        components: {
            ClipLoader
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


