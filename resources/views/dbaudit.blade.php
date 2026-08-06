@inject('jaxon', Jaxon\Laravel\App\Jaxon::class)
@extends('layout')

@section('css')
  @jxnCss
@endsection

@section('js')
    @jxnJs

    @jxnScript
<script type='text/javascript'>
  @jxnPackage($package, 'ready');
</script>
@endsection

@section('content')
        <div class="container-fluid px-3">
          {!! $jaxon->package($package)->layout() !!}
        </div>
@endsection
