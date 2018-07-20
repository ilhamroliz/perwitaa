<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header text-center">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="{{ asset('assets/img/profile_small.jpg') }}" />
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

            <li class="{{Request::is('dashboard') ? 'active' : ''}}">
              <a href="{{url('dashboard')}}"><i class="fa fa-th-large"></i>
                  <i class="" aria-hidden="true"></i><span class="nav-label">Dashboards</span>
              </a>
            </li>
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
              || Request::is('manajemen-kontrak-mitra/data-kontrak-mitra') ? 'active' : ''
              || Request::is('manajemen-kontrak-mitra/data-kontrak-mitra/*') ? 'active' : '' }}">
                <a href="#" id="step1"><i class="fa fa-file-o"></i> <span class="nav-label">Manajemen Pekerja</span><span class="fa arrow"></span></a>
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
                    <li class="{{ Request::is('manajemen-pekerja/promosi-demosi') ? 'active' : '' || Request::is('manajemen-pekerja/manajemen-pekerja/promosi-demosi/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-pekerja/promosi-demosi') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Promosi & Demosi</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('manajemen-pekerja/remunerasi') ? 'active' : '' || Request::is('manajemen-pekerja/remunerasi/*') ? 'active' : '' }}">
                        <a href="{{ url('manajemen-pekerja/remunerasi') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Remunerasi</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview sidebar data-master {{
                     Request::is('manajemen-mitra/data-mitra') ? 'active' : ''
                  || Request::is('manajemen-mitra/data-mitra/*') ? 'active' : ''
                  || Request::is('manajemen-mitra/mitra-divisi') ? 'active' : ''
                  || Request::is('manajemen-mitra/mitra-divisi/*') ? 'active' : ''
                  || Request::is('manajemen-mitra/mitra-mou/*') ? 'active' : ''
                  || Request::is('manajemen-mitra/mitra-mou') ? 'active' : ''
              }}
              ">
                <a href="#" id="step1"><i class="fa fa-file-o"></i> <span class="nav-label">Manajemen Mitra</span><span class="fa arrow"></span></a>
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

            <li class="treeview sidebar data-master
                {{ Request::is('manajemen-seragam/*') ? 'active' : ''
                || Request::is('manajemen-seragam/pembayaran-seragam') ? 'active' : ''
                || Request::is('manajemen-seragam') ? 'active' : ''
                }}">
                <a href="#" id="step1"><i class="fa fa-file-o"></i> <span class="nav-label">Manajemen Seragam</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-seragam/pembelian') ? 'active' : ''
                                || Request::is('manajemen-seragam/tambah') ? 'active' : '' }} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/pembelian') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Pembelian Seragam</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-seragam/penerimaan') ? 'active' : ''
                                || Request::is('manajemen-seragam/penerimaan/*') ? 'active' : '' }} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/penerimaan') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Penerimaan Seragam</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-seragam/return') ? 'active' : ''
                                || Request::is('manajemen-seragam/return/*') ? 'active' : '' }} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/return') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Return Pembelian</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-seragam/pengeluaran') ? 'active' : ''
                                || Request::is('manajemen-seragam/tambah-pengeluaran') ? 'active' : '' }} sidebar master-akun">
                        <a href="{{ url('manajemen-seragam/pengeluaran') }}">
                            <i class="" aria-hidden="true"></i><span class="nav-label">Pengeluaran Seragam</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('manajemen-seragam/pembayaran-seragam') ? 'active' : ''  }}">
                        <a href="{{ url('manajemen-seragam/pembayaran-seragam') }}">
                            <i class=" " aria-hidden="true"></i><span class="nav-label">Pembayaran Seragam</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="treeview sidebar data-master {{
                 Request::is('manajemen-stock/mutasi-stock') ? 'active' : ''
              || Request::is('manajemen-stock/mutasi-stock/*') ? 'active' : ''
              || Request::is('manajemen-stock/stock-opname') ? 'active' : ''
              || Request::is('manajemen-stock/stock-opname/*') ? 'active' : ''
              || Request::is('manajemen-stock/data-stock') ? 'active' : ''
              || Request::is('manajemen-stock/data-stock/*') ? 'active' : ''}}">
                <a href="#" id="step1"><i class="fa fa-file-o"></i> <span class="nav-label">Manajemen Stock</span><span class="fa arrow"></span></a>
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

            <li class="">
                <a href="{{url('manajemen-pegawai/data-pegawai')}}"><i class="fa fa-th-large"></i>
                    <span class="nav-label">Manajemen Pegawai</span>
                </a>
            </li>
                <li class="treeview sidebar data-master {{
                 Request::is('bpjs') ? 'active' : '' }}">
                <a href="#" id="step1"><i class="fa fa-file-o"></i> <span class="nav-label">Bpjs Tk</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li class="{{ Request::is('bpjs') ? 'active' : '' || Request::is('bpjs/*') ? 'active' : '' }}">
                        <a href="{{ url('bpjs') }}">
                            <i class="fa  fa-book" aria-hidden="true"></i><span class="nav-label">Daftar Bpjs</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="">
                <a href="{{url('manajemen-pekerja/data-pekerja')}}"><i class="fa fa-th-large"></i>
                    <span class="nav-label">Manajemen pekerja</span>
                </a>
            </li>
            <li class="">
                <a href="{{url('surat')}}"><i class="fa fa-th-large"></i>
                    <span class="nav-label">Manajemen surat</span>
                </a>
            </li>
            <li class="">
                <a href="{{url('manajemen-akun/data-akun')}}"><i class="fa fa-th-large"></i>
                    <span class="nav-label">Master Akun</span>
                </a>
            </li>
            <li class="treeview sidebar data-master
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
            </li>
            <li class="">
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
            </li>
            <li style="padding-bottom: 30px;">
                <a href="index.html"><i class="fa fa-th-large"></i> <span class="nav-label">Setting Aplikasi</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="{{url('manajemen-pengguna/pengguna')}}">Manajemen Pengguna</a></li>
                    <li><a href="{{url('manajemen-hak-akses/group')}}">Manajemen Akses Group</a></li>
                    <li><a href="{{url('setting-aplikasi')}}">Group Akses</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
