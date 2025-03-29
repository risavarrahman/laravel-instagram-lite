import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

const fileInput = document.getElementById("dropzone-file");
const previewImage = document.getElementById("preview-image");
const previewVideo = document.getElementById("preview-video");
const filePreview = document.getElementById("file-preview");
const selectFile = document.getElementById("delete-while-preview");

fileInput.addEventListener("change", function () {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            const fileType = file.type;

            if (fileType.startsWith("image/")) {
                previewImage.src = e.target.result;
                previewImage.style.display = "block";
                previewVideo.style.display = "none";
                selectFile.style.display = "none";
            } else if (fileType.startsWith("video/")) {
                previewVideo.src = e.target.result;
                previewVideo.style.display = "block";
                previewImage.style.display = "none";
                selectFile.style.display = "none";
            }

            filePreview.classList.remove("hidden");
        };

        reader.readAsDataURL(file);
    } else {
        previewImage.src = "";
        previewVideo.src = "";
        selectFile.style.display = "";
        previewImage.style.display = "none";
        previewVideo.style.display = "none";
        filePreview.classList.add("hidden");
    }
});
