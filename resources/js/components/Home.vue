<template>
  <div class="home">
    <el-row type="flex" class="row-bg"  justify="space-between" v-loading="loadingStat">
      <el-col :span="6">
        <router-link tag="div" :to="'/jobs'">
          <el-card class="box-card">
            <el-row type="flex" class="row-bg" justify="center">
              {{jobs}}
            </el-row>
            <el-row type="flex" class="row-bg" justify="center" style="margin-bottom:0px">
              Jobs
            </el-row>
          </el-card>
        </router-link>

      </el-col>
      <el-col :span="6">
        <el-card class="box-card">
          <el-row type="flex" class="row-bg" justify="center">
            {{flats}}
          </el-row>
          <el-row type="flex" class="row-bg" justify="center" style="margin-bottom:0px">
            Appartements
          </el-row>
        </el-card>
      </el-col>
      <el-col :span="6">
        <el-card class="box-card">
          <el-row type="flex" class="row-bg" justify="center">
            {{purchases}}
          </el-row>
          <el-row type="flex" class="row-bg" justify="center" style="margin-bottom:0px">
            Achats
          </el-row>
        </el-card>
      </el-col>
    </el-row>

    <el-row>
      <h4>Articles proches de la date de péremption</h4>
      <router-link tag="div" :to="'/foodshopping'">
        <el-table
          :data="articles"
          v-loading="loadingArticles"
          style="width: 100%">
          <el-table-column
            prop="name"
            label="Article"
            width="180">
          </el-table-column>
          <el-table-column
            label="Peremption"
            width="180">
            <template slot-scope="scope">
              {{ dateToEU(scope.row.lapsing) }}
            </template>
          </el-table-column>
        </el-table>
      </router-link>

    </el-row>

    <!-- <div class='authentification'>
     <h2>VueJS + Google Calendar Example</h2>
     Authentification
     <button v-if='!authorized' @click="handleAuthClick">Sign In</button>
     <button v-if='authorized' @click="handleSignoutClick">Sign Out</button>
    </div>
     <hr>
     <button v-if='authorized' @click="getData">Get Data</button>
     <div class="item-container" v-if="authorized && items">
       <pre v-html="items"></pre>
     </div>-->
  </div>
</template>


<script>
    // Client ID and API key from the Developer Console
    const CLIENT_ID = '333403716848-vt3qvkijpsat4g000595cqbmc66tr97g.apps.googleusercontent.com';
    const API_KEY = 'AIzaSyBKBbUWr7ZDDAZ_P2RFagGySNUusMP7FMA';
    // Array of API discovery doc URLs for APIs used by the quickstart
    const DISCOVERY_DOCS = ['https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest'];
    // Authorization scopes required by the API; multiple scopes can be
    // included, separated by spaces.
    const SCOPES = 'https://www.googleapis.com/auth/calendar.readonly';

    export default {
      data() {
        return {
          items: undefined,
          api: undefined,
          authorized: false,
          jobs:0,
          flats:0,
          purchases:0,
          articles:[],
          loadingArticles:false,
          loadingStat:false,
        }
      },

      created() {
        this.api = gapi;
        this.handleClientLoad();
        this.getStats();
        this.getArticles();
      },

      methods: {
        dateToEU:function(dateUS){
            var moment = require('moment');
            return moment(dateUS).format("DD/MM/YYYY");
        },
        getArticles:function() {
          this.loadingArticles = true;
          axios.get(appURL+'api/foodshopping')
          .then((response) =>{
              if(response.data)
              {
                  this.articles = response.data;
                  this.loadingArticles = false;
              }
          })
          .catch(error => {
                this.loadingArticles=false;
                this.$alert('Erreur : '+error, 'Attention', {
                  confirmButtonText: 'Ok',
                  callback: action => {

                    }
                });
          });
        },
        getStats(){
          this.loadingStat = true;
          axios.get(appURL+'api/getStats')
          .then((response) =>{
              if(response.data)
              {
                  this.jobs = response.data.jobs;
                  this.flats = response.data.flats;
                  this.puchases = response.data.puchases;

                  this.loadingStat = false;
              }
          })
          .catch(error => {
                this.loadingStat=false;
                this.$alert('Erreur : '+error, 'Attention', {
                  confirmButtonText: 'Ok',
                  callback: action => {

                    }
                });
          });
        },
        /**
         *  On load, called to load the auth2 library and API client library.
         */
        handleClientLoad() {
          this.api.load('client:auth2', this.initClient);
          console.log('loadapi')
        },

        /**
         *  Initializes the API client library and sets up sign-in state
         *  listeners.
         */
        initClient() {
          let vm = this;

          vm.api.client.init({
            apiKey: API_KEY,
            clientId: CLIENT_ID,
            discoveryDocs: DISCOVERY_DOCS,
            scope: SCOPES
          }).then(_ => {
            // Listen for sign-in state changes.
            vm.api.auth2.getAuthInstance().isSignedIn.listen(vm.authorized);
          });
        },

        /**
         *  Sign in the user upon button click.
         */
        handleAuthClick(event) {
          Promise.resolve(this.api.auth2.getAuthInstance().signIn())
            .then(_ => {
              this.authorized = true;
            });
        },

        /**
         *  Sign out the user upon button click.
         */
        handleSignoutClick(event) {
          Promise.resolve(this.api.auth2.getAuthInstance().signOut())
            .then(_ => {
              this.authorized = false;
            });
        },

        /**
         * Print the summary and start datetime/date of the next ten events in
         * the authorized user's calendar. If no events are found an
         * appropriate message is printed.
         */
        getData() {
          let vm = this;

          vm.api.client.calendar.events.list({
            'calendarId': 'primary',
            'timeMin': (new Date()).toISOString(),
            'showDeleted': false,
            'singleEvents': true,
            'maxResults': 10,
            'orderBy': 'startTime'
          }).then(response => {
            vm.items = this.syntaxHighlight(response.result.items);
            console.log(vm.items);
          });
        },

        syntaxHighlight(json) {
          if (typeof json != 'string') {
            json = JSON.stringify(json, undefined, 2);
          }
          json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
          return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, match => {
            var cls = 'number';
            if (/^"/.test(match)) {
              if (/:$/.test(match)) {
                cls = 'key';
              } else {
                cls = 'string';
              }
            } else if (/true|false/.test(match)) {
              cls = 'boolean';
            } else if (/null/.test(match)) {
              cls = 'null';
            }
            return '<span class="' + cls + '">' + match + '</span>';
          });
        }
      }
    }
</script>
