$(document).ready(function () {
    const MediaLibrary = {
        currentFolder: '',
        currentImage: '',
        currentImageName: '',
        currentPath: '',
        currentItem: null,
        contextMenu: $('#context-menu'),
        init: function () {
            this.setupAjax();
            this.bindEvents();
            this.loadFolders();
            this.loadFiles();
            this.updateBreadcrumb();
        },

        setupAjax: function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        },

        bindEvents: function () {
            $('#create-folder').on('click', this.createFolder.bind(this));
            $('#upload-image-btn').on('click', () => $('#image-file').click());
            $('#image-file').on('change', this.uploadImage.bind(this));
            $('#folder-grid').on('click', '.folder-item', this.openFolder.bind(this));
            $('#breadcrumb').on('click', 'a', this.navigateBreadcrumb.bind(this));
            $('#images').on('dblclick', '.image-item', this.openImageModal.bind(this));
            $('#delete-image-btn').on('click', this.deleteImage.bind(this));
            $('#documents').on('click', '.delete-document-btn', this.deleteDocument.bind(this));
            $(document).on('click', () => $('#context-menu').hide());
            // $(document).on('contextmenu', '.folder-item', this.rightClick.bind(this));
            // $('#delete-folder').on('click', this.deleteFolderOption.bind(this));
        },

        showNotification: function (message, type) {
            const notification = $(`<div class="alert alert-${type}" role="alert">${message}</div>`);
            $('.content > .container').prepend(notification);
            setTimeout(() => notification.remove(), 3000);
        },

        showLoader: function () {
            $('#loader').removeClass('d-none');
        },

        hideLoader: function () {
            $('#loader').addClass('d-none');
        },

        loadFolders: function () {
            this.showLoader();
            $.get(`/admin/folders/${this.currentFolder}`)
                .done(data => {
                    $('#folder-grid').empty();
                    data.folders.forEach(folder => {
                        const folderName = folder.split('/').pop();
                        $('#folder-grid').append(this.createFolderHtml(folder, folderName));
                    });
                    this.hideLoader();
                })
                .fail(() => {
                    this.showNotification('Error loading folders', 'danger');
                    this.hideLoader();
                });
        },

        createFolderHtml: function (folder, folderName) {
            return `
                <div class="col-auto folder-item" data-folder="${folder}">
                    <i class=" ri-folder-2-fill icon folder-icon"></i>
                    <div class="item-name">${folderName}</div>
                    <div class="item-menu">
                        <i class="fas fa-ellipsis-v"></i>
                        <div class="item-menu-content">
                            <a href="#" class="move-item"><i class="fas fa-arrows-alt"></i> Move</a>
                            <a href="#" class="edit-item"><i class="fas fa-edit"></i> Rename</a>
                            <a href="#" class="delete-item"><i class="fas fa-trash-alt"></i> Delete</a>
                        </div>
                    </div>
                </div>
            `;
        },

        loadFiles: function () {
            this.showLoader();
            $.get(`/admin/files/${this.currentFolder}`)
                .done(data => {
                    $('#images').empty();
                    $('#documents').empty();
                    data.images.forEach(image => {
                        $('#images').append(this.createImageHtml(image));
                    });
                    data.documents.forEach(document => {
                        $('#documents').append(this.createDocumentHtml(document));
                    });
                    this.hideLoader();
                })
                .fail(() => {
                    this.showNotification('Error loading files', 'danger');
                    this.hideLoader();
                });
        },

        createImageHtml: function (image) {
            return `
                <img src="${image.path}" class="col-auto image-item img-thumbnail" data-bs-toggle="modal" data-image="${image.path}" data-image-name="${image.name}">
            `;
        },

        createDocumentHtml: function (document) {
            return `
                <div class="col-auto document-item" data-file="${document.name}">
                    // <div class="delete-document-btn">&times;</div>
                    <div class="document-icon">
                        <a href="${document.path}" download>
                            <img src="${document.icon}">
                        </a>
                    </div>
                </div>
            `;
        },

        updateBreadcrumb: function () {
            const path = this.currentFolder.split('/');
            $('#breadcrumb').empty().append('<li class="breadcrumb-item"><a href="#" data-path="">Home</a></li>');
            path.forEach((folder, index) => {
                if (folder) {
                    const fullPath = path.slice(0, index + 1).join('/');
                    $('#breadcrumb').append(`<li class="breadcrumb-item"><a href="#" data-path="${fullPath}">${folder}</a></li>`);
                }
            });
        },

        createFolder: function () {
            const folderName = $('#folder-name').val();
            if (!folderName) {
                this.showNotification('Folder name cannot be empty', 'danger');
                return;
            }
            const fullPath = this.currentFolder ? `${this.currentFolder}/${folderName}` : folderName;
            $.post('/admin/create-folder', { folderName: fullPath })
                .done(data => {
                    this.showNotification(data.message, 'success');
                    this.loadFolders();
                    $('#folder-name').val('');
                })
                .fail(err => {
                    if (err.status === 409) {
                        this.showNotification('Folder already exists', 'danger');
                    } else {
                        this.showNotification('Error creating folder', 'danger');
                    }
                });
        },

        uploadImage: function (event) {
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);
            formData.append('folderName', this.currentFolder);

            this.showLoader();
            $.ajax({
                url: '/admin/upload-image',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: data => {
                    this.showNotification(data.message, 'success');
                    this.loadFiles();
                    this.hideLoader();
                },
                error: () => {
                    this.showNotification('Error uploading image', 'danger');
                    this.hideLoader();
                }
            });
        },

        openFolder: function (event) {
            this.currentFolder = $(event.currentTarget).data('folder');
            this.loadFolders();
            this.loadFiles();
            this.updateBreadcrumb();
        },

        navigateBreadcrumb: function (event) {
            event.preventDefault();
            this.currentFolder = $(event.currentTarget).data('path');
            this.loadFolders();
            this.loadFiles();
            this.updateBreadcrumb();
        },

        openImageModal: function (event) {
            this.currentImage = $(event.currentTarget).data('image');
            this.currentImageName = $(event.currentTarget).data('image-name');
            $('#image-preview').attr('src', this.currentImage);
            $('#imageModal').modal('show');
        },
    
        rightClick: function (e) {
            e.preventDefault();
            this.currentItem = $(e.currentTarget);
            // this.currentPath = this.currentItem.data('folder');
            this.contextMenu.css({
                display: 'block',
                left: `${e.pageX}px`,
                top: `${e.pageY}px`
            });
        },

        // deleteFolderOption: function () {
        //     if (this.currentItem) {
        //         if (confirm('Are You Sure')) {
        //             let _this = this;
        //             _this.showLoader();
        //             $.post('/admin/delete-folder', {
        //                 folderName: this.currentPath
        //             }, function (data) {
        //                 _this.currentItem.remove();
        //                 _this.showNotification(data.message, 'success');
        //                 _this.loadFolders();
        //                 _this.hideLoader();
        //             }).fail(function (err) {
        //                 _this.showNotification(err.responseJSON.message, 'danger');
        //                 _this.hideLoader();
        //             });
        //         }
        //     }
        // },
        deleteImage: function () {
            if (!this.currentImageName) return;

            this.showLoader();
            $.post('/admin/delete-image', { image: this.currentImageName })
                .done(() => {
                    this.showNotification('Image deleted successfully', 'success');
                    this.loadFiles();
                    $('#imageModal').modal('hide');
                    this.hideLoader();
                })
                .fail(() => {
                    this.showNotification('Error deleting image', 'danger');
                    this.hideLoader();
                });
        },

        deleteDocument: function (event) {
            const document = $(event.currentTarget).closest('.document-item').data('file');
            this.showLoader();
            $.post('/admin/delete-document', { document: document })
                .done(() => {
                    this.showNotification('Document deleted successfully', 'success');
                    this.loadFiles();
                    this.hideLoader();
                })
                .fail(() => {
                    this.showNotification('Error deleting document', 'danger');
                    this.hideLoader();
                });
        }



    };

    MediaLibrary.init();
});