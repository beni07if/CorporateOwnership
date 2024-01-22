@foreach($subsidiaries as $subsidiary)
    <a href="{{ url('/subsidiary/' . $subsidiary->id) }}">
        {{ $subsidiary->name }}
    </a>
@endforeach
