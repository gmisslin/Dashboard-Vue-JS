<template>
  <div class="flats">

    <el-row>
      <router-link tag="div" :to="'/flats/crud/'">
        <el-button type="success" round size="mini">Ajouter un appartement</el-button>
      </router-link>
    </el-row>

    <el-row>
      <el-table
        :data="flats"
        v-loading="loading"
        style="width: 100%">
        <el-table-column
          prop="name"
          label="Nom"
          width="180">
        </el-table-column>
        <el-table-column
          prop="rooms"
          label="Pièces"
          width="180">
        </el-table-column>
        <el-table-column
          prop="address"
          label="Adresse"
          width="180">
        </el-table-column>
        <el-table-column
          prop="rent"
          label="Loyer">
        </el-table-column>
        <el-table-column
          label="Actions">
          <template slot-scope="scope">
            <el-row>
              <router-link tag="div" :to="'/flats/crud/'+scope.row.token">
                <el-button type="primary" round size="mini">Détails</el-button>
              </router-link>
            </el-row>

            <el-row>
              <el-button @click.native.prevent="deleteFlats(scope.$index,scope.row, flats)" type="danger" round size="mini">Supprimer</el-button>
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
          flats: [],
          loading:false,
        };
      },
      methods: {
        getFlats:function() {
          this.loading = true;
          axios.get(appURL+'api/flats')
          .then((response) =>{
              if(response.data)
              {
                  this.flats = response.data;
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

        deleteFlats:function(index,flat,rows) {
          this.loading = true;
          this.$confirm('Ceci effacera le flat. Continuer?', 'Warning', {
            confirmButtonText: 'OK',
            cancelButtonText: 'Annuler',
            type: 'warning'
          }).then(() => {
            axios.delete(appURL+'api/flats/'+flat.token)
            .then((response) =>{
                if(response.data)
                {
                    rows.splice(index, 1);
                    this.$notify({
                      title: 'Success',
                      message: 'Flat supprimé',
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
        this.getFlats();
      }
    }
</script>
