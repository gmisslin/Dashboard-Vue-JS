<template>
  <div class="crud-flats">

    <h4 v-if="isEditing">{{ruleForm.name}}</h4>

    <el-form :model="ruleForm" :rules="rules" ref="ruleForm" label-width="120px">

      <el-form-item label="Nom" prop="name">
        <el-input v-model="ruleForm.name"></el-input>
      </el-form-item>

      <el-form-item label="Ville" prop="city">
        <!-- <el-input v-model="ruleForm.city"></el-input> -->
          </el-form-item>
          <input type="search"  v-model="ruleForm.address" ref="address" class="form-control" placeholder="Where are we going?" />

        <p>Selected: <strong id="address-value">none</strong></p>


        <places placeholder="Where are we going ? ??"
           :options="{ countries: 'FR' }"></places>


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
    import Places from 'vue-places'

    export default {
      components: {
        Places
      },
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
              { required: true, message: 'Please input Flat name', trigger: 'blur' },
            ],
            salary: [
              { required: true, message: 'Please input Flat name', trigger: 'blur' },
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
                axios.put(appURL+'api/flats/'+this.$router.history.current.params.token,{
                  form : this.ruleForm
                })
                .then((response) =>{
                    if(response.data)
                    {
                        this.$notify({
                          title: 'Success',
                          message: 'Flat édité',
                          type: 'success'
                        });
                       this.$router.push( '/flats' );
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
                axios.post(appURL+'api/flats/',{
                  form : this.ruleForm
                })
                .then((response) =>{
                    if(response.data)
                    {
                        this.$notify({
                          title: 'Success',
                          message: 'Flat créé',
                          type: 'success'
                        });
                       this.$router.push( '/flats' );
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
        getFlat(){
          axios.get(appURL+'api/flats/'+this.$router.history.current.params.token)
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
      mounted:function(){
        try {
          //IS EDITING
          if(this.$router.history.current.params.token)
          {
            this.getFlat();
            this.isEditing=true;
          }
          //IS CREATING
          else {

          }


          console.log( this.$refs.address)
          var placesAutocomplete = places({
            appId: 'plVDCHTD9P3G',
            apiKey: 'c24924da729a8f294c526051a0cd180f',
            container: this.$refs.address
          });

          console.log(placesAutocomplete)

          var $address = document.querySelector('#address-value')
          placesAutocomplete.on('change', function(e) {
            $address.textContent = e.suggestion.value
          });

          placesAutocomplete.on('clear', function() {
            $address.textContent = 'none';
          });


        } catch (e) {
          console.log(e)
        } finally {

        }

      }
    }
</script>
