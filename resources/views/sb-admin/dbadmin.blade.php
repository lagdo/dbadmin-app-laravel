@inject('jaxon', Jaxon\Laravel\App\Jaxon::class)
@extends('sb-admin.layout')

@section('css')
  @jxnCss
@endsection

@section('js')
  @jxnJs

  @jxnScript
<script type='text/javascript'>
  @jxnPackage(Lagdo\DbAdmin\App\DbAdminPackage::class, 'ready');
</script>
@endsection

@section('content')
        <div class="container-fluid px-3">
          {!! $jaxon->package(Lagdo\DbAdmin\App\DbAdminPackage::class)->layout() !!}
        </div>
@endsection
