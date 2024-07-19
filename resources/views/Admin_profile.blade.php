 @include('common/header')

                <!-- Begin Page Content -->
                <div class="container-fluid">
                @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="p-1">
                        <div class="row">
                            <div class="col-md-6">
                                 <div class="card p-5">
                                    <div >
                                        <h1 class="h5 text-gray text-uppercase font-weight-bold">Update Information</h1>
                                    </div>
                                    <hr>
                                    <form action ="{{route('admin.updateInformation')}}" Method="POST" class="user">
                                        @csrf
                                            <input type="text" name="userId" class="form-control "
                                                placeholder="Enter User Id" value="{{ $admin->admin_id }}" hidden>
                                        <div class="form-group">
                                        <label for="" class="font-weight-bold"> Name</label>
                                            <input type="text" name="admin_name" class="form-control "
                                                placeholder="Enter User Id" value="{{ $admin->admin_name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold"> Email</label>
                                            <input type="text" name="admin_mail" class="form-control "
                                                placeholder="Enter User Id" value="{{ $admin->admin_mail }}" required>
                                        </div>
                                        <div class="form-group">
                                         <label for="" class="font-weight-bold"> Status</label>
                                                <select name="admin_status" class="form-control"  required>
                                                <option value="1" {{ $admin->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $admin->status == 0 ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary ">
                                                UPDATE 
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card p-5">
                                    <div >
                                        <h1 class="h5 text-gray text-uppercase font-weight-bold">Update Password</h1>
                                    </div>
                                    <hr>
                                    <form action ="{{route('admin.updatePassword')}}" Method="POST" >
                                        @csrf
                                            <input type="text" name="adminId" class="form-control "
                                                placeholder="Enter User Id" value="{{ $admin->admin_id }}" hidden>
                                        <div class="form-group">
                                        <label for="" class="font-weight-bold"> Password</label>
                                            <input type="password" name="password" class="form-control "
                                                placeholder="Enter Password " >
                                        </div>
                                        <div class="form-group">
                                            <label for="" class="font-weight-bold">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="form-control "
                                                placeholder="Enter Confirm Password" >
                                                @error('password')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                        </div>
                                       
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary ">
                                                UPDATE
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


   
    @include('common/footer')
  