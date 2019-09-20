<template>
<section class="content">
    <div class="row">
       <div class="col-md-12"> 
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of regions</h3>
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
                <tr v-for="region in regions.data" :key="region.id"> 
                  <td>{{region.id}}</td>
                  <td>{{region.name|upperText}}</td>
                  <td>{{region.code}}</td>
                  <td>
                  <a href="#" @click="editModel(region)"> <i class="fas fa-edit blue"></i> </a>/
                  <a href="#" @click="deleteregion(region.id)"> <i class="fas fa-trash red"></i> </a>
                  </td>
                </tr> 
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer"> 
              <pagination :data="regions" @pagination-change-page="getResults">
                
              </pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <!-- Modal -->
<div class="modal fade"   data-toggle="modal" data id="addregion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  v-show="!editmode" id="exampleModalLabel">Add region</h5>
        <h5 class="modal-title" v-show="editmode" id="exampleModalLabel">Update region Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateregion() : createregion()">
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
    <select v-model="form.country_id" type="text" name="country_id"
        class="form-control" :class="{ 'is-invalid': form.errors.has('country_id') }">
        <option v-for="country in countries.data" :key="country.id" > {{ country.name }} </option>
        </select>    
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
            regions: {},
            form: new Form({
            id: '',
            name : '',
            code : '',
            country_id:'',
                }),

          countries: {},
            }
    
        },
        methods: {
          
           getResults(page = 1) {
            axios.get('api/region?page=' + page)
              .then(response => {
                this.regions = response.data;
              });
              },
             editModel(region){
              this.editmode = true;
              this.form.clear();
              this.form.reset();
              $('#addregion').modal('show');
              this.form.fill(region);
            },
            newModel(){
              this.editmode = false;
              this.form.clear();
              this.form.reset();
              $('#addregion').modal('show');
            },
            loadCountries(){
          axios.get('api/country').then(({data})=>(
              this.countries = data));
            },
            loadregions(){
          axios.get('api/region').then(({data})=>(this.regions = data));
            },
            deleteregion(id){
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
                        this.form.delete('api/region/'+id).then(()=>{
                            Swal.fire(
                            'Deleted!',
                            'region has been deleted.',
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
            //creating region
            createregion(){
                this.$Progress.start();
                this.form.post('api/region')
                .then(()=>{
                Fire.$emit('afterCreate');
                $('#addregion').modal('hide');
                toast.fire({
                type: 'success',
                title: 'region created  successfully'
                });
                 this.$Progress.finish();
                })
                .catch(()=>{
                  this.$Progress.fail();
                });
              
                
            },
            //editing region
            updateregion(){
              this.$Progress.start();
              this.form.put('api/region/'+this.form.id)
              .then(()=>{
              $('#addregion').modal('hide');
              Swal.fire(
                        'Updated!',
                        'region has been Updated.',
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
                this.loadCountries();
                this.loadregions();
                Fire.$on('afterCreate',()=>{
                this.loadregions();
                });
                //setInterval(()=>this.loadregions(),3000);
            },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
