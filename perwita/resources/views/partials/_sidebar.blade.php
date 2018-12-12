<style media="screen">
.spin {
-webkit-animation: spin 2s infinite linear;
-moz-animation: spin 2s infinite linear;
-o-animation: spin 2s infinite linear;
animation: spin 2s infinite linear;
}
@-moz-keyframes spin {
from {
  -moz-transform: rotate(0deg);
}
to {
  -moz-transform: rotate(360deg);
}
}
@-webkit-keyframes spin {
from {
  -webkit-transform: rotate(0deg);
}
to {
  -webkit-transform: rotate(360deg);
}
}
@keyframes spin {
from {
  transform: rotate(0deg);
}
to {
  transform: rotate(360deg);
}
}
</style>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header text-center">
                <div class="dropdown profile-element">
                  <span>
                  @if (file_exists(Auth::user()->m_image))
                      <img alt="image" class="img-circle" width="35%" src="{{ asset('/') }}/{{Auth::user()->m_image}}" />
                  @else
                      <img alt="image" class="img-circle" width="35%" src="{{ asset('assets/img/dboard/logo/sublogo1.png') }}" />
                  @endif
                    </span>
                    <span class="clear"> <span class="block m-t-xs">
                            <strong class="font-bold" style="color: white;">{{ Auth::user()->m_name }}</strong>
                            </span>
                    </span>
                </div>
                <div class="logo-element" style="background:#f3f3f4;">
                    <img src="{{ asset('assets/img/dboard/logo/sublogo.png') }}" width="30px">
                </div>
            </li>

            <?php $sidebar = App\Http\Controllers\AksesUser::aksesSidebar() ?>

            @if($sidebar[0]->ma_read == 'Y')
            <li class="{{Request::is('dashboard') ? 'active' : ''}}">
              <a href="{{url('dashboard')}}"><i class="glyphicon glyphicon-home"></i>
                  <i class="" aria-hidden="true"></i><span class="nav-label">Dashboards</span>
              </a>
            </li>
            @endif

            @if($sidebar[1]->ma_read == 'Y')
            <li class="treeview sidebar data-master {{
                 Request::is('manajemen-pekerja/data-pekerja') ? 'active' : ''
              || Request::is('manajemen-pekerja/data-pekerja/*') ? 'active' : ''
              || Request::is('manajemen-pekerja/surat-peringatan') ? 'active' : ''
              || Request::is('manajemen-pekerja/surat-peringatan/*') ? 'active' : ''
              || Request::is('manajemen-pekerja-mitra/data-pekerja-mitra') ? 'active' : ''
              || Request::is('manajemen-pekerja-mitra/data-pekerja-mitra/*') ? 'active' : ''
              || Request::is('pekerja-di-mitra/pekerja-mitra') ? 'active' : ''
              || Request::is('pekerja-di-mitra/pekerja-mitra/*') ? 'active' : ''
              || Request::is('manajemen-pekerja/promosi-demosi') ? 'active' : ''
              || Request::is('manajemen-pekerja/promosi-demosi/*') ? 'active' : ''
              || Request::is('manajemen-pekerja/remunerasi') ? 'active' : ''
              || Request::is('manajemen-pekerja/remunerasi/*') ? 'active' : ''
              || Request::is('manajemen-pekerja/rekening') ? 'active' : ''
              || Request::is('manajemen-pekerja/phk') ? 'active' : ''
              || Request::is('manajemen-pekerja/phk/*') ? 'active' : ''
              || Request::is('manajemen-pekerja/rekening/*') ? 'active' : ''
              || Request::is('manajemen-kontrak-mitra/data-kontrak-mitra') ? 'active' : ''
              || Request::is('manajemen-kontrak-mitra/data-kontrak-mitra/*') ? 'active' : '' }}">
                <a href="#" id="step1"><i class="glyphicon glyphicon-briefcase"></i> <span class="nav-label">Manajemen TK (MJI)</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-pekerja/data-pekerja') ? 'active' : ''
                                || Request::is('manajemen-pekerja/data-pekerja/*') ? 'active' : ''  }}">
                        <a href="{{ url('manajemen-pekerja/data-pekerja') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Data Pekerja</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-kontrak-mitra/data-kontrak-mitra') ? 'active' : '' || Request::is('manajemen-kontrak-mitra/data-kontrak-mitra/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-kontrak-mitra/data-kontrak-mitra') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Permintaan Pekerja</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pekerja-mitra/data-pekerja-mitra') ? 'active' : '' || Request::is('manajemen-pekerja-mitra/data-pekerja-mitra/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-pekerja-mitra/data-pekerja-mitra') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Penerimaan Pekerja</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('pekerja-di-mitra/pekerja-mitra') ? 'active' : '' || Request::is('pekerja-di-mitra/pekerja-mitra/*') ? 'active' : '' }}">
                        <a href="{{ url('pekerja-di-mitra/pekerja-mitra') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Pekerja di Mitra</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pekerja/surat-peringatan') ? 'active' : '' || Request::is('manajemen-pekerja/surat-peringatan/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-pekerja/surat-peringatan') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">SP Pekerja</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pekerja/promosi-demosi') ? 'active' : '' || Request::is('manajemen-pekerja/manajemen-pekerja/promosi-demosi/*') ? 'active' : '' || Request::is('manajemen-pekerja/promosi-demosi/cari') ? 'active' : ''}}">
                        <a href="{{ url('manajemen-pekerja/promosi-demosi') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Promosi & Demosi</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pekerja/remunerasi') ? 'active' : '' || Request::is('manajemen-pekerja/remunerasi/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-pekerja/remunerasi') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Remunerasi</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pekerja/phk') ? 'active' : '' || Request::is('manajemen-pekerja/phk/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-pekerja/phk') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">PHK</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pekerja/rekening') ? 'active' : '' || Request::is('manajemen-pekerja/rekening/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-pekerja/rekening') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Rekening Pekerja</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if($sidebar[2]->ma_read == 'Y')
            <li class="treeview sidebar data-master {{
                 Request::is('pekerja-pjtki/data-pekerja') ? 'active' : ''}}">
                <a href="#" id="step1"><i class="glyphicon glyphicon-briefcase"></i> <span class="nav-label">Manajemen TK (PJTKI)</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('pekerja-pjtki/data-pekerja') ? 'active' : ''
                                || Request::is('pekerja-pjtki/data-pekerja/*') ? 'active' : ''  }}">
                        <a href="{{ url('pekerja-pjtki/data-pekerja') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Data Pekerja</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if($sidebar[3]->ma_read == 'Y')
            <li class="treeview sidebar data-master {{
                     Request::is('manajemen-mitra/data-mitra') ? 'active' : ''
                  || Request::is('manajemen-mitra/data-mitra/*') ? 'active' : ''
                  || Request::is('manajemen-mitra/mitra-divisi') ? 'active' : ''
                  || Request::is('manajemen-mitra/mitra-divisi/*') ? 'active' : ''
                  || Request::is('manajemen-mitra/mitra-mou/*') ? 'active' : ''
                  || Request::is('manajemen-mitra/mitra-mou') ? 'active' : ''
              }}
              ">
                <a href="#" id="step1"><i class="fa fa-handshake-o"></i> <span class="nav-label">Manajemen Mitra</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-mitra/data-mitra') ? 'active' : ''
                                || Request::is('manajemen-mitra/data-mitra/*') ? 'active' : ''  }} sidebar master-akun">
                        <a href="{{ url('manajemen-mitra/data-mitra') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Mitra Perusahaan</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('manajemen-mitra/mitra-divisi') ? 'active' : ''
                                || Request::is('manajemen-mitra/mitra-divisi/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-mitra/mitra-divisi') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Mitra Divisi</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('manajemen-mitra/mitra-mou') ? 'active' : ''
                                || Request::is('manajemen-mitra/mitra-mou/*') ? 'active' : ''  }} sidebar master-akun">
                        <a href="{{ url('manajemen-mitra/mitra-mou') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Mitra MOU</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if($sidebar[4]->ma_read == 'Y')
            <li class="treeview sidebar data-master
                {{ Request::is('manajemen-seragam/*') ? 'active' : ''
                || Request::is('manajemen-seragam/pembayaran-seragam') ? 'active' : ''
                || Request::is('manajemen-seragam') ? 'active' : ''
                || Request::is('master-item') ? 'active' : ''
                || Request::is('master-item/*') ? 'active' : ''
                }}">
                <a href="#" id="step1"><i class="fa fa-list"></i> <span class="nav-label">Manajemen Seragam</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{
                        Request::is('manajemen-seragam/rencana-pembelian') ? 'active' : '' ||
                        Request::is('manajemen-seragam/rencana-pembelian/*') ? 'active' : ''}} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/rencana-pembelian') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Rencana Pembelian</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-seragam/pembelian/*') ? 'active' : ''
                                || Request::is('manajemen-seragam/pembelian') ? 'active' : ''
                                || Request::is('manajemen-seragam/tambah') ? 'active' : ''
                                || Request::is('manajemen-seragam/gunakan-rencana-pembelian') ? 'active' : ''
                                }} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/pembelian') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Pembelian Seragam</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-seragam/penerimaan') ? 'active' : ''
                                || Request::is('manajemen-seragam/penerimaan/*') ? 'active' : '' }} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/penerimaan') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Penerimaan Pembelian</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-seragam/return') ? 'active' : ''
                                || Request::is('manajemen-seragam/return/*') ? 'active' : '' }} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/return') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Return Pembelian</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-seragam/pengeluaran') ? 'active' : ''
                                || Request::is('manajemen-seragam/tambah-pengeluaran') ? 'active' : ''
                                || Request::is('manajemen-seragam/history') ? 'active' : ''}} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/pengeluaran') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Pengeluaran Seragam</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-seragam/penerimaanpengeluaranseragam') ? 'active' : ''
                                || Request::is('manajemen-seragam/penerimaanpengeluaranseragam/*') ? 'active' : '' }} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/penerimaanpengeluaranseragam') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Penerimaan Pengeluaran Seragam</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-seragam/pembagianseragam') ? 'active' : ''
                                || Request::is('manajemen-seragam/pembagianseragam/*') ? 'active' : ''
                                || Request::is('manajemen-seragam/pembayaran-pekerja') ? 'active' : '' }} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/pembagianseragam') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Pembagian Seragam</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-seragam/pembayaran-seragam') ? 'active' : ''
                                || Request::is('manajemen-seragam/pembayaran-seragam/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-seragam/pembayaran-seragam') }}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Pembayaran Seragam</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-seragam/master-seragam') ? 'active' : '' || Request::is('manajemen-seragam/master-seragam/*') ? 'active' : '' || Request::is('master-item') ? 'active' : '' || Request::is('master-item/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-seragam/master-seragam') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Master Seragam</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-seragam/master-supplier') ? 'active' : '' || Request::is('manajemen-seragam/master-supplier/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-seragam/master-supplier') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Master Supplier</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if($sidebar[5]->ma_read == 'Y')
            <li class="treeview sidebar data-master {{
                 Request::is('manajemen-stock/mutasi-stock') ? 'active' : ''
              || Request::is('manajemen-stock/mutasi-stock/*') ? 'active' : ''
              || Request::is('manajemen-stock/stock-opname') ? 'active' : ''
              || Request::is('manajemen-stock/stock-opname/*') ? 'active' : ''
              || Request::is('manajemen-stock/data-stock') ? 'active' : ''
              || Request::is('manajemen-stock/data-stock/*') ? 'active' : ''}}">
                <a href="#" id="step1"><i class="fa fa-cube"></i> <span class="nav-label">Manajemen Stock</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-stock/data-stock') ? 'active' : ''
                                || Request::is('manajemen-stock/data-stock/*') ? 'active' : ''  }}">
                        <a href="{{ url('manajemen-stock/data-stock') }}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Stock Seragam</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-stock/mutasi-stock') ? 'active' : ''
                                || Request::is('manajemen-stock/mutasi-stock/*') ? 'active' : ''  }}">
                        <a href="{{ url('manajemen-stock/mutasi-stock') }}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Mutasi Stock</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-stock/stock-opname') ? 'active' : ''
                                || Request::is('manajemen-stock/stock-opname/*') ? 'active' : ''  }}">
                        <a href="{{ url('manajemen-stock/stock-opname') }}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Stock Opname</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if($sidebar[6]->ma_read == 'Y')
            <li class="treeview sidebar data-master {{
                 Request::is('manajemen-pegawai/data-pegawai') ? 'active' : ''
                 || Request::is('manajemen-pegawai/data-pegawai/*') ? 'active' : ''
                 || Request::is('manajemen-pegawai/promosidemosi') ? 'active' : ''
                 || Request::is('manajemen-pegawai/pegawairemunerasi') ? 'active' : ''
                 || Request::is('manajemen-pegawai/pegawairemunerasi/*') ? 'active' : ''
                 || Request::is('manajemen-pegawai/pegawaiphk') ? 'active' : ''
                 || Request::is('manajemen-pegawai/pegawaiphk/*') ? 'active' : ''}}">
                <a href="#" id="step1"><i class="fa fa-user"></i> <span class="nav-label">Manajemen Pegawai</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-pegawai/data-pegawai') ? 'active' : '' || Request::is('manajemen-pegawai/data-pegawai/*') ? 'active' : ''}}">
                        <a href="{{url('manajemen-pegawai/data-pegawai')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Data Pegawai</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pegawai/promosidemosi') ? 'active' : '' }} || Request::is('manajemen-pegawai/promosidemosi/*') ? 'active' : ''">
                        <a href="{{url('manajemen-pegawai/promosidemosi')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Promosi & Demosi</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pegawai/pegawairemunerasi') ? 'active' : '' }} || Request::is('manajemen-pegawai/pegawairemunerasi/*') ? 'active' : ''">
                        <a href="{{url('manajemen-pegawai/pegawairemunerasi')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Remunerasi</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pegawai/pegawaiphk') ? 'active' : '' }} || Request::is('manajemen-pegawai/pegawaiphk/*') ? 'active' : ''">
                        <a href="{{url('manajemen-pegawai/pegawaiphk')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">PHK</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if($sidebar[7]->ma_read == 'Y')
            <li class="treeview sidebar data-master {{
                 Request::is('manajemen-payroll/payroll') ? 'active' : '' || Request::is('manajemen-payroll/payroll/*') ? 'active' : ''}}">
                <a href="#" id="step1"><i class="fa fa-money"></i> <span class="nav-label">Payroll</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-payroll/payroll/gaji') ? 'active' : '' || Request::is('manajemen-payroll/payroll/gaji/*') ? 'active' : ''}}">
                        <a href="{{url('manajemen-payroll/payroll/gaji')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Gaji Pokok</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-payroll/payroll/tunjangan') ? 'active' : '' || Request::is('manajemen-payroll/payroll/tunjangan/*') ? 'active' : ''}}">
                        <a href="{{url('manajemen-payroll/payroll/tunjangan')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Tunjangan</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-payroll/payroll/potongan') ? 'active' : '' || Request::is('manajemen-payroll/payroll/potongan/*') ? 'active' : ''}}">
                        <a href="{{url('manajemen-payroll/payroll/potongan')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Potongan</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-payroll/payroll/penggajian') ? 'active' : '' || Request::is('manajemen-payroll/payroll/penggajian/*') ? 'active' : ''}}">
                        <a href="{{url('manajemen-payroll/payroll/penggajian')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Proses Gaji</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif

            @if($sidebar[8]->ma_read == 'Y')
            <li class="treeview sidebar data-master {{
                 Request::is('manajemen-bpjs/ansuransi') ? 'active' : ''
                 || Request::is('manajemen-bpjs/ansuransi/*') ? 'active' : ''
                 || Request::is('manajemen-faskes/*') ? 'active' : ''
                }}">
                <a href="#" id="step1"><i class="fa fa-ambulance"></i> <span class="nav-label">Ansuransi</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-bpjs/ansuransi/kesehatan') ? 'active' : '' || Request::is('manajemen-bpjs/ansuransi/kesehatan/*') ? 'active' : ''}}">
                        <a href="{{url('manajemen-bpjs/ansuransi/kesehatan')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">BPJS Kesehatan</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-bpjs/ansuransi/ketenagakerjaan') ? 'active' : ''
                            || Request::is('manajemen-bpjs/ansuransi/ketenagakerjaan/*') ? 'active' : ''
                        }}">
                        <a href="{{url('manajemen-bpjs/ansuransi/ketenagakerjaan')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">BPJS Ketenagakerjaan</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-bpjs/ansuransi/rbh') ? 'active' : '' || Request::is('manajemen-bpjs/ansuransi/rbh/*') ? 'active' : ''}}">
                        <a href="{{url('manajemen-bpjs/ansuransi/rbh')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">RBH (Ramamuza Bhakti Husada)</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-bpjs/ansuransi/dapan') ? 'active' : '' || Request::is('manajemen-bpjs/ansuransi/dapan/*') ? 'active' : ''}}">
                        <a href="{{url('manajemen-bpjs/ansuransi/dapan')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Dapan</span>
                        </a>
                    </li>
                    {{-- <li class="{{ Request::is('manajemen-faskes/*') ? 'active' : '' || Request::is('manajemen-bpjs/ansuransi/dapan/*') ? 'active' : ''}}">
                        <a href="{{url('manajemen-faskes')}}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Fasilitas Kesehatan</span>
                        </a>
                    </li> --}}
                </ul>
            </li>
            @endif

            {{-- <li class="treeview sidebar data-master {{
                 Request::is('bpjs') ? 'active' : '' }}">
                <a href="#" id="step1"><i class="fa fa-file-o"></i> <span class="nav-label">Bpjs Tk</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('bpjs') ? 'active' : '' || Request::is('bpjs/*') ? 'active' : '' }}">
                        <a href="{{ url('bpjs') }}">
                            <i class="fa  fa-book" aria-hidden="true"></i><span class="nav-label">Daftar Bpjs</span>
                        </a>
                    </li>

                </ul>
            </li> --}}

            {{-- <li class="">
                <a href="{{url('surat')}}"><i class="fa fa-th-large"></i>
                    <span class="nav-label">Manajemen surat</span>
                </a>
            </li>
            <li class="">
                <a href="{{url('manajemen-akun/data-akun')}}"><i class="fa fa-th-large"></i>
                    <span class="nav-label">Master Akun</span>
                </a>
            </li> --}}
            {{-- <li class="treeview sidebar data-master
            {{  Request::is('master-item') ? 'active' : '' ||
                Request::is('master-item/*') ? 'active' : '' ||
                Request::is('master-supplier') ? 'active' : '' ||
                Request::is('master-supplier/*') ? 'active' : ''
            }}">
                <a href="#" id="step1"><i class="fa fa-database"></i> <span class="nav-label">Data Master</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('master-item') ? 'active' : '' || Request::is('master-item/*') ? 'active' : '' }}">
                        <a href="{{ url('master-item') }}">
                            <i class="fa fa-circle-o" aria-hidden="true"></i><span class="nav-label">Master Seragam</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('master-supplier') ? 'active' : '' || Request::is('master-supplier/*') ? 'active' : '' }}">
                        <a href="{{ url('master-supplier') }}">
                            <i class="fa fa-circle-o" aria-hidden="true"></i><span class="nav-label">Master Supplier</span>
                        </a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="">
                <a href="{{url('data-master/master-transaksi-akun')}}"><i class="fa fa-th-large"></i>
                    <span class="nav-label">Master Transaksi</span>
                </a>
            </li>
            <li class="">
                <a href="{{url('entri-transaksi/data-transaksi')}}"><i class="fa fa-th-large"></i>
                    <span class="nav-label">Data Transaksi</span>
                </a>
            </li>
            <li>
                <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Laporan Keuangan</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{url('laporan-keuangan/neraca')}}">Laporan Neraca</a></li>
                    <li><a href="{{url('laporan-keuangan/laba-rugi')}}">Laporan Laba Rugi</a></li>
                    <li><a href="{{url('laporan-keuangan/arus-kas')}}">Laporan Arus Kas</a></li>
                </ul>
            </li> --}}

            @if($sidebar[9]->ma_read == 'Y')
            <li style="padding-bottom: 30px;" class="{{ Request::is('manajemen-pengguna/pengguna') ? 'active' : ''
                                || Request::is('manajemen-pengguna/*') ? 'active' : ''
                                || Request::is('master-jabatan') ? 'active' : ''
                                || Request::is('system/hakuser/*') ? 'active' : ''
                                || Request::is('system/hakakses/*') ? 'active' : ''
                                || Request::is('master-perusahaan') ? 'active' : ''
                                || Request::is('master-perusahaan/*') ? 'active' : ''
                }}">
                <a href="index.html"><i class="fa fa-cog spin"></i> <span class="nav-label">Setting Aplikasi</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-pengguna/pengguna') ? 'active' : ''
                                || Request::is('manajemen-pengguna/*') ? 'active' : ''  }}"><a href="{{url('manajemen-pengguna/pengguna')}}">Manajemen Pengguna</a></li>
                    <li class="{{ Request::is('system/hakuser/user') ? 'active' : '' || Request::is('system/hakakses/*') ? 'active' : '' }}">
                        <a href="{{url('system/hakuser/user')}}">Akses Pengguna</a>
                    </li>
                    {{-- <li><a href="{{url('setting-aplikasi')}}">Group Akses</a></li> --}}
                    <li class="{{ Request::is('master-jabatan') ? 'active' : ''}}">
                        <a href="{{url('master-jabatan')}}">Master Jabatan</a>
                    </li>
                    <li class="{{ Request::is('master-perusahaan') ? 'active' : '' || Request::is('master-perusahaan/*') ? 'active' : '' }}"><a href="{{url('master-perusahaan')}}">Master Perusahaan</a></li>
                </ul>
            </li>
            @endif


        </ul>
    </div>
</nav>
