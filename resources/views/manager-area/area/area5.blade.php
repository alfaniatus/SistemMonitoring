@extends('manager-area.dashboard')

@section('title', 'Dashboard Area 1')

@section('content')
    <h1>{{ $areaName }}</h1>
    <p>Ini halaman untuk {{ $areaCode }}</p>
@endsection
