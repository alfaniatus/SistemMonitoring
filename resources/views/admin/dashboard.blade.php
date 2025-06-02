@extends('layouts.app')

@section('content')
<div class="text-[#0E4A64] mb-6">
  <div class="font-bold text-xl mb-1">Dashboard</div>
  <p class="text-sm font-medium">hi admin, welcome back</p>
</div>

<div class="bg-white rounded-sm border-gray-200 p-3">
 
 @include('components.tabel-penilaian')
</div>
@endsection
