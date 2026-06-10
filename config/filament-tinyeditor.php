<?php

return [
    'version' => [
        'tiny' => '7.3.0',
        'language' => [
            // https://cdn.jsdelivr.net/npm/tinymce-i18n@latest/
            'version' => '24.7.29',
            'package' => 'langs7',
        ],
        'licence_key' => env('TINY_LICENSE_KEY', 'no-api-key'),
    ],
    'provider' => 'vendor', // cloud|vendor
    // 'direction' => 'rtl',
    /**
     * change darkMode: 'auto'|'force'|'class'|'media'|false|'custom'
     */
    'darkMode' => 'auto',

    /** cutsom */
    'skins' => [
        // oxide, oxide-dark, tinymce-5, tinymce-5-dark
        'ui' => 'oxide',

        // dark, default, document, tinymce-5, tinymce-5-dark, writer
        'content' => 'default'
    ],

    'profiles' => [
        'default' => [
            'plugins' => 'accordion autoresize codesample directionality advlist link image lists preview pagebreak searchreplace wordcount code fullscreen insertdatetime media table emoticons',
            'toolbar' => 'undo redo removeformat | fontfamily fontsize fontsizeinput font_size_formats styles | bold italic underline | rtl ltr | alignjustify alignleft aligncenter alignright | numlist bullist outdent indent | forecolor backcolor | blockquote table toc hr | image link media codesample emoticons | wordcount fullscreen',
            'upload_directory' => null,
            'custom_configs' => [
                'content_css' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:wght@300;400;500;600;700;800&family=Oswald:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@300;400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap'
            ]
        ],

        'simple' => [
            'plugins' => 'autoresize directionality emoticons link wordcount',
            'toolbar' => 'removeformat | bold italic | rtl ltr | numlist bullist | link emoticons',
            'upload_directory' => null,
        ],

        'minimal' => [
            'plugins' => 'link wordcount',
            'toolbar' => 'bold italic link numlist bullist',
            'upload_directory' => null,
        ],

        'full' => [
            'plugins' => 'accordion autoresize codesample directionality advlist autolink link image lists charmap preview anchor pagebreak searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media table emoticons help',
            'toolbar' => 'undo redo removeformat | fontfamily fontsize fontsizeinput font_size_formats styles | bold italic underline | rtl ltr | alignjustify alignright aligncenter alignleft | numlist bullist outdent indent accordion | forecolor backcolor | blockquote table toc hr | image link anchor media codesample emoticons | visualblocks print preview wordcount fullscreen help',
            'upload_directory' => null,
            'custom_configs' => [
                'content_css' => 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Lora:ital,wght@0,400..700;1,400..700&family=Montserrat:wght@300;400;500;600;700;800&family=Oswald:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Poppins:wght@300;400;500;600;700;800&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap'
            ]
        ],
    ],

    /**
     * this option will load optional language file based on you app locale
     * example:
     * languages => [
     *      'fa' => 'https://cdn.jsdelivr.net/npm/tinymce-i18n@24.7.29/langs7/fa.min.js',
     *      'es' => 'https://cdn.jsdelivr.net/npm/tinymce-i18n@24.7.29/langs7/es.min.js',
     *      'ja' => asset('assets/ja.min.js')
     * ]
     */
    'languages' => [],

    'extra' => [
        'toolbar' => [
            // 'fontsize' => '10px 12px 13px 14px 16px 18px 20px',
            'fontfamily' => 'System Sans-Serif=system-ui,-apple-system,sans-serif;Arial=arial,helvetica,sans-serif;Baskerville=Baskerville,Playfair Display,serif;Bookman=Bookman Old Style,Georgia,serif;Brush Script MT=Brush Script MT,Brush Script Std,cursive;Comic Sans MS=Comic Sans MS,Comic Sans,sans-serif;Courier New=Courier New,Courier,monospace;Garamond=Garamond,Baskerville,serif;Georgia=Georgia,Times New Roman,serif;Helvetica=Helvetica,Arial,sans-serif;Impact=Impact,Charcoal,sans-serif;Inter=Inter,sans-serif;Lora=Lora,serif;Montserrat=Montserrat,sans-serif;Oswald=Oswald,sans-serif;Playfair Display=Playfair Display,serif;Poppins=Poppins,sans-serif;Roboto=Roboto,sans-serif;Segoe UI=Segoe UI,sans-serif;Tahoma=Tahoma,Verdana,sans-serif;Times New Roman=Times New Roman,Times,serif;Trebuchet MS=Trebuchet MS,Lucida Grande,sans-serif;Verdana=Verdana,Geneva,sans-serif;',
        ]
    ]
];
