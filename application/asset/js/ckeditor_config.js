/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */
CKEDITOR.editorConfig = function( config ) {
    // Define changes to default configuration here.
    // For complete reference see:
    // http://docs.ckeditor.com/#!/api/CKEDITOR.config

    config.toolbar = [
                      { "name" : "advanced", "items" : 
                          ['Source', '-', 
                           'Link', 'Unlink', 'Anchor', '-', 
                           'Format', 'Styles', 'PasteFromWord'
                           ]
                      },
                      "/",
                      { "items" : 
                          ['Bold', 'Italic', 'Underline', 'Strike', '-',
                           'NumberedList', 'BulletedList', 'Indent', 'Outdent', 'Blockquote', '-',
                           'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'
                          ]
                      }
                     ];

    // Use the 'flat' skin.
    config.skin = 'flat';

    // Disable content filtering
    config.allowedContent = true;
};

