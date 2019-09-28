  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ Admin::user()->avatar }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Admin::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

@php
  $menus = Admin::getMenu();
  // print_r($menus);
@endphp
{{-- Level 0 --}}
        @foreach ($menus[0] as $level0)
          @if ($level0->type ==1)
            @if(Admin::user()->visible($level0))
            <li class="header">{{ sc_language_render($level0->title) }}</li>
            @endif
          @elseif($level0->uri)
            @if(Admin::user()->visible($level0))
              <li class=""><a href="{{ $level0->uri?sc_url_render($level0->uri):'#' }}"><i class="fa {{ $level0->icon }}"></i>{{ sc_language_render($level0->title) }}</a></li>
            @endif
          @else
            @if(Admin::user()->visible($level0))
            <li class="treeview">
              <a href="#">
                <i class="fa {{ $level0->icon }}"></i> <span>{{ sc_language_render($level0->title) }}</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
    {{-- Level 1 --}}
            @if (isset($menus[$level0->id]) && count($menus[$level0->id]))
              <ul class="treeview-menu">
                @foreach ($menus[$level0->id] as $level1)
                  @if($level1->uri)
                    @if(Admin::user()->visible($level1))
                    <li class=""><a href="{{ $level1->uri?sc_url_render($level1->uri):'#' }}"><i class="fa {{ $level1->icon }}"></i> {{ sc_language_render($level1->title) }}</a></li>
                    @endif
                  @else
                  @if(Admin::user()->visible($level1))
                  <li class="treeview">
                    <a href="#">
                      <i class="fa {{ $level1->icon }}"></i> <span>{{ sc_language_render($level1->title) }}</span>
                      <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                      </span>
                    </a>
            {{-- LEvel 2  --}}
                        @if (isset($menus[$level1->id]) && count($menus[$level1->id]))
                          <ul class="treeview-menu">
                            @foreach ($menus[$level1->id] as $level2)
                              @if($level2->uri)
                                @if(Admin::user()->visible($level2))
                                <li class=""><a href="{{ $level2->uri?sc_url_render($level2->uri):'#' }}"><i class="fa {{ $level2->icon }}"></i> {{ sc_language_render($level2->title) }}</a></li>
                                @endif
                              @else
                              @if(Admin::user()->visible($level2))
                              <li class="treeview">
                                <a href="#">
                                  <i class="fa {{ $level2->icon }}"></i> <span>{{ sc_language_render($level2->title) }}</span>
                                  <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                  </span>
                                </a>

                                </li>
                                @endif
                              @endif
                            @endforeach
                          </ul>
                        @endif
                        {{--  end level 2 --}}
                    </li>
                    @endif
                  @endif
                 @endforeach
              </ul>
            @endif
              {{-- end level 1 --}}
            </li>
            @endif
          @endif

        @endforeach
      {{-- end level 0 --}}

      </ul>

@include('admin.component.sidebar_bottom')

    </section>
    <!-- /.sidebar -->
  </aside>
