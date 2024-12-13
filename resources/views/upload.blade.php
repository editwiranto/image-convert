<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Converter Image</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <h1 class="text-center" style="margin-top:20px;">Convert Image</h1>
    <div class="container rounded-2">
        <div class="card border-0">
            <div class="card-header bg-primary text-white fs-5">
                Isi Data
            </div>
            <form id="imageForm" enctype="multipart/form-data" class="row g-3 d-flex justify-content-between">
                <div>
                    <div class="col-auto" style="margin-bottom:20px;">
                        <label for="image">Choose Image:</label>
                        <input type="file" id="image" name="image" required class="form-control">
                    </div>

                    <div class="col-auto" style="margin-bottom:20px;">
                        <label for="nama">Nama File : </label>
                        <input type="text" name="name" class="form-control">
                    </div>

                    <div class="col-auto" style="margin-bottom:20px;">
                        <label for="format">Convert To:</label>
                        <select id="format" name="format" required class="form-control">
                            <option value="" selected>--- Selected ---</option>
                            <option value="jpeg">JPEG</option>
                            <option value="png">PNG</option>
                            <option value="jpg">JPG</option>
                            <option value="webp">WebP</option>
                        </select>
                    </div>
                    <div class="col-auto" style="margin-bottom:20px;">
                        <label for="width">Width (px):</label>
                        <input type="number" id="width" name="width" min="10" required
                            class="form-control">
                    </div>

                    <div class="col-auto" style="margin-bottom:20px;">
                        <label for="height">Height (px):</label>
                        <input type="number" id="height" name="height" min="10" required
                            class="form-control">
                    </div>


                    <div class="col-auto" style="margin-bottom:20px;">
                        <div id="jpeg-container" style="display:none;">
                            <label for="jpeg">JPEG Compression Quality (0-100):</label>
                            <input type="number" name="jpeg" id="jpeg" min="0" max="100"
                                value="75" class="form-control">
                        </div>

                        <div id="png-container" style="display:none;">
                            <label for="png">PNG Compression Quality (0-9):</label>
                            <input type="number" name="png" id="png" min="0" max="9"
                                value="9" class="form-control">
                        </div>

                        <div id="jpg-container" style="display:none;">
                            <label for="jpg">JPG Compression Quality (0-100):</label>
                            <input type="number" name="jpg" id="jpg" min="0" max="100"
                                value="75" class="form-control">
                        </div>

                        <div id="webp-container" style="display:none;">
                            <label for="webp">WebP Compression Quality (0-100):</label>
                            <input type="number" name="webp" id="webp" min="0" max="100"
                                value="75" class="form-control">

                        </div>
                    </div>
                    <div class="d-flex justify-content-md-end">
                        <button type="submit" class="btn btn-outline-primary col-2">Convert & Resize Image</button>
                    </div>
                </div>



            </form>
        </div>
        <div class="tombol d-flex">
            <div class="belum-convert d-flex flex-column" style="margin-right: 20px;">
                <samp>Sebelum Convert : </samp>
                <button id="toggleButtonSebelum" class="btn btn-dark">Tampilkan Detail Gambar</button>
            </div>
            <div class="sudah-convert d-flex flex-column" style="margin-right: 20px;">
                <samp>Sesudah Convert : </samp>
                <button id="toggleButtonSesudah" class="btn btn-dark">Tampilkan Detail Gambar</button>
            </div>
            <div id="paksaWidth" class="d-flex flex-column">
                <samp>Paksa Lebar : </samp>
                <button id="toggleButtonPaksa" class="btn btn-dark">Tampilkan Form Paksa Gambar</button>
            </div>
        </div>
    </div>
    <div id="paksa-gambar" class="bg-white p-3 mx-3" style="margin-top: 50px;margin-left:15px;">
        <h1>Paksa Ukuran Gambar</h1>
        <form action="" id="paksaResize">
            <div class="mb-3">
                <label for="formGroupExampleInput" class="form-label">Width (px)</label>
                <input type="text" class="form-control" id="widthPX">
            </div>
            <div class="mb-3">
                <label for="formGroupExampleInput2" class="form-label">Height (px)</label>
                <input type="text" class="form-control" id="heightPX">
            </div>
            <div class="d-flex justify-content-md-end">
                <button type="submit" class="btn btn-secondary col-2 p-2">Secondary</button>
            </div>
        </form>
    </div>
    <div id="hasil" class="mx-3 bg-white p-3 mt-3" style="margin-bottom:30px;">
        <h3>Hasil Convert : </h3>
        <div id="result" class="mx-3"></div>
    </div>

    <div class="bg-white mx-3 p-3 rounded">
        <div id="imageDetails">
            <h3>Detail Image Before Convert :</h3>

            <div class="detail-p d-flex flex-column" style="margin-bottom: 20px;margin-left:15px;">
                <samp id="fileName"></samp>
                <samp id="fileSize"></samp>
                <samp id="imageDimensions"></samp>
            </div>
            <img id="previewImage" style="margin-left:15px;">
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        const form = document.getElementById('imageForm');
        const result = document.getElementById('result');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(form);
            const response = await fetch("{{ route('image.convert') }}", {
                method: "POST",
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            const data = await response.json();
            if (response.ok) {
                result.innerHTML = `
                    <div class="d-flex flex-column">
                        <samp>File Name : ${data.fileName}</samp>
                        <samp>File Size : ${data.fileSize} Kb</samp>
                        <samp>Width : ${data.width} px</samp>
                        <samp>Heigh : ${data.height} px</samp>
                        <samp><a href="${data.url}" class="mb-3 fs-4" download>Download Image</a></samp>
                    </div>
                    <img src="${data.url}" alt="Converted Image" id="imageView">
                `;
            } else {
                result.innerHTML = `<p>Error: ${data.message}</p>`;
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
