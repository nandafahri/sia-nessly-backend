@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <h3 class="mb-4">QR Control Panel</h3>

    <style>
        /* Fade-in animation */
        .fade-in {
            animation: fadeIn 0.7s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Generate QR Manual</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label>Mapel</label>
                    <select id="mapel_id" class="form-control">
                        <option value="">-- pilih mapel --</option>
                        @foreach($mapels as $m)
                            <option value="{{ $m->id }}">{{ $m->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Kelas</label>
                    <select id="kelas_id" class="form-control">
                        <option value="">-- pilih kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label>Jam Mulai</label>
                    <input type="time" id="jam_mulai" class="form-control">
                </div>

                <div class="col-md-2">
                    <label>Jam Selesai</label>
                    <input type="time" id="jam_selesai" class="form-control">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button id="btnGenerate" class="btn btn-primary w-100">Generate QR</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Loading Spinner --}}
    <div id="loading" class="text-center mb-4" style="display:none;">
        <div class="spinner-border text-primary" role="status" style="width: 3.2rem; height: 3.2rem;"></div>
        <p class="mt-2">Generating QR...</p>
    </div>

    {{-- Hasil QR --}}
    <div id="qrResult" class="text-center mb-4" style="display: none;">
        <h5>QR Code Berhasil Dibuat</h5>
        <img id="qrImage" alt="QR Code" class="mb-2"/>
        <p><b>URL:</b> <span id="qrUrl"></span></p>
        <button id="btnCopyUrl" class="btn btn-outline-primary btn-sm mb-2">Copy URL</button>
        <button id="btnDownloadPng" class="btn btn-outline-success btn-sm mb-2">Download PNG</button>
    </div>
</div>

<script>
// BUTTON GENERATE
document.getElementById('btnGenerate').addEventListener('click', function(){

    const mapel = document.getElementById('mapel_id').value;
    const kelas = document.getElementById('kelas_id').value;
    const mulai = document.getElementById('jam_mulai').value;
    const selesai = document.getElementById('jam_selesai').value;

    // VALIDASI SWEETALERT
    if(!mapel || !kelas || !mulai || !selesai){
        Swal.fire({
            icon: 'warning',
            title: 'Data belum lengkap',
            text: 'Semua form harus diisi sebelum generate QR!',
        });
        return;
    }

    const btn = document.getElementById('btnGenerate');
    btn.disabled = true;
    btn.textContent = "Generating...";

    const formData = new FormData();
    formData.append('mapel_id', mapel);
    formData.append('kelas_id', kelas);
    formData.append('jam_mulai', mulai);
    formData.append('jam_selesai', selesai);

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.getElementById('loading').style.display = 'block';
    document.getElementById('qrResult').style.display = 'none';

    fetch('/admin/generate-qr', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': token },
        body: formData
    })
    .then(res => res.json())
    .then(res => {

        document.getElementById('loading').style.display = 'none';
        btn.disabled = false;
        btn.textContent = "Generate QR";

        if(res.success){

            // SweetAlert success
            Swal.fire({
                icon: 'success',
                title: 'QR Berhasil Dibuat!',
                text: 'QR Code telah berhasil dibuat.',
                timer: 1500,
                showConfirmButton: false
            });

            const qrResult = document.getElementById('qrResult');
            const qrImage = document.getElementById('qrImage');

            qrResult.style.display = 'block';
            qrResult.classList.add("fade-in");

            qrImage.src = res.qr;
            document.getElementById('qrUrl').textContent = res.url;
        }
    })
    .catch(err => {
        document.getElementById('loading').style.display = 'none';
        btn.disabled = false;
        btn.textContent = "Generate QR";

        console.error(err);

        // SweetAlert error
        Swal.fire({
            icon: 'error',
            title: 'Gagal Generate QR',
            text: 'Terjadi masalah pada server.',
        });
    });

});

// COPY URL
document.getElementById('btnCopyUrl').addEventListener('click', function(){
    const url = document.getElementById('qrUrl').textContent;

    navigator.clipboard.writeText(url).then(() => {
        Swal.fire({
            icon: 'success',
            title: 'URL Disalin!',
            text: 'URL berhasil disalin ke clipboard.',
            timer: 1300,
            showConfirmButton: false
        });
    });
});

</script>
@endsection
