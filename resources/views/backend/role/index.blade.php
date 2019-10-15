@extends('layouts.backend')
@section('title', 'Dashboard')
@section('content')
    <role-index></role-index>
@endsection
@section('route')
    <script>
        try {
            window.route = "{{ route('backend.api.role.index')  }}"
            window.permissionRoute = "{{ route('backend.api.permission.index')  }}"
            window.webRoute = "{{ route('backend.role.index')  }}"
        } catch (e) {
            console.warning('Something happened to set route')
        }
    </script>
@endsection
