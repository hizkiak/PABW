<div class="mb-3">

    <label for="judul" class="form-label">
        Judul Buku
    </label>

    <input
        type="text"
        name="judul"
        id="judul"
        class="form-control @error('judul') is-invalid @enderror"
        value="{{ old('judul', $buku->judul ?? '') }}"
        placeholder="Masukkan judul buku"
        required
    >

    @error('judul')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="mb-3">

    <label for="penulis" class="form-label">
        Penulis
    </label>

    <input
        type="text"
        name="penulis"
        id="penulis"
        class="form-control @error('penulis') is-invalid @enderror"
        value="{{ old('penulis', $buku->penulis ?? '') }}"
        placeholder="Masukkan nama penulis"
        required
    >

    @error('penulis')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="mb-3">

    <label for="penerbit" class="form-label">
        Penerbit
    </label>

    <input
        type="text"
        name="penerbit"
        id="penerbit"
        class="form-control @error('penerbit') is-invalid @enderror"
        value="{{ old('penerbit', $buku->penerbit ?? '') }}"
        placeholder="Masukkan nama penerbit"
        required
    >

    @error('penerbit')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror

</div>

<div class="row">

    <div class="col-md-6 mb-3">

        <label for="tahun_terbit" class="form-label">
            Tahun Terbit
        </label>

        <input
            type="number"
            name="tahun_terbit"
            id="tahun_terbit"
            class="form-control @error('tahun_terbit') is-invalid @enderror"
            value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}"
            min="1900"
            max="{{ date('Y') }}"
            placeholder="Contoh: 2024"
            required
        >

        @error('tahun_terbit')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

    <div class="col-md-6 mb-3">

        <label for="stok" class="form-label">
            Stok Buku
        </label>

        <input
            type="number"
            name="stok"
            id="stok"
            class="form-control @error('stok') is-invalid @enderror"
            value="{{ old('stok', $buku->stok ?? 0) }}"
            min="0"
            placeholder="Masukkan jumlah stok"
            required
        >

        @error('stok')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    </div>

</div>