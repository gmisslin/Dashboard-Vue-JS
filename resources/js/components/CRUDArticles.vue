<template>
  <div class="crud-articles">

    <h4 v-if="isEditing">{{ruleForm.name}}</h4>

    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px">

      <el-form-item label="Nom" prop="name">
        <el-input v-model="ruleForm.name"></el-input>
      </el-form-item>

      <el-form-item label="Peremption" prop="lapsing">
         <el-date-picker format="yyyy-MM-dd" value-format="yyyy-MM-dd" type="date" placeholder="Pick a date" v-model="ruleForm.lapsing" style="width: 100%;"></el-date-picker>
      </el-form-item>

      <el-form-item>
        <el-button v-if="isEditing" type="primary" @click="submitForm('ruleForm')">Editer</el-button>
        <el-button v-else type="primary" @click="submitForm('ruleForm')">Créer</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
    export default {
      data() {
        return {
          isEditing:false,
          ruleForm: {
            name: '',
            lapsing: '',
          },
          rules: {
            name: [
              { required: true, message: 'Please input Article name', trigger: 'blur' },
            ],
            salary: [
              { required: true, message: 'Please input Article name', trigger: 'blur' },
              { required: true,type: "number", message: 'Please input a number', trigger: 'blur' },
            ],
          }
        }
      },
      methods: {
        submitForm(formName)
        {
          this.$refs[formName].validate((valid) => {
            if (valid) {
              this.loading = true;
              if(this.isEditing)
              {
                axios.put(appURL+'api/foodshopping/'+this.$router.history.current.params.token,{
                  form : this.ruleForm
                })
                .then((response) =>{
                    if(response.data)
                    {
                        this.$notify({
                          title: 'Success',
                          message: 'Article édité',
                          type: 'success'
                        });
                       this.$router.push( '/foodshopping' );
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
              }
              else {
                axios.post(appURL+'api/foodshopping/',{
                  form : this.ruleForm
                })
                .then((response) =>{
                    if(response.data)
                    {
                        this.$notify({
                          title: 'Success',
                          message: 'Article créé',
                          type: 'success'
                        });
                       this.$router.push( '/foodshopping' );
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

              }


            } else {
              console.log('error submit!!');
              return false;
            }
          });
        },
        getArticles(){
          axios.get(appURL+'api/foodshopping/'+this.$router.history.current.params.token)
          .then((response) =>{
              if(response.data)
              {
                 this.ruleForm.name = response.data.name;
                 this.ruleForm.lapsing = response.data.lapsing
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
        }
      },
      created:function(){
        try {
          //IS EDITING
          if(this.$router.history.current.params.token)
          {
            this.getArticles();
            this.isEditing=true;
          }
          //IS CREATING
          else {

          }


        } catch (e) {
          console.log(e)
        } finally {

        }

      }
    }
</script>
