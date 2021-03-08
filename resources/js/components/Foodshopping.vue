<template>
    <div class="foodshopping">
      <el-row>
        <router-link tag="div" :to="'/foodshopping/crud/'">
          <el-button type="success" round size="mini">Ajouter un article</el-button>
        </router-link>
      </el-row>

      <el-row>
        <el-table
          :data="articles"
          v-loading="loading"
          >
          <el-table-column
            prop="name"
            label="Nom"
            width="180">
          </el-table-column>
          <el-table-column
            label="Peremption"
            width="180">
            <template slot-scope="scope">
              {{ dateToEU(scope.row.lapsing) }}
            </template>
          </el-table-column>
          <el-table-column
            label="Actions">
            <template slot-scope="scope">
              <el-row>
                <router-link tag="div" :to="'/foodshopping/crud/'+scope.row.token">
                  <el-button type="primary" round size="mini">Détails</el-button>
                </router-link>
              </el-row>
              <el-row>
                <el-button @click.native.prevent="deleteArticle(scope.$index,scope.row, articles)" type="danger" round size="mini">Supprimer</el-button>
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
      articles: [],
      loading:false,
    };
  },
  methods: {
    dateToEU:function(dateUS){
        var moment = require('moment');
        return moment(dateUS).format("DD/MM/YYYY");
    },
    getArticles:function() {
      this.loading = true;
      axios.get(appURL+'api/foodshopping')
      .then((response) =>{
          if(response.data)
          {
              this.articles = response.data;
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

    deleteArticle:function(index,article, rows) {
      this.loading = true;
      this.$confirm('Ceci effacera l\'article. Continuer?', 'Warning', {
        confirmButtonText: 'OK',
        cancelButtonText: 'Annuler',
        type: 'warning'
      }).then(() => {
        axios.delete(appURL+'api/foodshopping/'+article.token)
        .then((response) =>{
            if(response.data)
            {
                rows.splice(index, 1);
                this.$notify({
                  title: 'Success',
                  message: 'Article supprimé',
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
    this.getArticles();
  }
}
</script>
