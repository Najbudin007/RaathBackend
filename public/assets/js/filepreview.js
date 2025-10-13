(function() {
class FilePreview {
    constructor(selectors) {
        this.selectors = selectors;
        this.validImageTypes = ['jpeg', 'jpg', 'bmp', 'gif', 'svg', 'webp', 'png'];
        this.init();
    }

    init() {
        document.addEventListener("DOMContentLoaded", () => {
            this.selectors.forEach(({ inputSelector, imgContainer }) => {
                this.attachEvent(inputSelector, imgContainer);
            });
        });
    }

    attachEvent(inputSelector, imgContainer) {
        document.querySelectorAll(inputSelector).forEach(element => {
            element.addEventListener("change", (event) => this.handleFileChange(event, imgContainer));
        });
    }

    handleFileChange(event, imgContainer) {
        let fileInput = event.target;
        let file = fileInput.files[0];

        if (!file) return; // Exit if no file is selected

        let ext = file.name.split('.').pop().toLowerCase();
        if (!this.validImageTypes.includes(ext)) {
            alert('Invalid Image');
            fileInput.value = ''; // Clear the input
            return;
        }

        let fileName = file.name;
        let label = fileInput.closest(".custom-file")?.querySelector(".custom-file-label");
        if (label) {
            label.classList.add("selected");
            label.innerHTML = fileName;
        }

        let reader = new FileReader();
        reader.onload = (e) => {
            let imgElement = document.querySelector(imgContainer + " img");
            if (imgElement) {
                imgElement.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}
window.showFilePreview = FilePreview;

})();

