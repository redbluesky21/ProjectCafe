<div class="page-content">
    <div class="page-title-box">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title mb-1">Profile</h4>
                    {{ Breadcrumbs::render('profile') }}
                </div>
            </div>    
        </div>
    </div>
    <div class="page-content-wrapper">
        <div class="container-fluid">        
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header bg-transparent p-3">
                            <h5 class="header-title mb-0">My Profile</h5>
                        </div>
                        <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif
                        @include('livewire.resto.user.update')
                        
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped table-bordered" id="tableusersmanagement">
                                    <thead>
                                        <tr>
                                          <th>Email</th>
                                          <th>Nama Users</th>
                                          <th>Roles</th>
                                          <th width="200px;" class="text-center">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                        <tr>
                                            <td>
                                                {{ $row->email }}
                                            </td>
                                            <td>
                                            {{ $row->name }}
                                            </td>
                                            <td>
                                                {{ implode(',',$row->roles()->get()->pluck('name')->toArray()) }}
                                            </td>
                                            <td class="text-center">
                                            <button data-toggle="modal" data-target="#updateModal" class="btn btn-primary btn-sm" wire:click="edit"><i class="fas fa-pencil-alt    "></i> Edit</button>
                                            </td>
                                        </tr>
                                  </tbody>
                              </table>
                            </div>
                        </div>
                    </div>
                  </div>
            </div>
            <!-- end row -->        
          </div> <!-- container-fluid -->
      </div>
</div>

@push('script')
    <script>
        $(document).ready(function(){
            window.livewire.on('chooseRoles', ()  => {
                var allVals = [];
                $('.chooseRolesUsers:checked').each(function() {
                    allVals.push($(this).val());
                });
                window.livewire.emit('fileChoosenHandler',allVals);
            })
            window.livewire.on('userStore', () => {
                $('#updateModal').modal('hide');
                $('.modal-backdrop').hide();
            });
        })        
    </script>
@endpush