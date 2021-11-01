<div class="page-content">
    <div class="page-title-box">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title mb-1">Laporan</h4>
                    {{ Breadcrumbs::render('laporan') }}
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
                            <h5 class="header-title mb-0">Data Laporan</h5>
                        </div>
                        <div class="card-body">
                        @if(session()->has('message'))
                            <div class="alert alert-success">{{ session('message') }}</div>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="float-left" style="width:10%;">
                                    <select wire:change="$emit('selectPaginate')"  class="form-control selectPaginate" id="">
                                        <option value="">-- Pagination --</option>
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
                        <form wire:submit.prevent="handleTanggal">
                            <div class="row mb-3">
                                    <div class="col-lg-3">
                                        <input wire:model="start_date" type="date" data-date="" data-date-format="YYYY-MM-DD" class="form-control" placeholder="Dari Tanggal...">
                                    </div>
                                    <div class="col-lg-3">
                                        <input wire:model="end_date" type="date" data-date="" data-date-format="YYYY-MM-DD" class="form-control" placeholder="Sampai Tanggal...">
                                    </div>
                                    {{-- <div class="col-lg-3">
                                        <button type="submit" class="btn btn-info"><i class="fas fa-search    "></i></button>
                                    </div> --}}
                            </div>
                        </form>
                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <a href="#" class="btn btn-dark shadow-sm printStrukButton"><i class="fas fa-print    "></i> PRINT</a>
                            </div>
                        </div>
                        <div id="printStruk">
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="text-center">
                                        <h2>Laporan Transaksi Penjualan</h2>
                                    </div>
                                </div>
                            </div>
                            @if ($start_date != null && $end_date != null)
                            <div class="row mb-3">
                                <div class="col-lg-12">
                                    <div class="text-center">
                                        <strong>Tanggal : {{ $start_date }} s/d {{ $end_date }}</strong>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <hr style="border: 2px dashed #ccc;">
                            <div class="table-responsive">
                                <table class="table mb-0 table-striped table-bordered" id="tabletransaksi">
                                    <thead>
                                        <tr>
                                          <th>Kode</th>
                                          <th>Tgl / Waktu</th>
                                          <th width="20%;">Users</th>
                                          <th>Pajak</th>
                                          <th>Discount</th>
                                          <th>Total Harga</th>
                                          <th width="180px;" class="text-center no-print">Action</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($result as $row)
                                          <tr>
                                              <td>{{ $row->kode }}</td>
                                              <td>{{ $row->tanggal_transaksi }} <br> {{ $row->jam_transaksi }}</td>
                                              <td>
                                                  <small>
                                                      Customer : {{ $row->customer }} <br>
                                                      Pelayan : {{ HelperFunction::getUser($row->pelayan_id)->name }}<br>
                                                      Koki : {{ HelperFunction::getUser($row->koki_id)->name }}<br>
                                                      Kasir : {{ HelperFunction::getUser($row->cashier_id)->name }}<br>
                                                  </small>
                                              </td>
                                              <td>{{ $row->pajak }}</td>
                                              <td>Rp. {{ number_format($row->discount,0,'.',',') }}</td>
                                              <td>Rp. {{ number_format($row->total_harga,0,'.',',') }}</td>
                                              <td class="text-center no-print">
                                                  <a href="/resto/cetak?id_transaksi={{ $row->id_transaksi }}&laporan=y" class="btn btn-primary btn-sm" target="_blank"><i class="fas fa-print    "></i> PRINT</a>
                                                  <a href="#" wire:click.prevent="deleteTransaksi({{ $row->id_orders }})" class="btn btn-danger btn-sm"><i class="fas fa-trash    "></i> HAPUS</a>
                                              </td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                                  <tfoot>
                                      <tr>
                                          <td colspan="5"> <strong>Total Harga</strong> </td>
                                          <td><strong>Rp. <?=number_format($total_harga,0,'.',',');?></strong> </td>
                                      </tr>
                                  </tfoot>
                              </table>
                            </div>                                
                            <div class="row no-print">
                                <div class="col-lg-12">
                                    
                                    <smal class="text-secondary" style="font-size: 12px;">{{ $rows }} Rows Table</smal><br>
                                    {{ $result->links() }}
                                </div>
                            </div>
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
            window.livewire.on('selectPaginate', ()  => {
                var val = $('.selectPaginate').val();
                window.livewire.emit('pagination',val);
            })
            $(document).on('click', '.printStrukButton', function(e) {
                e.preventDefault();
                $.print("#printStruk");
            })   
        })
    </script>
@endpush