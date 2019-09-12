<template>
<section class="content">
    <div class="row">
       <div class="col-md-12"> 
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users table</h3>
              <div class="card-tools">
                <button class="btn btn-success"  @click="newModel">
                 Add New
                 <i class="fas fa-user-plus fa-fw"></i>
                  </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>#NO</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Gender</th>
                  <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users.data" :key="user.id"> 
                  <td>{{user.id}}</td>
                  <td>{{user.name|upperText}}</td>
                  <td>{{user.email}}</td>
                  <td>{{user.gender}}</td>
                  <td>
                  <a href="#" @click="editModel(user)"> <i class="fas fa-edit blue"></i> </a>/
                  <a href="#" @click="deleteUser(user.id)"> <i class="fas fa-trash red"></i> </a>
                  </td>
                </tr> 
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer"> 
              <pagination :data="users" @pagination-change-page="getResults">
                
              </pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <!-- Modal -->
<div class="modal fade"   data-toggle="modal" data id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"  v-show="!editmode" id="exampleModalLabel">Add User</h5>
        <h5 class="modal-title" v-show="editmode" id="exampleModalLabel">Update User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="editmode ? updateUser() : createUser()">
      <div class="modal-body">
       
     <div class="form-group">
      <label>name</label>
      <input v-model="form.name" type="text" name="name" placeholder="Enter name"
        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
    </div>
      <div class="form-group">
      <label>Email</label>
      <input v-model="form.email" type="email" name="email" placeholder="Enter valid email"
        class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
      <has-error :form="form" field="email"></has-error>
    </div>
    <div class="form-group">
      <label>Gender</label>
      <select v-model="form.gender" type="text" name="gender"
        class="form-control" :class="{ 'is-invalid': form.errors.has('gender') }">
        <option value=""> Select Gender</option>
        <option value="Male"> Male </option>
        <option value="Female"> Female </option>
        </select>

      <has-error :form="form" field="password"></has-error>
    </div>

    <div class="form-group">
      <label>Password</label>
      <input v-model="form.password" type="password" name="password" placeholder="Minimum 8 character"
        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
      <has-error :form="form" field="password"></has-error>
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
            users: {},
            form: new Form({
            id: '',
            name : '',
            gender: '',
            email : '',
            password : '',
            remember_token : false
                })
            }
        },
        methods: {
           getResults(page = 1) {
            axios.get('api/user?page=' + page)
              .then(response => {
                this.users = response.data;
              });
              },
             editModel(user){
              this.editmode = true;
              this.form.clear();
              this.form.reset();
              $('#addUser').modal('show');
              this.form.fill(user);
            },
            newModel(){
              this.editmode = false;
              this.form.clear();
              this.form.reset();
              $('#addUser').modal('show');
            },
            loadUsers(){
          axios.get('api/user').then(({data})=>(this.users = data));
            },
            deleteUser(id){
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
                        this.form.delete('api/user/'+id).then(()=>{
                            Swal.fire(
                            'Deleted!',
                            'User has been deleted.',
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
            //creating User
            createUser(){
                this.$Progress.start();
                this.form.post('api/user')
                .then(()=>{
                Fire.$emit('afterCreate');
                $('#addUser').modal('hide');
                toast.fire({
                type: 'success',
                title: 'User created  successfully'
                });
                 this.$Progress.finish();
                })
                .catch(()=>{
                  this.$Progress.fail();
                });
              
                
            },
            //editing User
            updateUser(){
              this.$Progress.start();
              this.form.put('api/user/'+this.form.id)
              .then(()=>{
              $('#addUser').modal('hide');
              Swal.fire(
                        'Updated!',
                        'User has been Updated.',
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
                this.loadUsers();
                Fire.$on('afterCreate',()=>{
                this.loadUsers();
                });
                //setInterval(()=>this.loadUsers(),3000);
            },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
