import {
    ClassicEditor,
    Essentials,
    Bold,
    Italic,
    Underline,
    Strikethrough,
    Code,
    Subscript,
    Superscript,
    Font,
    Paragraph,
    Heading,
    BlockQuote,
    CodeBlock,
    Image,
    ImageCaption,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
    Link,
    LinkImage,
    List,
    TodoList,
    MediaEmbed,
    Table,
    TableToolbar,
    TableProperties,
    TableCellProperties,
    Indent,
    IndentBlock,
    Alignment,
    HorizontalLine,
    PageBreak,
    RemoveFormat,
    Highlight,
    SpecialCharacters,
    WordCount,
    SourceEditing,
    FindAndReplace,
    FontColor,
    FontBackgroundColor,
    FontFamily,
    FontSize,
    PasteFromOffice,
    AutoImage,
    AutoLink,
    Autoformat,
    TextPartLanguage,
    // Title,
    Widget,
    DragDrop,
} from "ckeditor5";

const editorConfig = {
    plugins: [
        Essentials,
        Bold,
        Italic,
        Underline,
        Strikethrough,
        Code,
        Subscript,
        Superscript,
        Font,
        FontColor,
        FontBackgroundColor,
        FontFamily,
        FontSize,
        Paragraph,
        Heading,
        BlockQuote,
        CodeBlock,
        Image,
        ImageToolbar,
        ImageCaption,
        ImageStyle,
        ImageResize,
        ImageUpload,
        Link,
        LinkImage,
        List,
        TodoList,
        MediaEmbed,
        Table,
        TableToolbar,
        TableProperties,
        TableCellProperties,
        Indent,
        IndentBlock,
        Alignment,
        HorizontalLine,
        PageBreak,
        RemoveFormat,
        Highlight,
        SpecialCharacters,
        WordCount,
        SourceEditing,
        FindAndReplace,
        PasteFromOffice,
        AutoImage,
        AutoLink,
        Autoformat,
        TextPartLanguage,
        // Title,
        Widget,
        DragDrop,
        SimpleUploadAdapterPlugin,
    ],
    toolbar: {
        items: [
            "undo",
            "redo",
            "|",
            "heading",
            "|",
            "fontfamily",
            "fontsize",
            "fontColor",
            "fontBackgroundColor",
            "|",
            "bold",
            "italic",
            "underline",
            "strikethrough",
            "code",
            "subscript",
            "superscript",
            "highlight",
            "removeFormat",
            "|",
            "alignment",
            "|",
            "numberedList",
            "bulletedList",
            "todoList",
            "outdent",
            "indent",
            "|",
            "link",
            "uploadImage",
            "imageStyle:inline",
            "imageStyle:wrapText",
            "imageStyle:breakText",
            "|",
            "insertTable",
            "mediaEmbed",
            "blockQuote",
            "codeBlock",
            "|",
            "horizontalLine",
            "pageBreak",
            "|",
            "specialCharacters",
            "|",
            "sourceEditing",
            "findAndReplace",
        ],
        shouldNotGroupWhenFull: true,
    },
    table: {
        contentToolbar: [
            "tableColumn",
            "tableRow",
            "mergeTableCells",
            "tableProperties",
            "tableCellProperties",
        ],
    },
    codeBlock: {
        languages: [
            { language: "plaintext", label: "Plain text", class: "" },
            { language: "php", label: "PHP", class: "php-code" },
            {
                language: "javascript",
                label: "JavaScript",
                class: "js javascript js-code",
            },
            { language: "python", label: "Python" },
        ],
    },
    image: {
        styles: [
            "full", 
            "side", 
            "alignLeft",
            "alignRight",
            "inline", 
            "breakText",
        ],
        toolbar: [
            "imageStyle:alignLeft",
            "imageStyle:alignRight",
            "imageStyle:inline",
            "imageStyle:wrapText",
            "imageStyle:breakText",
            "|",
            "imageTextAlternative",
            "toggleImageCaption",
            "linkImage",
        ],
        resizeOptions: [
            {
                name: "imageResize:original",
                value: null,
                icon: "original",
            },
            {
                name: "imageResize:50",
                value: "50",
                icon: "medium",
            },
            {
                name: "imageResize:75",
                value: "75",
                icon: "large",
            },
        ],
        insert: {
            type: "auto", // Automatically determine the best insertion type
        },
        upload: {
            types: ["jpeg", "png", "gif", "bmp", "webp", "tiff"],
            allowDragAndDrop: true,
        },
    },
    mediaEmbed: {
        previewsInData: true,
    },
};

function SimpleUploadAdapterPlugin(editor) {
    editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
        return new SimpleUploadAdapter(loader, editor);
    };
}

class SimpleUploadAdapter {
    constructor(loader, editor) {
        this.loader = loader;
        this.editor = editor;
    }

    upload() {
        return this.loader.file.then(
            (file) =>
                new Promise((resolve, reject) => {
                    const formData = new FormData();
                    formData.append("file", file);
                    formData.append("folderName", "description");
                    formData.append(
                        "_token",
                        document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content")
                    );

                    fetch("/admin/upload-file", {
                        method: "POST",
                        body: formData,
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            resolve({ default: data.path });
                        })
                        .catch(reject);
                })
        );
    }

    abort() {
        // Handle abort if needed
    }
}



export function initializeEditor(selector) {
    const element = document.querySelector(selector);

    if (!element) {
        console.error(`Element with selector "${selector}" not found.`);
        return;
    }

    if (element.ckeditorInstance) {
        element.ckeditorInstance
            .destroy()
            .then(() => {
                console.log("Previous CKEditor instance destroyed.");
                createEditor(element);
            })
            .catch((error) =>
                console.error("Error destroying CKEditor:", error)
            );
    } else {
        createEditor(element);
    }
}

function createEditor(element) {
    ClassicEditor.create(element, editorConfig)
        .then((editor) => {
            element.ckeditorInstance = editor;
            window.editorInstance = editor;

            const style = document.createElement("style");
            style.textContent = `
                .ck-content .image-style-align-left,
                .ck-content .image-style-align-right {
                    max-width: 50%;
                }
                .ck-content .image-style-align-left {
                    float: left;
                    margin-right: 1.5em;
                }
                .ck-content .image-style-align-right {
                    float: right;
                    margin-left: 1.5em;
                }
                .ck-content .image-style-inline {
                    display: inline-block;
                    vertical-align: middle;
                }
                .ck-content .image-style-wrap-text {
                    float: left;
                    margin-right: 1.5em;
                    margin-bottom: 1.5em;
                }
                .ck-content .image-style-break-text {
                    display: block;
                    margin: 1.5em auto;
                }
            `;
            document.head.appendChild(style);
        })
        .catch((error) => {
            console.error("CKEditor initialization error:", error);
        });
}

window.initializeEditor = initializeEditor;
