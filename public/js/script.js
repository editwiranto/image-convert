
// { { --menampilakn size gambar-- } }



    const fileInput = document.getElementById('image');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const imageDimensions = document.getElementById('imageDimensions');
    const previewImage = document.getElementById('previewImage');
    const imageDetails = document.getElementById('imageDetails');
    const toggleButtonSebelum = document.getElementById('toggleButtonSebelum');
    const toggleButtonSesudah = document.getElementById('toggleButtonSesudah');
    const hasilToggle = document.getElementById('hasil');

    // imageDetails.style.display = 'none';
    // hasilToggle.style.display = 'none';

    toggleButtonSebelum.addEventListener('click', function () {
         if (imageDetails.style.display === 'none') {
            imageDetails.style.display = 'block';
        } else {
            imageDetails.style.display = 'none';
        }
    })

    toggleButtonSesudah.addEventListener('click', function () {
        if (hasilToggle.style.display === 'none') {
            hasilToggle.style.display = 'block';
        } else {
            hasilToggle.style.display = 'none';
        }
    });

    // const resultaa = document.getElementById('result');

    // resultaa.addEventListener('change', function (event) {
    //     console.log(event);
    // });

    //data di bawah untuk ketika sudah choose file maka munculkan data gambar nya langsung
    image.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            //menampilkan nama file
            fileName.textContent = `Nama File : ${file.name}`;

            //menampilkan ukuran file dalam KB
            const sizeInKB = (file.size / 1024).toFixed(2);
            fileSize.textContent = `Ukuran File : ${sizeInKB} Kb`;
            const reader = new FileReader();

            reader.onload = function(e) {
                // Menampilkan gambar preview
                previewImage.src = e.target.result;

                // Setelah gambar dimuat, dapatkan dimensinya
                const image = new Image();
                image.src = e.target.result;

                image.onload = function() {
                    imageDimensions.innerHTML = `Dimensi = <br>Width : <span>${image.width}</span> px <br>Height : <span>${image.height}</span> px`;
                };
            };
            reader.readAsDataURL(file);
        } else {
            fileName.textContent = '';
            fileSize.textContent = '';
            imageDimensions.textContent = '';
            previewImage.src = '';
        }
    });

//jika option click jpg maka yang muncul hanya jpg
function toggleMuncul() {
    const formatInput = document.getElementById('format').value;
    const jpegInput = document.getElementById('jpeg-container');
    const pngInput = document.getElementById('png-container');
    const jpgInput = document.getElementById('jpg-container');
    const webpInput = document.getElementById('webp-container');

        jpegInput.style.display = 'none';
        jpgInput.style.display = 'none';
        pngInput.style.display = 'none';
        webpInput.style.display = 'none';

    if (formatInput === 'jpeg') {
        jpegInput.style.display = 'block';
    } else if (formatInput === 'jpg') {
        jpgInput.style.display = 'block';
    } else if (formatInput === 'png') {
        pngInput.style.display = 'block';
    } else if (formatInput === 'webp'){
        webpInput.style.display = 'block';
    }
}

// Call the function on page load to set the default visibility
window.onload = toggleMuncul;
document.getElementById('format').addEventListener('change', toggleMuncul);



const paksaGambar = document.getElementById('paksa-gambar');
const paksaWidth = document.getElementById('paksaWidth');
const paksaResize = document.getElementById('paksaResize');

    paksaGambar.style.display = 'none';

    paksaWidth.addEventListener('click', function () {
        if (paksaGambar.style.display === 'none') {
            paksaGambar.style.display = 'block';
        } else {
            paksaGambar.style.display = 'none';
        }
    });

paksaResize.addEventListener('submit', function (e) {
    e.preventDefault();

    const widthPX = document.getElementById('widthPX').value;
    const heightPX = document.getElementById('heightPX').value;


    const imageView = document.getElementById('imageView');

    if (imageView) {
        imageView.style.width = `${widthPX}px`;
        imageView.style.width = `${heightPX}px`;
    }
});


