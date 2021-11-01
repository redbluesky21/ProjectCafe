<div>
    <style>
        .owl-carousel .item{
            border: 1px solid #909090;
            border-radius: 7px;
            padding: 8px;
            text-align: center;
            background-color: #3e3e3e;
            box-shadow: 3px 5px 10px rgba(0, 0, 0, 0.2);
        }
        .owl-carousel .item h4{
            color: #fff;
        }
        .owl-nav{
            text-align: center;
            position: relative;
        }
        .owl-nav button.owl-next{
          position: absolute;
          right: 5px;
          top:-37px;
          width:20px !important;
          height:20px !important;
          background-color:  #f06543 !important;
          color: #fff !important;
          border-radius: 50%;
        }
        .owl-nav button.owl-prev{
          position: absolute;
          left: 5px;
          top:-37px;
          width:20px !important;
          height:20px !important;
          background-color:  #f06543 !important;
          color: #fff !important;
          border-radius: 50%;
        }
        .scrolls {
            overflow-x: scroll;
            overflow-y: hidden;
            height: 70px;
            white-space:nowrap;
            width: 100%;
        }
        .scrolls div{
            display: inline-block;
            border: 1px solid #909090;
            border-radius: 7px;
            padding: 8px 18px;
            text-align: center;
            background-color: #3e3e3e;
            box-shadow: 3px 5px 10px rgba(0, 0, 0, 0.2);
        }
        .column-transaksi{
            transition: 0.5s ease;
        }
        .scrolls div h4{
            color: #fff;
        }
        @media (max-width: 1200px) { 
            .btn-auth-user{
                transform: translateX(35%) !important;
                left:55% !important;
            }
        }
        @media (max-width: 699px) { 
            .btn-auth-user{
                transform: translateX(35%) !important;
                left:40% !important;
            }
        }
        @media (max-width: 576px) { 
            .btn-auth-user{
                display: none;
            }
            .btn-pesanan{
                left:45% !important;
            }
            span.pos-resto{
                display: none;
            }
            .column-transaksi{
                display: none;
            }
        }
    </style>
    <div class="container-fluid" style="background: #f1f1f1;">
        <div class="row p-2" style="background: #f57f30;">
            <div class="col-lg-12">
                <a href="{{ route('resto.home') }}" class="text-white font-weight-bold text-uppercase" style="font-size: 24px;"><i class="fas fa-cart-plus"></i> <span class="pos-resto">Pos Resto</span> </a>
                {{-- <a href="#" style="position: absolute; left:50%; transform: translateX(50%);" class="btn btn-danger text-white font-weight-bold" data-toggle="modal" data-target="#modalShowHold"> HOLD</a> --}}
                <a href="#" style="position: absolute; left:63%; transform: translateX(45%);" class="btn btn-danger text-white font-weight-bold btn-auth-user"><i class="fas fa-user"></i> {{  $authUser }}</a>
                <a href="#" style="position: absolute; left:73%; transform: translateX(50%);" class="btn btn-danger text-white font-weight-bold btn-pesanan" data-toggle="modal" data-target="#modalShowTransaksi"><i class="fas fa-cart-plus    "></i> Pesanan <span class="badge badge-warning">{{ $cartTotal }}</span> </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 py-3 px-2">
                @if(session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif
            </div>
            <div class="col-lg-8 py-2">
                <div class="d-flex justify-content-between">
                    <select wire:change="$emit('selectPaginate')" name="" class="form-control selectPaginate" id="" style="width:100px;">
                        <option value="">Show</option>
                        <option value="8">8</option>
                        <option value="12">12</option>
                        <option value="16">16</option>
                        <option value="20">20</option>
                        <option value="24">24</option>
                    </select>
                    <input type="text" class="form-control w-25" placeholder="Search..." wire:model="search">
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="text-uppercase">
                            <div class="scrolls">
                                
                                @if ($isKategori)
                                    <div style="cursor: pointer" wire:click="$emit('subKategori',null)">
                                        <h4>
                                            All
                                        </h4>
                                    </div>
                                    @foreach ($result as $row)
                                    <div style="cursor: pointer" wire:click="$emit('subKategori',{{ $row->id }})">
                                        <h4>
                                            {{ $row->nama }}
                                        </h4>
                                    </div>
                                    @endforeach
                                @else
                                    <div style="cursor: pointer" wire:click="$emit('backwardKategori')">
                                        <h4>
                                            <i class="fas fa-backward    "></i> Kembali
                                        </h4>
                                    </div>
                                    @foreach ($result as $row)
                                    <div style="cursor: pointer" wire:click="$emit('menuPesanan',{{ $row->id }})">
                                        <h4>
                                            {{ $row->nama }}
                                        </h4>
                                    </div>
                                    @endforeach
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    @foreach ($menu as $row)
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="card bg-white" style="cursor: pointer;" wire:click="addToCart({{ $row->id }})">
                                <div class="card-body p-2">
                                    <img src="{{ $row->imagePath }}" class="w-100" height="150px;" alt="">
                                    <span class="text-justify" style="font-size:14px;">{{ $row->nama }}</span>
                                    <span href="#" class="badge badge-danger px-2 py-1" style="position: absolute; top: 9px;right: 8px;font-size:14px;">Rp. {{ number_format($row->harga,2,',','.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row" style="margin-top:-25px;">
                    <div class="col-lg-12">
                        <smal class="text-secondary" style="font-size: 12px;">{{ $rows }} Rows Table</smal><br>
                        {{ $menu->links() }}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 border border-blue bg-white py-3 px-2 column-transaksi">
                <div class="table-responsive" style="height: 400px; overflow-y: scroll;">
                    <table class="w-100">
                        <thead>
                            <tr>
                                <th width="150px;">Product</th>
                                <th width="150px;" class="text-center">Qty</th>
                                <th class="text-right" width="140px;">Price</th>
                            </tr>
                        </thead>
                        <tbody class="border-top border-bottom">
                           @foreach ($cartGet['menu'] as $row)
                           <tr>
                                <td class=" p-2">{{ $row['nama'] }}</td>
                                <td class="text-center  p-2">
                                    <input class="inputCountCart" type="number" style="width:50px;" value="{{ $row['jumlah'] }}" wire:change="$emit('inputCountCart',[{{ $row['id'] }}, $event.target.value])">
                                    <a href="#" class="btn btn-danger btn-sm" wire:click="removeItem({{ $row['id'] }})"><i class="fas fa-trash-alt"></i></a>
                                </td>
                                <td class="text-right  p-2">Rp {{ number_format($row['harga'] * $row['jumlah'],2,'.',',') }}</td>
                            </tr>
                           @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table class="w-100 wire:ignore.self">
                        {{-- <tr>
                            <td class="p-2" colspan="2">Subtotal</td>
                            <td class="text-right pt-2">Rp. {{ number_format($total_transaksi,2,'.',',') }}</td>
                        </tr>
                        <tr>
                            <td class="p-2" colspan="2">Pajak</td>
                            <td width="150px;" class="text-right pt-2">% <input type="text" class="w-75 pajak_harga" placeholder="Pajak..." wire:change="$emit('pajak_harga',[{{ $total_transaksi }},$event.target.value])"></td>
                        </tr>
                        <tr>
                            <td class="p-2" colspan="2">Discount</td>
                            <td width="150px;" class="text-right pt-2">Rp. <input type="text" class="w-75 discount_harga" placeholder="Discount..." wire:change="$emit('discount_harga',[{{ $total_transaksi }},$event.target.value])" ></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr> --}}
                        <tr style="border:2px solid green;" class="font-weight-bold">
                            <td class="p-2" colspan="2">Total</td>
                            <td width="150px;" class="text-right pt-2">Rp.
                                {{ number_format($total_transaksi,2,'.',',') }}
                            </td>
                        </tr>
                    </table>
                </div>
                <hr style="border: 1px solid #c5c5c5;">
                <div class="row">
                    <div class="col-lg-12">
                        {{-- <a href="#" class="btn btn-danger font-weight-bold text-uppercase w-100" data-toggle="modal" data-target="#modalHold"><i class="fas fa-hand-holding    "></i> HOLD</a> --}}
                        <a href="#" class="btn btn-success font-weight-bold text-uppercase w-100 mt-2"  data-toggle="modal" data-target="#modalPesanan">
                            <i class="fas fa-money-bill    "></i> Pesan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
      
      <!-- Modal -->
      <div wire:ignore.self class="modal fade" id="modalPesanan" tabindex="-1" role="dialog" aria-labelledby="modalPesananLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-warning">
              <h5 class="modal-title text-white" id="modalPesananLabel"><i class="fas fa-money-bill    "></i> PESANAN</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form wire:submit.prevent="savePos">
                <div class="modal-body">
                        <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Kode Transaksi</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Kode Transaksi..." value="{{ $kode }}" readonly>
                            @error('kode')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Pelanggan</label>
                            <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Pelanggan..." wire:model="pelanggan">
                            @error('pelanggan')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="customers" class="col-sm-3 col-form-label">Total Transaksi</label>
                            <div class="col-sm-9">
                                <input readonly type="text" class="form-control total_transaksi" placeholder="Total Transaksi..." value="{{ number_format($total_transaksi,0,'.',',') }}">
                                @error('total_transaksi')
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
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close    "></i> Close</button>
                <button type="submit" class="btn btn-success"><i class="fas fa-save    "></i> Save</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    
      <div class="modal fade" id="modalHold" tabindex="-1" role="dialog" aria-labelledby="modalHoldLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header bg-warning">
              <h5 class="modal-title text-white" id="modalHoldLabel"><i class="fas fa-money-bill    "></i> HOLD PEMBAYARAN</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="">
                            Apakah anda yakin ingin <strong><i>Menahan</i></strong> pembayaran ini?
                        </label>
                    </div>               
                </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close    "></i> Close</button>
              <button type="button" class="btn btn-success"><i class="fas fa-save    "></i> Save</button>
            </div>
          </div>
        </div>
      </div>
    
      <div class="modal fade" id="modalShowHold" tabindex="-1" role="dialog" aria-labelledby="modalShowHoldLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content modal-md">
            <div class="modal-header bg-warning">
              <h5 class="modal-title text-white" id="modalShowHoldLabel"><i class="fas fa-money-bill    "></i> HOLD PEMBAYARAN</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <div class="card" style="cursor: pointer">
                                <div class="card-header text-center">#INV001</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <h6>Sales Qty = 5</h6>
                                    <h6 class="float-right">Total : Rp. 1.000.000,00</h6>
                                </div>
                            </div>
                        </div>    
                        <div class="col-md-6 mb-2">
                            <div class="card" style="cursor: pointer">
                                <div class="card-header text-center">#INV001</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <h6>Sales Qty = 5</h6>
                                    <h6 class="float-right">Total : Rp. 1.000.000,00</h6>
                                </div>
                            </div>
                        </div>    
                        <div class="col-md-6 mb-2">
                            <div class="card" style="cursor: pointer">
                                <div class="card-header text-center">#INV001</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <h6>Sales Qty = 5</h6>
                                    <h6 class="float-right">Total : Rp. 1.000.000,00</h6>
                                </div>
                            </div>
                        </div>    
                        <div class="col-md-6 mb-2">
                            <div class="card" style="cursor: pointer">
                                <div class="card-header text-center">#INV001</div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <h6>Sales Qty = 5</h6>
                                    <h6 class="float-right">Total : Rp. 1.000.000,00</h6>
                                </div>
                            </div>
                        </div>    
                    </div>              
                </form>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-window-close    "></i> Close</button>
              <button type="button" class="btn btn-success"><i class="fas fa-save    "></i> Save</button>
            </div> --}}
          </div>
        </div>
      </div>

      <div class="modal fade" id="modalShowTransaksi" tabindex="-1" role="dialog" aria-labelledby="modalShowTransaksi" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content modal-md">
            <div class="modal-header bg-warning">
              <h5 class="modal-title text-white" id="modalShowTransaksi"><i class="fas fa-money-bill"></i> TRANSAKSI LAYANAN</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div id="areaTransaksi">
                    <div class="table-responsive" style="height: 400px; overflow-y: scroll;">
                        <table class="w-100">
                            <thead>
                                <tr>
                                    <th width="150px;">Product</th>
                                    <th width="150px;" class="text-center">Qty</th>
                                    <th class="text-right" width="140px;">Price</th>
                                </tr>
                            </thead>
                            <tbody class="border-top border-bottom">
                               @foreach ($cartGet['menu'] as $row)
                               <tr>
                                    <td class=" p-2">{{ $row['nama'] }}</td>
                                    <td class="text-center  p-2">
                                        <input class="inputCountCart" type="number" style="width:50px;" value="{{ $row['jumlah'] }}" wire:change="$emit('inputCountCart',[{{ $row['id'] }}, $event.target.value])">
                                        <a href="#" class="btn btn-danger btn-sm" wire:click="removeItem({{ $row['id'] }})"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                    <td class="text-right  p-2">Rp {{ number_format($row['harga'] * $row['jumlah'],2,'.',',') }}</td>
                                </tr>
                               @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="w-100 wire:ignore.self">
                            <tr style="border:2px solid green;" class="font-weight-bold">
                                <td class="p-2" colspan="2">Total</td>
                                <td width="150px;" class="text-right pt-2">Rp.
                                    {{ number_format($total_transaksi,2,'.',',') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                    <hr style="border: 1px solid #c5c5c5;">
                    <div class="row">
                        <div class="col-lg-12">
                            {{-- <a href="#" class="btn btn-danger font-weight-bold text-uppercase w-100" data-toggle="modal" data-target="#modalHold"><i class="fas fa-hand-holding    "></i> HOLD</a> --}}
                            <a href="#" class="btn btn-success font-weight-bold text-uppercase w-100 mt-2 pesanModal"  data-toggle="modal" data-target="#modalPesanan">
                                <i class="fas fa-money-bill    "></i> Pesan</a>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-success" data-dismiss="modal"><i class="fas fa-check-circle    "></i> OK</button>
            </div> --}}
          </div>
        </div>
      </div>
    
      @push('script')
      <script>
          $(document).ready(function(){
            window.livewire.on('posStore', () => {
                $('#modalPesanan').modal('hide');
                $('.modal-backdrop').hide();
            });
            window.livewire.on('stokHabis', () => {
                alert('Stok pesanan 0');
            });
            window.livewire.on('stokLebihKecil', (value) => {
                alert('Jumlah pesanan = '+value.jumlah+' melebihi stok = '+value.stok);
                var id = $('.inputCountCart').data('id',value.id).val(0);
            });
            // new AutoNumeric('.discount_harga', {
            //     decimalCharacter : '.',
            //     digitGroupSeparator : ',',
            //     decimalPlaces:0,
            // });
            // new AutoNumeric('.pajak_harga', {
            //     decimalCharacter : '.',
            //     digitGroupSeparator : ',',
            //     decimalPlaces:0,
            // });
            // new AutoNumeric('.bayar', {
            //     decimalCharacter : '.',
            //     digitGroupSeparator : ',',
            //     decimalPlaces:0,
            // });
            window.livewire.on('selectPaginate', ()  => {
                var val = $('.selectPaginate').children(':selected').val();
                window.livewire.emit('pagination',val);
            })
           window.livewire.on('subKategori', (id)  => {
                window.livewire.emit('handlerSubKategori',id);
            })
           window.livewire.on('backwardKategori', ()  => {
                window.livewire.emit('handlerBackwardKategori');
            })
           window.livewire.on('menuPesanan', (id)  => {
                window.livewire.emit('handlermenuPesanan',id);
            })
        //    window.livewire.on('bayarTransaksi', (val)  => {
        //         window.livewire.emit('handlerBayarTransaksi',val);
        //     })

            window.livewire.on('inputCountCart', (val)  => {
                    window.livewire.emit('handlerCountCart',val);
            })
            // window.livewire.on('discount_harga', (val)  => {
            //         window.livewire.emit('handlerDiscountHarga',val);
            // })
            // window.livewire.on('pajak_harga', (val)  => {
            //         window.livewire.emit('handlerPajakHarga',val);
            // })
            $(document).on('click','.pesanModal',function(e){
                e.preventDefault();
                $('#modalShowTransaksi').modal('hide');
            })
        })
      </script>
  @endpush
</div>
