<form action="{{ route('indikator.copy') }}" method="POST">
    @csrf
    <label>Dari Periode</label>
    <select name="from_periode_id" required>
        @foreach($periodes as $periode)
            <option value="{{ $periode->id }}">{{ $periode->nama }} ({{ $periode->tahun }})</option>
        @endforeach
    </select>

    <label>Ke Periode</label>
    <select name="to_periode_id" required>
        @foreach($periodes as $periode)
            <option value="{{ $periode->id }}">{{ $periode->nama }} ({{ $periode->tahun }})</option>
        @endforeach
    </select>

    <button type="submit">Salin Template</button>
</form>
