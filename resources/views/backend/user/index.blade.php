@extends('layouts.backend')
@section('title', 'Dashboard')
@section('content')
    <user-index></user-index>
@endsection
@section('route')
    <script>
        try {
            window.route = "{{ route('backend.api.user.index')  }}"
            window.roleRoute = "{{ route('backend.api.role.list')  }}"
            window.webRoute = "{{ route('backend.user.index')  }}"
        } catch (e) {
            console.warning('Something happened to set route')
        }
    </script>
@endsection
