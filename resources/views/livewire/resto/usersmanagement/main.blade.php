<div class="page-content">
    <div class="page-title-box">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title mb-1">Sub Kategori</h4>
                    {{ Breadcrumbs::render('usersmanagement') }}
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
                            <h5 class="header-title mb-0">Data Sub Kategori</h5>
                        </div>
                        <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif
                        @include('livewire.resto.usersmanagement.create')
                        @include('livewire.resto.usersmanagement.update')
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="float-left" style="width:10%;">
                                    <select wire:change="$emit('selectPaginate')" class="form-control selectPaginate" id="">
                                        <option value="">Show</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                                <div class="w-25 float-right">
                                    <div class="form-group">
                                        <input type="text" placeholder="Search..." wire:model="search" class="form-control">
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped table-bordered" id="tableusersmanagement">
                                    <thead>
                                        <tr>
                                            <th width="100px">
                                                <div class="custom-control custom-checkbox custom-control-inline">
                                                    <input type="checkbox" class="custom-control-input" id="check_all_usersmanagement">
                                                  <label class="custom-control-label" for="check_all_usersmanagement"></label>
                                              </div>
                                          </th>
                                          <th>Email</th>
                                          <th>Nama Users</th>
                                          <th>Roles</th>
                                          <th width="200px;" class="text-center">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($result as $index=> $row)
                                          <tr>
                                              <td>
                                                  <div class="custom-control custom-checkbox custom-control-inline">
                                                      <input type="checkbox" class="custom-control-input check_item_usersmanagement" id="checkItemusersmanagement{{ $index }}" value="{{ $row->id }}">
                                                      <label class="custom-control-label" for="checkItemusersmanagement{{ $index }}"></label>
                                                  </div>
                                              </td>
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
                                                <button data-toggle="modal" data-target="#updateModal" class="btn btn-primary btn-sm" wire:click="edit({{ $row->id }})"><i class="fas fa-pencil-alt    "></i> Edit</button>
                                                <button wire:click="delete({{ $row->id }})" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt    "></i> Delete</button>
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                            </div>
                            <div class="mt-3">
                                <smal class="text-secondary" style="font-size: 12px;">{{ $rows }} Rows Table</smal><br>
                                {{ $result->links() }}
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
            window.livewire.on('selectPaginate', ()  => {
                var val = $('.selectPaginate').val();
                window.livewire.emit('pagination',val);
            })
            
            window.livewire.on('usersmanagementStore', () => {
                $('#createModal').modal('hide');
                $('#updateModal').modal('hide');
                $('.modal-backdrop').hide();
                $('form').trigger('reset');
            });
            $(document).on('click','#check_all_usersmanagement',function(){
                if($(this).is(':checked')){
                    $('.check_item_usersmanagement').prop('checked',true);
                } else {
                    $('.check_item_usersmanagement').prop('checked',false);
                }
            })
            $(document).on('click','.check_item_usersmanagement',function(){
                if($('.check_item_usersmanagement').length == $('.check_item_usersmanagement:checked').length){
                    $('#check_all_usersmanagement').prop('checked',true);
                } else {
                    $('#check_all_usersmanagement').prop('checked',false);
                }
            })
            window.livewire.on('deleteAll', ()  => {
                var allVals = [];
                $('.check_item_usersmanagement:checked').each(function() {
                    allVals.push($(this).val());
                });
                window.livewire.emit('deleteAllusersmanagement',allVals);
            })
        })
        
    </script>
@endpush