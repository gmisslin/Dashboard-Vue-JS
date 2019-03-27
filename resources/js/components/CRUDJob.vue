<template>
  <div class="crud-jobs">

    <h4 v-if="isEditing">{{ruleForm.name}} - {{ruleForm.business}}</h4>

    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px">
      <el-form-item label="Entreprise" prop="business">
        <el-input v-model="ruleForm.business"></el-input>
      </el-form-item>

      <el-form-item label="Nom" prop="name">
        <el-input v-model="ruleForm.name"></el-input>
      </el-form-item>

      <el-form-item label="Ville" prop="city">
        <el-input v-model="ruleForm.city"></el-input>
      </el-form-item>

      <el-form-item label="Salaire" prop="salary">
         <el-input v-model.number="ruleForm.salary"></el-input>
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
            business: '',
            name: '',
            city : '',
            salary: 0,
          },
          rules: {
            name: [
              { required: true, message: 'Please input Job name', trigger: 'blur' },
            ],
            salary: [
              { required: true, message: 'Please input Job name', trigger: 'blur' },
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
                axios.put(appURL+'api/jobs/'+this.$router.history.current.params.token,{
                  form : this.ruleForm
                })
                .then((response) =>{
                    if(response.data)
                    {
                        this.$notify({
                          title: 'Success',
                          message: 'Job édité',
                          type: 'success'
                        });
                       this.$router.push( '/jobs' );
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
                axios.post(appURL+'api/jobs/',{
                  form : this.ruleForm
                })
                .then((response) =>{
                    if(response.data)
                    {
                        this.$notify({
                          title: 'Success',
                          message: 'Job créé',
                          type: 'success'
                        });
                       this.$router.push( '/jobs' );
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
        getJob(){
          axios.get(appURL+'api/jobs/'+this.$router.history.current.params.token)
          .then((response) =>{
              if(response.data)
              {
                 this.ruleForm.name = response.data.name;
                 this.ruleForm.business = response.data.business
                 this.ruleForm.salary = response.data.salary
                 this.ruleForm.city = response.data.city
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
            this.getJob();
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
