<style>
	/* sheet size */
	@media print {
		#printStruk {
			width: 108mm;
			height: auto;
			margin: 0 auto;
		}
	}
</style>
<div class="page-content">
    <div class="page-title-box">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title mb-1">Cetak Struk</h4>
                    {{ Breadcrumbs::render('cetak') }}
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
                            <h5 class="header-title mb-0">CETAK STRUK</h5>
                        </div>
                        <div class="card-body" id="printStruk">
                            <div class="row">
                                <div class="col-lg-4 mx-auto">
                                    <div class="card w-100 border border-light shadow-sm"  style="position: relative;">
                                        <div class="card-body">
                                            <div class="text-center">
                                                <h6>De Orange Cafe</h6>
                                                <small>Sawojajar, Malang</small>
                                            </div>
                                          
                                            <div class="d-flex justify-content-between flex-wrap" style="font-size: 12px; margin-top:15px;">
                                                <table>
                                                    <tr>
                                                        <td>Kode</td>
                                                        <td>:</td>
                                                        <td>{{ $row->kode }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Customer</td>
                                                        <td>:</td>
                                                        <td>{{ $row->customer }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>TGL</td>
                                                        <td>:</td>
                                                        <td>{{ $row->tanggal_transaksi }}</td>
                                                    </tr>
                                                </table>
                                                <table>
                                                    <tr>
                                                        <td>Cashier</td>
                                                        <td>:</td>
                                                       <td>{{ HelperFunction::getUser($row->cashier_id)->name }}</td>
                                                       
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td >JAM</td>
                                                        <td>:</td>
                                                        <td>{{ $row->jam_transaksi }}</td>
                                                    </tr>
                                                </table>                                            
                                            </div>
                                            <div class="clearfix"></div>
                                            <hr style="border: 1px dashed #333;">
                                         <div class="table-responsive">
                                             <table class="table" style="font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th>Nama</th>
                                                        <th>Harga</th>
                                                        <th>Qty</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                $orderDetails = HelperFunction::orderDetails($row->id_orders);
                                                $qty = 0;
                                                $totalTransaksi = 0;
                                                ?>
                                                 @foreach ($orderDetails as $item)
                                                 <?php
                                                 $qty += $item->jumlah;
                                                 $totalTransaksi += ($item->jumlah * $item->harga);
                                                 ?>
                                                 <tr>
                                                     <td>{{ $item->nama }}</td>
                                                     <td>{{ number_format($item->harga,0,'.',',') }}</td>
                                                     <td>{{ $item->jumlah }}
                                                     <td>{{ number_format($item->jumlah * $item->harga,0,'.',',') }}</td>
                                                 </tr>
                                                 @endforeach
                                                </tbody>
                                             </table>
                                         </div>
                                         <hr style="border: 1px dashed #333; margin: 0; padding:0;">
                                         <div class="table-responsive mt-2 mb-2">
                                             <table class="w-100">
                                                <thead class="p-0">
                                                    <tr>
                                                        <td colspan="3" class="font-weight-bold p-1" style="font-size: 12px;" width="63%;">Qty</td>
                                                        <td class="font-weight-bold p-1" style="font-size: 12px;">{{ $qty }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Sub Total</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">{{ number_format($totalTransaksi,0,'.',',') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Disc Rp.</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">{{ number_format($row->discount,0,'.',',') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Pajak %</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">{{ $row->pajak }}</td>
                                                    </tr>
                                                </thead>
                                             </table>
                                         </div>
                                         <hr style="border: 1px dashed #333; margin: 0; padding:0;">
                                         <div class="table-responsive mt-2">
                                             <table class="w-100">
                                                <thead class="p-0">
                                                    <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Total</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">{{ number_format($row->total_harga,0,'.',',') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Bayar</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">{{ number_format($row->bayar,0,'.',',') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Kembalian</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">{{ number_format($row->kembalian,0,'.',',') }} </td>
                                                    </tr>
                                                </thead>
                                             </table>
                                         </div>
                                         <span class="w-100 btn btn-success mt-2 printStrukButton no-print" style="cursor: pointer;"><i class="fas fa-print    "></i> PRINT</span>
                                         @if ($laporan != null)
                                         <a href="/resto/laporan" class="w-100 btn btn-danger mt-2 no-print"><i class="fas fa-backward    "></i> KEMBALI</a>
                                         @else
                                         <a href="/resto/kasir" class="w-100 btn btn-danger mt-2 no-print"><i class="fas fa-backward    "></i> KEMBALI</a>
                                         @endif
                                        </div>
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
        $(document).on('click', '.printStrukButton', function(e) {
            e.preventDefault();
            $.print("#printStruk");
		})       
    })
</script>
@endpush