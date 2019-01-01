<template>
  <div class="container" v-show="submit">
    <div class="progress" v-if="!this.finished" >
        <div class="ui inverted icon message mt-4">
                <i class="notched circle loading icon"></i>
                <div class="content">
                    <div class="header">
                      {{this.accounts.length ? 'Hosting accounts aanmaken': 'Wachten op data'}}
                    </div>
                    <p>{{this.accounts.length ? this.accounts.length + ' ' + 'accounts aangemaakt' : '0 items' }} </p>
                </div>
        </div>
    </div>
    <div class="finished" v-if="this.finished">
      <div class="ui inverted icon message mt-4">
          <i class="notched check circle icon"></i>
          <div class="content">
              <div class="header">
                {{this.accounts.length ? 'Hosting accounts aanmaken': 'Wachten op data'}}
              </div>
              <p>{{this.accounts.length ? this.accounts.length + ' ' + 'accounts aangemaakt' : '0 items' }} </p>
          </div>
    </div>
</div>
<table class="ui inverted table" >
  <thead>
    <tr><th>Naam</th>
    <th>Domein</th>
    <th>Statuscode <i style='font-size:13px;' class="question circle outline icon"></i></th>
  </tr></thead><tbody>
    <tr v-for="account in accounts" v-bind:key="account.id">
      <td style="width: 33%;" class="positive">{{account.name}}</td>
      <td style="width: 33%;" class="positive">{{account.domain}}</td>
      <td style="width: 33%;" class="positive">202 <i class="icon checkmark"></i></td>
    </tr>
  </tbody>
</table>

  </div>
</template>


<script>
export default {
name: 'status',

  props: {
    submit: {
      type: Boolean,
      default: true,
    },
    finished: {
      type: Boolean,
      default: false,
    },
  },
  data() {
    return {
      accounts: []
    };
  },
  created() {
    Echo.channel("account-channel").listen("AccountWasUpdated", e => {
        this.accounts.unshift(e.account);
    });
    
  }

}
</script>


