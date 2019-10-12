@extends('layouts.backend')
@section('title', 'Dashboard')
@section('content')
    <permission-index></permission-index>
@endsection
@section('route')
    <script>
        try {
            window.route = "{{ route('backend.api.permission.index')  }}"
            window.webRoute = "{{ route('backend.permission.index')  }}"
        } catch (e) {
            console.warning('Something happened to set route')
        }
    </script>
@endsection
