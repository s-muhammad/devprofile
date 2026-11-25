import {
    Alignment,
    AutoImage,
    AutoLink,
    BlockQuote,
    Bold,
    ClassicEditor,
    Code,
    CodeBlock,
    Essentials,
    FindAndReplace,
    FontBackgroundColor,
    FontColor,
    FontFamily,
    FontSize,
    Fullscreen,
    GeneralHtmlSupport,
    Heading,
    Highlight,
    HorizontalLine,
    Image,
    ImageCaption,
    ImageInsertViaUrl,
    ImageResize,
    ImageStyle,
    ImageToolbar,
    Indent,
    IndentBlock,
    Italic,
    Link,
    LinkImage,
    List,
    ListProperties,
    MediaEmbed,
    Paragraph,
    PasteFromOffice,
    RemoveFormat,
    ShowBlocks,
    SourceEditing,
    SpecialCharacters,
    SpecialCharactersEssentials,
    Strikethrough,
    Subscript,
    Superscript,
    Table,
    TableCellProperties,
    TableProperties,
    TableToolbar,
    TextTransformation,
    TodoList,
    Underline
} from 'ckeditor5';

import faTranslations from 'ckeditor5/translations/fa.js';
import 'ckeditor5/ckeditor5.css';

/**
 * فیلدهایی که باید به ویرایشگر متن غنی تبدیل شوند.
 */
const EDITOR_SELECTORS = '#mytextarea, #content';

const EDITOR_CONFIG = {
    licenseKey: 'GPL',
    language: {
        ui: 'fa',
        content: 'fa'
    },
    translations: [faTranslations],
    plugins: [
        Alignment,
        AutoImage,
        AutoLink,
        BlockQuote,
        Bold,
        Code,
        CodeBlock,
        Essentials,
        FindAndReplace,
        FontBackgroundColor,
        FontColor,
        FontFamily,
        FontSize,
        Fullscreen,
        GeneralHtmlSupport,
        Heading,
        Highlight,
        HorizontalLine,
        Image,
        ImageCaption,
        ImageInsertViaUrl,
        ImageResize,
        ImageStyle,
        ImageToolbar,
        Indent,
        IndentBlock,
        Italic,
        Link,
        LinkImage,
        List,
        ListProperties,
        MediaEmbed,
        Paragraph,
        PasteFromOffice,
        RemoveFormat,
        ShowBlocks,
        SourceEditing,
        SpecialCharacters,
        SpecialCharactersEssentials,
        Strikethrough,
        Subscript,
        Superscript,
        Table,
        TableCellProperties,
        TableProperties,
        TableToolbar,
        TextTransformation,
        TodoList,
        Underline
    ],
    toolbar: {
        items: [
            'undo', 'redo',
            '|',
            'heading',
            '|',
            'bold', 'italic', 'underline', 'strikethrough', 'code', 'subscript', 'superscript', 'removeFormat',
            '|',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight',
            '|',
            'alignment',
            '|',
            'bulletedList', 'numberedList', 'todoList',
            '|',
            'outdent', 'indent',
            '|',
            'link', 'blockQuote', 'insertTable', 'mediaEmbed', 'codeBlock', 'horizontalLine', 'specialCharacters',
            '|',
            'findAndReplace', 'sourceEditing', 'showBlocks', 'fullscreen'
        ],
        shouldNotGroupWhenFull: false
    },
    image: {
        toolbar: [
            'imageStyle:inline', 'imageStyle:block', 'imageStyle:side',
            '|',
            'toggleImageCaption', 'imageTextAlternative',
            '|',
            'resizeImage', 'linkImage'
        ]
    },
    table: {
        contentToolbar: [
            'tableColumn', 'tableRow', 'mergeTableCells',
            'tableProperties', 'tableCellProperties', 'toggleTableCaption'
        ]
    },
    htmlSupport: {
        allow: [
            {
                name: /^(p|div|span|h[1-6]|ul|ol|li|dl|dt|dd|a|img|table|thead|tbody|tfoot|tr|th|td|caption|colgroup|col|blockquote|pre|code|hr|br|strong|b|em|i|u|s|del|ins|sub|sup|figure|figcaption|iframe|video|audio|source|mark)$/,
                attributes: [
                    'href', 'src', 'alt', 'title', 'width', 'height', 'class', 'style',
                    'target', 'rel', 'colspan', 'rowspan', 'dir', 'lang', 'datetime',
                    'controls', 'allow', 'allowfullscreen', 'frameborder', 'loading'
                ],
                classes: true,
                styles: true
            }
        ]
    }
};

function isEmpty(editor) {
    return editor.getData().replace(/<[^>]*>/g, '').replace(/&nbsp;/g, ' ').trim() === '';
}

/**
 * اعتبارسنجی سمت کلاینت برای فیلدهای اجباری.
 * چون CKEditor مقدار textarea را تنها هنگام submit همگام می‌کند،
 * ویژگی required از textarea حذف و به‌صورت دستی بررسی می‌شود.
 */
function attachRequiredValidation(editor, textarea) {
    const form = textarea.form;

    if (!form) {
        return;
    }

    const message = document.createElement('p');
    message.className = 'mt-2 text-sm text-red-600 hidden';
    message.textContent = 'پر کردن این فیلد الزامی است.';

    const container = editor.ui.getEditableElement()?.closest('.ck-editor');
    (container || textarea).insertAdjacentElement('afterend', message);

    const validate = () => {
        const invalid = isEmpty(editor);
        message.classList.toggle('hidden', !invalid);

        return !invalid;
    };

    form.addEventListener('submit', (event) => {
        if (!validate()) {
            event.preventDefault();
            editor.editing.view.focus();
        }
    });

    editor.model.document.on('change:data', () => {
        if (!message.classList.contains('hidden')) {
            validate();
        }
    });
}

function initEditor(textarea) {
    const isRequired = textarea.hasAttribute('required');

    if (isRequired) {
        textarea.removeAttribute('required');
    }

    ClassicEditor
        .create({
            ...EDITOR_CONFIG,
            attachTo: textarea
        })
        .then((editor) => {
            if (isRequired) {
                attachRequiredValidation(editor, textarea);
            }
        })
        .catch((error) => {
            console.error('CKEditor initialization failed:', error);
        });
}

function initEditors() {
    document.querySelectorAll(EDITOR_SELECTORS).forEach(initEditor);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initEditors);
} else {
    initEditors();
}
