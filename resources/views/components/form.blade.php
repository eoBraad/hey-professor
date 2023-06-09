@props(['action', 'post' => null, 'put' => null, 'delete' => null])

<div>
    <form action="{{ $action }}" method="post" {{ $attributes }}>
        @csrf


        @if ($put)
            @method('PUT')
        @endif

        @if ($put)
            @method('DELETE')
        @endif

        {{ $slot }}
    </form>
</div>
