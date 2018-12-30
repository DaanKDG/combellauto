<template>
  <div class="container">
            <div class="ui icon message mt-4">
                    <i class="notched circle loading icon"></i>
                    <div class="content">
                        <div class="header">
                          {{this.accounts.length ? 'Generating hosting accounts': 'Waiting for data'}}
                        </div>
                         <p>{{this.accounts.length ? this.accounts.length + ' ' + 'hosting accounts created' : '0 items' }} </p>
                     </div>
             </div>
    <!-- <div class="account-section" v-if="this.accounts">

        <div class="ui green segment" v-for="account in accounts" v-bind:key="account.id">
            <div class="item">
                <p>{{account.name}}</p>
            </div>
        </div>
    </div> -->
<!-- table -->

<table class="ui inverted table" >
  <thead>
    <tr><th>Naam</th>
    <th>Domein</th>
    <th>Statuscode</th>
  </tr></thead><tbody>
    <tr v-for="account in accounts" v-bind:key="account.id">
      <td style="width: 33%;" class="positive">{{account.name}}</td>
      <td style="width: 33%;" class="positive">identifier.mtantwerp.eu</td>
      <td style="width: 33%;" class="positive">202 <i class="icon checkmark"></i></td>
    </tr>
  </tbody>
</table>

  </div>
</template>


<script>
export default {
  data() {
    return {
      accounts: []
    };
  },
  created() {
    Echo.channel("account-channel").listen("AccountCreation", e => {
      this.accounts.unshift(e.account);
    });
    
  }

}
</script>


