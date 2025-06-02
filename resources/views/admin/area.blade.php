@extends('layouts.app')

@section('content')
<div>
    <div class="text-[#0E4A64] mb-6">
        <div class="font-bold text-xl mb-1">Dashboard</div>
        <p class="text-sm font-medium">Hi {{ Auth::user()->name }}, welcome back in {{ $areaName }}</p>
    </div>

    <div class="bg-white rounded-md p-8 min-h-[300px]">
        <ul>
            @foreach($menu as $menuKey => $subMenus)
                <li class="mb-2">
                    <strong>{{ ucfirst($menuKey) }}</strong>
                    <ul class="ml-4 list-disc">
                        @foreach($subMenus as $subKey => $subName)
                            <li>
                                <a href="{{ route($areaKey . '.' . $menuKey) }}" class="text-blue-600 hover:underline">
                                    {{ $subName }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection
