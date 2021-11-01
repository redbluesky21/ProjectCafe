<div class="text-left mb-3">
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus    "></i> Tambah Data</button>
    <button id="btnTrashKategori" class="btn btn-danger" wire:click="$emit('deleteAll')"><i class="fas fa-trash    "></i> Delete</button>
</div>

<div wire:ignore.self id="createModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Add Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true close-btn">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" wire:model="email" class="form-control" placeholder="Email...">
                        @error('email')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" wire:model="password" class="form-control" placeholder="Password...">
                        @error('password')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Confirmed Password</label>
                        <input type="password" wire:model="password_confirmation" class="form-control" placeholder="Password Confirmed...">
                        @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Users</label>
                        <input type="text" wire:model="name" class="form-control" placeholder="Nama Users...">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="roles_name">Roles</label><br>
                        @foreach ($roles as $data)
                            <input id="roles{{ $data->id }}" class="chooseRolesUsers" type="checkbox" wire:click ="$emit('chooseRoles')" value="{{ $data->id }}"> 
                            <label for="roles{{ $data->id }}">{{ $data->name }}</label><br>
                        @endforeach
                        @error('roles_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <button wire:click.prevent="store()" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary close-btn" data-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>