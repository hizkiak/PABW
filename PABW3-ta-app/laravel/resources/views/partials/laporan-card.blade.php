<div class="card">
    <h3>Pelapor: {{ $laporan['nama'] }}</h3>
    <p><strong>Lokasi Kejadian:</strong> {{ $laporan['lokasi'] }}</p>
    <p><strong>Tinggi Genangan Air:</strong> {{ $laporan['tinggi'] }} cm</p>
    <p>
        <strong>Status Genangan:</strong>
        @if($laporan['tinggi'] < 30)
            <span class="badge badge-waspada">Waspada</span>
        @elseif($laporan['tinggi'] >= 30 && $laporan['tinggi'] <= 70)
            <span class="badge badge-siaga">Siaga</span>
        @else
            <span class="badge badge-awas">Awas</span>
        @endif
    </p>
</div>