<div class="page-content">
    <div class="page-title-box">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="page-title mb-1">Kasir</h4>
                    {{ Breadcrumbs::render('kasir') }}
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
                            <h5 class="header-title mb-0">Data Kasir</h5>
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
                                @foreach ($result as $row)
                                <div class="col-lg-4">
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
                                                        @if ($row->cashier_id == null)
                                                        <td>
                                                            {{ HelperFunction::getUser($usersId)->name }}
                                                        </td>
                                                        @else
                                                        <td>
                                                            {{ HelperFunction::getUser($row->cashier_id)->nama }}
                                                        </td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td >JAM</td>
                                                        <td>:</td>
                                                        <td>20:00</td>
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
                                                    $subTotal = 0;
                                                    ?>
                                                    @foreach ($orderDetails as $item)
                                                    <?php
                                                    $qty += $item->jumlah;
                                                    $subTotal += $item->jumlah * $item->harga;
                                                    ?>
                                                    <tr>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>{{ number_format($item->harga,0,'.',',') }}</td>
                                                        <td>{{ $item->jumlah }}</td>
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
                                                        <td colspan="3" class="font-weight-bold p-1" style="font-size: 12px;" width="65%;">Qty</td>
                                                        <td class="font-weight-bold p-1" style="font-size: 12px;"><?=$qty;?></td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Sub Total</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">{{ number_format($subTotal,0,'.',',') }}</td>
                                                    </tr> --}}
                                                    {{-- <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Pajak %</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">
                                                            <input type="text" class="w-100 pajak_harga" placeholder="Pajak..." wire:change="$emit('pajak_harga',[{{ $row->total_harga }},$event.target.value])">    
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Disc Rp.</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">
                                                            <input type="text" class="w-100 discount_harga" placeholder="Discount..." wire:change="$emit('discount_harga',[{{ $row->total_harga }},$event.target.value])" >
                                                        </td>
                                                    </tr> --}}
                                                    
                                                </thead>
                                             </table>
                                         </div>
                                         {{-- <hr style="border: 1px dashed #333; margin: 0; padding:0;"> --}}
                                         <div class="table-responsive mt-2">
                                             <table class="w-100">
                                                <thead class="p-0">
                                                    <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Total</td>
                                                        <td class="font-weight-bold p-1 text-right total_transaksi" style="font-size: 12px;">{{ number_format($row->total_harga,0,'.',',') }}</td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Bayar</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">{{ number_format($row->bayar,0,'.',',') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="font-weight-bold p-1" style="font-size: 12px;">Kembalian</td>
                                                        <td class="font-weight-bold p-1 text-right" style="font-size: 12px;">{{ number_format($row->kembalian,0,'.',',') }}
                                                    </tr> --}}
                                                </thead>
                                             </table>
                                         </div>
                                         @if ($row->status_transaksi == 0)
                                         <a href="#" class="btn btn-success w-100 mt-2 bayar_transaksi" data-toggle="modal" data-target="#modalBayar" wire:click="transaksiProcess({{ $row->id_transaksi }})" data-id="{{ $row->id }}" data-total_harga="{{ $row->total_harga }}"><i class="fas fa-money-bill"></i> BAYAR</a>
                                         @else
                                         <span class="btn btn-success w-100 mt-2"><i class="fas fa-check-circle    "></i> SELESAI</span>
                                         @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
     <div wire:ignore.self class="modal fade" id="modalBayar" tabindex="-1" role="dialog" aria-labelledby="modalBayarLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-primary">
              <h5 class="modal-title text-white" id="modalBayarLabel"><i class="fas fa-money-bill    "></i> TRANSAKSI</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form wire:submit.prevent="saveTransaksi">
                <div class="modal-body">
                        <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Pajak % </label>
                            <div class="col-sm-9">
                                <input type="text" wire:change="$emit('pajak_harga',[{{ $total_transaksi }},$event.target.value])" class="form-control pajak_harga" placeholder="Pajak..." value="{{ number_format($pajak,0,'.',',') }}">
                                @error('pajak')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Discount Rp. </label>
                            <div class="col-sm-9">
                                <input type="text" wire:change="$emit('discount_harga',[{{ $total_transaksi }},$event.target.value])" class="form-control discount_harga" placeholder="Discount..." value="{{ number_format($discount,0,'.',',') }}">
                                @error('discount')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Sub Total</label>
                            <div class="col-sm-9">
                                <input readonly wire:model="sub_total_transaksi" type="text" class="form-control total_transaksi_save" placeholder="Subtotal..." value="{{ $total_transaksi }}">
                                @error('total_transaksi')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                         <hr style="border: 1px dashed #333; margin: 0; padding:0;">
                         <div class="form-group row mt-3">
                            <label for="customers" class="col-sm-3 col-form-label">Bayar</label>
                            <div class="col-sm-9">
                                <input  wire:change="$emit('bayar_harga',[{{ $total_transaksi }},$event.target.value])"  type="text" class="form-control bayar" placeholder="Bayar..." value="{{ number_format($bayar,0,'.',',') }}" required>
                                @error('bayar')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Total Transaksi</label>
                            <div class="col-sm-9">
                                <input readonly type="text" class="form-control total_transaksi" placeholder="Total Transaksi..." value="{{ number_format($total_transaksi,0,'.',',') }}">
                                @error('total_transaksi')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Kembalian</label>
                            <div class="col-sm-9">
                                <input readonly wire:model="kembalian" type="text" class="form-control kembalian" placeholder="Kembalian..." value="{{ number_format($kembalian,0,'.',',') }}">
                                @error('kembalian')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Bayar</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control bayar" placeholder="Bayar..." wire:change="$emit('bayarTransaksi',$event.target.value)" >
                                @error('bayar')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Kembalian</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" placeholder="Kembalian..." readonly value="{{ number_format($kembalian,0,'.',',') }}">
                                @error('kembalian')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                    </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-reset" data-dismiss="modal"><i class="fas fa-window-close    "></i> Close</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-save    "></i> Save</button>
                </div>
            </form>
          </div>
        </div>
      </div>
</div>
@push('script')
<script>
        new AutoNumeric('.discount_harga', {
            decimalCharacter : '.',
            digitGroupSeparator : ',',
            decimalPlaces:0,
        });
        new AutoNumeric('.pajak_harga', {
            decimalCharacter : '.',
            digitGroupSeparator : ',',
            decimalPlaces:0,
        });
        new AutoNumeric('.bayar', {
            decimalCharacter : '.',
            digitGroupSeparator : ',',
            decimalPlaces:0,
        });
        window.livewire.on('selectPaginate', ()  => {
            var val = $('.selectPaginate').val();
            window.livewire.emit('pagination',val);
        })
        window.livewire.on('transaksiStore', () => {
                    $('#modalBayar').modal('hide');
                    $('.modal-backdrop').hide();
                });
        window.livewire.on('resetForm', () => {
            $('form').trigger("reset");
        });
        window.livewire.on('discount_harga', (val)  => {
                window.livewire.emit('handlerDiscountHarga',val);
            })
        window.livewire.on('pajak_harga', (val)  => {
            window.livewire.emit('handlerPajakHarga',val);
        })
        window.livewire.on('bayar_harga', (val)  => {
            var bayar = val[1];
            var result = bayar.split(',').join('');
            if(result < val[0]){
                alert('Pembayaran kecil dari total harga');
                $('.bayar').val(0).trigger('change');
            } else {
                window.livewire.emit('handleBayarHarga',val);
            }
        })
        $(document).on('click','.bayar_transaksi',function(){
            Livewire.emit('resetFormTransaksi');
            $('form').trigger("reset");

            var id = $(this).data('id');
            var total_harga = $(this).data('total_harga');

            $('.total_transaksi').val(number_format(total_harga));
            Livewire.emit('handleTotalTransaksi',[id,total_harga]);
        })
        $(document).on('click','.btn-reset',function(){
            Livewire.emit('resetFormTransaksi');
            $('form').trigger("reset");
        })
        function number_format(number, decimals, dec_point, thousands_sep) {
            // Strip all characters but numerical ones.
            number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function(n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }
</script>
@endpush