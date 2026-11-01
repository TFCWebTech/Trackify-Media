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

                    @if($errors->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ $errors->first('error') }}
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
                                    <form action="{{ route('reporter.updateReporterInformation') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                                <div class="form-group">
                                    <label for="user_name" class="font-weight-bold">Name</label>
                                    <input type="text" name="user_name" class="form-control" placeholder="Enter User Name" value="{{ $user->user_name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_email" class="font-weight-bold">Email</label>
                                    <input type="email" name="user_email" class="form-control" placeholder="Enter User Email" value="{{ $user->user_email }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="user_status" class="font-weight-bold">Status</label>
                                    <select name="user_status" class="form-control" required>
                                        <option value="1" {{ $user->user_status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $user->user_status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">UPDATE</button>
                                </div>
                            </form>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card p-5">
                                    <div>
                                        <h1 class="h5 text-gray text-uppercase font-weight-bold">Update Password</h1>
                                    </div>
                                    <hr>
                                    <form action ="{{route('reporter.updateReporterPassword')}}" Method="POST" >
                                        @csrf
                                            <input type="text" name="adminId" class="form-control "
                                                placeholder="Enter User Id" value="{{ $user->user_id }}" hidden>
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
  