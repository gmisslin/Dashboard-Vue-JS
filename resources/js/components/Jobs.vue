<template>
  <div class="jobs">

    <el-row>
      <router-link tag="div" :to="'/jobs/crud/'">
        <el-button type="success" round size="mini">Ajouter un job</el-button>
      </router-link>
    </el-row>

    <el-row>
      <el-table
        :data="jobs"
        v-loading="loading"
        style="width: 100%">



        <el-table-column
          prop="name"
          label="Nom"
          width="180">
        </el-table-column>
        <el-table-column
          prop="business"
          label="Entreprise"
          width="180">
        </el-table-column>
        <el-table-column
          prop="city"
          label="Ville"
          width="180">
        </el-table-column>
        <el-table-column
          prop="salary"
          label="Salaire">
        </el-table-column>
        <el-table-column
          label="Actions">
          <template slot-scope="scope">
            <el-row>
              <router-link tag="div" :to="'/jobs/crud/'+scope.row.token">
                <el-button type="primary" round size="mini">Détails</el-button>
              </router-link>
            </el-row>

            <el-row>
              <el-button @click.native.prevent="deleteJob(scope.$index,scope.row, jobs)" type="danger" round size="mini">Supprimer</el-button>
            </el-row>
          </template>
        </el-table-column>
      </el-table>
    </el-row>
  </div>
</template>

<script>
    export default {
      data() {
        return {
          jobs: [],
          loading:false,
        };
      },
      methods: {
        getJobs:function() {
          this.loading = true;
          axios.get(appURL+'api/jobs')
          .then((response) =>{
              if(response.data)
              {
                  this.jobs = response.data;
                  this.loading = false;
              }
          })
          .catch(error => {
                this.loading=false;
                this.$alert('Erreur : '+error, 'Attention', {
                  confirmButtonText: 'Ok',
                  callback: action => {

                    }
                });
          });
        },

        deleteJob:function(index,job, rows) {
          this.loading = true;
          this.$confirm('Ceci effacera le job. Continuer?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Annuler',
            type: 'warning'
          }).then(() => {
            axios.delete(appURL+'api/jobs/'+job.token)
            .then((response) =>{
                if(response.data)
                {
                    rows.splice(index, 1);
                    this.$notify({
                      title: 'Success',
                      message: 'Job supprimé',
                      type: 'success'
                    });
                    this.loading = false;
                }
            })
            .catch(error => {
                  this.loading=false;
                  this.$alert('Erreur : '+error, 'Attention', {
                    confirmButtonText: 'Ok',
                    callback: action => {

                      }
                  });
            });
          }).catch(() => {

          });
        }
      },
      created(){
        this.getJobs();
      }
    }
</script>
