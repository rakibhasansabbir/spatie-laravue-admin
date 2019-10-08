@extends('layouts.adminator')

@section('container')
    <div class="container-fluid">
        @yield('content')
    </div>
@endsection
@push('js')
    {{-- <script>
        window.currency = "{{__('currency.sign')}}";
        @auth
            window.authId = "{{ auth()->id() }}";
            @role('admin')
                window.lenderId = "{{ auth()->user()->admin->id  }}";
            @endrole
        @endauth
    </script> --}}
@endpush

