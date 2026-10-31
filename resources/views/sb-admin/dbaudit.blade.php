@extends('sb-admin.layout')

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
          {!! $di->g($ui)->layout() !!}
        </div>
@endsection
