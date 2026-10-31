@extends('bulma.layout')

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
        <div style="padding-right: 1rem; padding-left: 1rem;">
          {!! $di->g($ui)->layout() !!}
        </div>
@endsection
