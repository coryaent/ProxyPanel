@props([
    'style' => 'horizontal',
    'route' => null,
    'method' => 'POST',
    'model' => null,
    'handler' => 'Submit()',
    'attribute' => 'enctype="multipart/form-data"',
])

<form class="form-{{ $style }}" role="form" {{ $route ? "action=$route" : '' }} method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
      onsubmit="return {{ $handler }}" {{ $attribute }}>
    @if (!in_array($method, ['GET', 'POST']))
        @method($method)
    @endif
    @csrf
    {!! $slot !!}
</form>
