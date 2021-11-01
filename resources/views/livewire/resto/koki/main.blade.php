
<div class="page-content">
    <div class="page-title-box">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title mb-1">Koki</h4>
                    {{ Breadcrumbs::render('koki') }}
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
                            <h5 class="header-title mb-0">Data Koki</h5>
                        </div>
                        <div class="card-body">
                            @if(session()->has('message'))
                                <div class="alert alert-success">{{ session('message') }}</div>
                            @endif
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="float-left" style="width:10%;">
                                        <select wire:change="$emit('selectPaginate')" class="form-control selectPaginate" id="">
                                            <option value="">Show</option>
                                            <option value="6">6</option>
                                            <option value="12">12</option>
                                            <option value="18">18</option>
                                            <option value="24">24</option>
                                            <option value="30">30</option>
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
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th class="text-center">Tanggal / Waktu</th>
                                                    <th>Menu Pesanan</th>
                                                    <th>Jumlah Pesanan</th>
                                                    <th>Customer</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no =1;?>
                                                @foreach ($result as $row)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-between">
                                                            <span>
                                                                {{ $row->tanggal_transaksi }} 
                                                            </span>
                                                            <span>
                                                                {{ $row->jam_transaksi }}
                                                            </span>
                                                        </div>
                                                     </td>
                                                    <td>
                                                        <?php 
                                                        $order_details = (HelperFunction::orderDetails($row->id_orders));
                                                        $qty = 0;
                                                        ?>
                                                        <ul>
                                                        @foreach ($order_details as $item)
                                                            <li>{{ $item->nama }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $order_details = (HelperFunction::orderDetails($row->id_orders));
                                                        $qty = 0;
                                                        ?>
                                                        <ul>
                                                        @foreach ($order_details as $item)
                                                            <li>{{ $item->jumlah }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        {{ $row->customer }}
                                                    </td>
                                                    <td>
                                                        @if ($row->status_order == 0)
                                                        <div class="badge badge-warning">Menunggu Diproses</div>
                                                        @elseif($row->status_order == 1)
                                                        <div class="badge badge-info">Proses...</div>
                                                        @elseif($row->status_order == 2)
                                                        <div class="badge badge-success">Selesai</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($row->status_order == 0)
                                                        <button class="btn btn-info w-100" wire:click="orderIdSave({{ $row->id_orders }})"><i class="fas fa-paper-plane"></i> PROCESS</button>
                                                        @elseif($row->status_order == 1)
                                                        <button class="btn btn-success w-100"  wire:click="orderIdSaveEnd({{ $row->id_orders }})"><i class="fas fa-check-circle    "></i>SELESAI</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <smal class="text-secondary" style="font-size: 12px;">{{ $rows }} Rows Table</smal><br>
                                    {{ $result->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->        
          </div> <!-- container-fluid -->
      </div>

     <!-- Modal -->
     {{-- <div wire:ignore.self class="modal fade" id="modalProses" tabindex="-1" role="dialog" aria-labelledby="modalProsesLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h5 class="modal-title text-white" id="modalProsesLabel"><i class="fas fa-money-bill    "></i> PROSES PESANAN</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form wire:submit.prevent="saveProses">
                <div class="modal-body">
                    <span>Apakah anda yakin ingin <strong>proses</strong> menu pesanan ini?</span>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close    "></i> Close</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-save    "></i> Save</button>
                </div>
            </form>
          </div>
        </div>
      </div> --}}

     <!-- Modal -->
     {{-- <div wire:ignore.self class="modal fade" id="modalSelesaiKoki" tabindex="-1" role="dialog" aria-labelledby="modalSelesaiKokiLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h5 class="modal-title text-white" id="modalSelesaiKokiLabel"><i class="fas fa-check-circle    "></i> SELESAI</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form wire:submit.prevent="saveSelesaiProses">
                <div class="modal-body">
                    <span>Apakah orderan ini sudah <strong>selesai</strong>?</span>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close    "></i> Close</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-save    "></i> Save</button>
                </div>
            </form>
          </div>
        </div>
      </div> --}}
</div>
@push('script')
<script>
     window.livewire.on('selectPaginate', ()  => {
            var val = $('.selectPaginate').val();
            window.livewire.emit('pagination',val);
        })
        window.livewire.on('kokiStore', () => {
                    $('#modalProses').modal('hide');
                    $('.modal-backdrop').hide();
                });
        window.livewire.on('kokiStoreSelesai', () => {
                    $('#modalSelesaiKoki').modal('hide');
                    $('.modal-backdrop').hide();
                });
</script>
@endpush