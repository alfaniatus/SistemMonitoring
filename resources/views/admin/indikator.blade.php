@extends('layouts.app')

@section('content')
    <div class="bg-white rounded-md px-3 py-4 shadow">
        <form action="#" method="GET" class="flex justify-end gap-4 items-center">
            <div>
                <select name="tahun" class="border px-4 py-2 rounded focus:outline-none">
                    @foreach ($tahunList as $tahun)
                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-[#146082] text-white px-4 py-2 rounded hover:bg-[#104b66] text-sm font-medium">
                SET
            </button>
        </form>
    </div>
      <div class="bg-white rounded-md p-6 min-h-[300px] shadow mt-6">

      </div>
@endsection
