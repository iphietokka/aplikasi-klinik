<section class="sidebar" id="nav">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ url('backend/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header"></li>
        <li>
          <a href="{{url('admin')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Master Data</span>
            <span class="pull-right-container">
               <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('admin/user')}}"><i class="fa fa-circle-o"></i> Data User</a></li>
            <li><a href="{{url('admin/member')}}"><i class="fa fa-circle-o"></i> Data Member</a></li>
            <li><a href="{{url('admin/pegawai')}}"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
            <li><a href="{{url('admin/supplier')}}"><i class="fa fa-circle-o"></i> Data Supplier</a></li>
            <li><a href="{{url('admin/unit')}}"><i class="fa fa-circle-o"></i> Data Unit</a></li>
            </ul>
        </li> 
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Master Product</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="{{url('admin/product')}}"><i class="fa fa-circle-o"></i> Data Product</a></li>
          <li><a href="{{url('admin/category')}}"><i class="fa fa-circle-o"></i> Data Kategori</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Master Transaksi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('purchase') }}"><i class="fa fa-circle-o"></i> Pembelian</a></li>
            <li><a href="{{ url('admin/penjualan') }}"><i class="fa fa-circle-o"></i> Penjualan</a></li>
          </ul>
        </li>
        <li>
          <a href="{{ url('admin/perawatan') }}">
            <i class="fa fa-edit"></i> <span>Data Perawatan</span>
            <span class="pull-right-container">
            </span>
          </a>
          
        </li>
        <li>
          <a href="#">
            <i class="fa fa-table"></i> <span>Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
      </ul>
    </section>