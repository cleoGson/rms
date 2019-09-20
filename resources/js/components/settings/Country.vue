<template>
<section class="content">
    <div class="row">
       <div class="col-md-12"> 
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of Countries</h3>
              <div class="card-tools">
                <button class="btn btn-success"  @click="newModel">
                 Add New
                 <i class="fas fa-plus fa-fw"></i>
                  </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#NO</th>
                  <th>Coutry code</th>
                  <th>Name</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="country in countries.data" :key="country.id"> 
                  <td>{{country.id}}</td>
                  <td>{{country.name|upperText}}</td>
                  <td>{{country.code}}</td>
                  <td>
                  <a href="#" @click="editModel(country)"> <i class="fas fa-edit blue"></i> </a>/
                  <a href="#" @click="deletecountry(country.id)"> <i class="fas fa-trash red"></i> </a>
                  </td>
                </tr> 
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer"> 
              <pagination :data="countries" @pagination-change-page="getResults">
                
              </pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <!-- Modal -->
<div class="modal fade"   data-toggle="modal" data id="addcountry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  v-show="!editmode" id="exampleModalLabel">Add country</h5>
        <h5 class="modal-title" v-show="editmode" id="exampleModalLabel">Update country Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updatecountry() : createcountry()">
      <div class="modal-body">
       
     <div class="form-group">
      <label>name</label>
      <input v-model="form.name" type="text" name="name" placeholder="Enter name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
    </div>
      <div class="form-group">
      <label>code</label>
      <input v-model="form.code" type="code" name="code" placeholder="Enter valid code"
        class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
      <has-error :form="form" field="code"></has-error>
    </div>       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" v-show="editmode" class="btn btn-primary blue">update</button>
        <button type="submit" v-show="!editmode" class="btn btn-primary blue">Create</button>

      </div>
      </form>
    </div>
  </div>
</div>
</div>
</section>
</template>

<script>
    export default {
        data(){
          
            return {
            editmode:true,
            countries: {},
            form: new Form({
            id: '',
            name : '',
            code : '',
                })
            }
        },
        methods: {
           getResults(page = 1) {
            axios.get('api/country?page=' + page)
              .then(response => {
                this.countries = response.data;
              });
              },
             editModel(country){
              this.editmode = true;
              this.form.clear();
              this.form.reset();
              $('#addcountry').modal('show');
              this.form.fill(country);
            },
            newModel(){
              this.editmode = false;
              this.form.clear();
              this.form.reset();
              $('#addcountry').modal('show');
            },
            loadcountries(){
          axios.get('api/country').then(({data})=>(this.countries = data));
            },
            deletecountry(id){
                  Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if(result.value){
                        this.form.delete('api/country/'+id).then(()=>{
                            Swal.fire(
                            'Deleted!',
                            'country has been deleted.',
                            'success'
                            )
                      Fire.$emit('afterCreate');      
                     }).catch(()=>{
                          Swal('Failed!',
                          'Something went Wrong',
                          'warning');
                        });
                        }
                    })
            },
            //creating country
            createcountry(){
                this.$Progress.start();
                this.form.post('api/country')
                .then(()=>{
                Fire.$emit('afterCreate');
                $('#addcountry').modal('hide');
                toast.fire({
                type: 'success',
                title: 'country created  successfully'
                });
                 this.$Progress.finish();
                })
                .catch(()=>{
                  this.$Progress.fail();
                });
              
                
            },
            //editing country
            updatecountry(){
              this.$Progress.start();
              this.form.put('api/country/'+this.form.id)
              .then(()=>{
              $('#addcountry').modal('hide');
              Swal.fire(
                        'Updated!',
                        'country has been Updated.',
                        'success'
                        );
              this.$Progress.finish();
              })
              .catch(()=>{
                Swal('Failed!',
                     'Something went Wrong',
                     'warning');
              });
    
            }

        },
          created(){
                this.loadcountries();
                Fire.$on('afterCreate',()=>{
                this.loadcountries();
                });
                //setInterval(()=>this.loadcountries(),3000);
            },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
