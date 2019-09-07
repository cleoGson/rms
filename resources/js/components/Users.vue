<template>
    <div class="container">
       <div class="row mt-2">
       <div class="col-md-12"> 
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users table</h3>
              <div class="card-tools">
                <button class="btn btn-success"  data-toggle="modal" data-target="#addUser">
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
                  <th>Rendering engine</th>
                  <th>Browser</th>
                  <th>Platform(s)</th>
                  <th>Engine version</th>
                  <th>CSS grade</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td>Misc</td>
                  <td>Dillo 0.8</td>
                  <td>Embedded devices</td>
                  <td>-</td>
                  <td>
                  <a href="#"> <i class="fas fa-edit blue"></i> </a>/
                  <a href="#"> <i class="fas fa-trash red"></i> </a>
                  </td>
                </tr> 
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
        <!-- Modal -->
<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="createUser">
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
      <select v-model="form.gender" type="gender" name="gender" placeholder="Minimum 8 character"
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
        <button type="button" class="btn btn-primary blue">Create</button>
      </div>
      </form>
    </div>
  </div>
</div>
   
    </div>
</template>

<script>
    export default {
        data(){
            return {
            form: new Form({
            name : '',
            email : '',
            password : '',
            remember_token : false
                })
            }
        },
        methods: {
            createUser(){
                this.form.post('api/user');
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
