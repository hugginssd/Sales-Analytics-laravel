@php
  $carts = \Cart::getListCart();
@endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description??sc_store('description') }}">
    <meta name="keyword" content="{{ $keyword??sc_store('keyword') }}">
    <title>{{$title??sc_store('title')}}</title>
    <meta property="og:image" content="{{ !empty($og_image)?$og_image:asset('images/org.jpg') }}" />
    <meta property="og:url" content="{{ \Request::fullUrl() }}" />
    <meta property="og:type" content="Website" />
    <meta property="og:title" content="{{ $title??sc_store('title') }}" />
    <meta property="og:description" content="{{ $description??sc_store('description') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!--Module meta -->
  @isset ($blocksContent['meta'])
      @foreach ( $blocksContent['meta']  as $layout)
        @php
          $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->page =='html')
            {{$layout->text }}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module meta -->
    <link href="{{ asset('templates/'.sc_store('template').'/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('templates/'.sc_store('template').'/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('templates/'.sc_store('template').'/css/prettyPhoto.css')}}" rel="stylesheet">
    <link href="{{ asset('templates/'.sc_store('template').'/css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('templates/'.sc_store('template').'/css/main.css')}}" rel="stylesheet">
    <link href="{{ asset('templates/'.sc_store('template').'/css/responsive.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="{{ asset('templates/'.sc_store('template').'/js/html5shiv.js')}}"></script>
    <script src="{{ asset('templates/'.sc_store('template').'/js/respond.min.js')}}"></script>
    <![endif]-->
    <link rel="shortcut icon" href="{{ asset('templates/'.sc_store('template').'/images/ico/favicon.ico')}}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('templates/'.sc_store('template').'/images/ico/apple-touch-icon-144-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('templates/'.sc_store('template').'/images/ico/apple-touch-icon-114-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('templates/'.sc_store('template').'/images/ico/apple-touch-icon-72-precomposed.png')}}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('templates/'.sc_store('template').'/images/ico/apple-touch-icon-57-precomposed.png')}}">
<!--Module header -->
  @isset ($blocksContent['header'])
      @foreach ( $blocksContent['header']  as $layout)
      @php
        $arrPage = explode(',', $layout->page)
      @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->page =='html')
            {{$layout->text }}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module header -->

</head><!--/head-->
<body>

@include('templates.'.sc_store('template').'.header')

<!--Module banner -->
  @isset ($blocksContent['banner_top'])
      @foreach ( $blocksContent['banner_top']  as $layout)
      @php
        $arrPage = explode(',', $layout->page)
      @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @elseif($layout->type =='view')
            @if (view()->exists('block.'.$layout->text))
             @include('block.'.$layout->text)
            @endif
          @elseif($layout->type =='module')
            {!! sc_block_render($layout->text) !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module banner -->


<!--Module top -->
  @isset ($blocksContent['top'])
      @foreach ( $blocksContent['top']  as $layout)
        @php
          $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @elseif($layout->type =='view')
            @if (view()->exists('block.'.$layout->text))
             @include('block.'.$layout->text)
            @endif
          @elseif($layout->type =='module')
            {!! sc_block_render($layout->text) !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module top -->


  <section>
    <div class="container">
      <div class="row">
        <div class="col-sm-12" id="breadcrumb">
          <!--breadcrumb-->
          @yield('breadcrumb')
          <!--//breadcrumb-->

          <!--//fillter-->
          @yield('filter')
          <!--//fillter-->
        </div>

        <!--body-->
        @section('main')
          @include('templates.'.sc_store('template').'.left')
          @include('templates.'.sc_store('template').'.center')
          @include('templates.'.sc_store('template').'.right')
        @show
        <!--//body-->

      </div>
    </div>
  </section>

@include('templates.'.sc_store('template').'.footer')

<script src="{{ asset('templates/'.sc_store('template').'/js/jquery.js')}}"></script>
<script src="{{ asset('templates/'.sc_store('template').'/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('templates/'.sc_store('template').'/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('templates/'.sc_store('template').'/js/jquery.scrollUp.min.js')}}"></script>
<script src="{{ asset('templates/'.sc_store('template').'/js/jquery.prettyPhoto.js')}}"></script>
<script src="{{ asset('templates/'.sc_store('template').'/js/main.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/mouse0270-bootstrap-notify/3.1.7/bootstrap-notify.min.js"></script>


@stack('scripts')

    <script type="text/javascript">
      function formatNumber (num) {
          return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
      }
      $('#shipping').change(function(){
          $('#total').html(formatNumber(parseInt({{ Cart::subtotal() }})+ parseInt($('#shipping').val())));
      });
    </script>

    <script type="text/javascript">
        function addToCartAjax(id,instance = null){
        $.ajax({
            url: "{{ route('cart.add_ajax') }}",
            type: "POST",
            dataType: "JSON",
            data: {"id": id,"instance":instance, "_token":"{{ csrf_token() }}"},
            async: false,
            success: function(data){
              // console.log(data);
                error= parseInt(data.error);
                if(error ==0)
                {
                  setTimeout(function () {
                    if(data.instance =='default'){
                      $('.shopping-cart').html(data.count_cart);
                    }else{
                      $('.shopping-'+data.instance).html(data.count_cart);
                    }
                  }, 1000);

                    $.notify({
                      icon: 'glyphicon glyphicon-star',
                      message: data.msg
                    },{
                      type: 'success'
                    });
                }else{
                  if(data.redirect){
                    window.location.replace(data.redirect);
                    return;
                  }
                  $.notify({
                  icon: 'glyphicon glyphicon-warning-sign',
                    message: data.msg
                  },{
                    type: 'danger'
                  });
                }

                }
        });
    }
</script>

<!--message-->
    @if(Session::has('success'))
    <script type="text/javascript">
        $.notify({
          icon: 'glyphicon glyphicon-star',
          message: "{!! Session::get('success') !!}"
        },{
          type: 'success'
        });
    </script>
    @endif
    @if(Session::has('error'))
    <script type="text/javascript">
        $.notify({
        icon: 'glyphicon glyphicon-warning-sign',
          message: "{!! Session::get('error') !!}"
        },{
          type: 'danger'
        });
    </script>
    @endif
    @if(Session::has('warning'))
    <script type="text/javascript">
        $.notify({
        icon: 'glyphicon glyphicon-warning-sign',
          message: "{!! Session::get('warning') !!}"
        },{
          type: 'warning'
        });
    </script>
    @endif
<!--//message-->


<!--Module bottom -->
  @isset ($blocksContent['bottom'])
      @foreach ( $blocksContent['bottom']  as $layout)
        @php
          $arrPage = explode(',', $layout->page)
        @endphp
        @if ($layout->page == '*' ||  (isset($layout_page) && in_array($layout_page, $arrPage)))
          @if ($layout->type =='html')
            {!! $layout->text !!}
          @elseif($layout->type =='view')
            @if (view()->exists('block.'.$layout->text))
             @include('block.'.$layout->text)
            @endif
          @elseif($layout->type =='module')
            {!! sc_block_render($layout->text) !!}
          @endif
        @endif
      @endforeach
  @endisset
<!--//Module bottom -->
    <div id="loading">
          <div id="overlay" class="overlay"><i class="fa fa-spinner fa-pulse fa-5x fa-fw "></i></div>
   </div>
</body>
</html>
