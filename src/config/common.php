<?php
return [

    'components' =>
    [
        'dadataSuggest' => [
            'class'             => 'skeeks\cms\dadataSuggest\CmsDadataSuggestComponent',
        ],

        'dadataSuggestApi' => [
            'class'             => 'skeeks\cms\dadataSuggest\CmsDadataSuggestApi',
        ],

        'i18n' => [
            'translations' =>
            [
                'skeeks/dadata-suggest' => [
                    'class'             => 'yii\i18n\PhpMessageSource',
                    'basePath'          => '@skeeks/cms/dadataSuggest/messages',
                    'fileMap' => [
                        'skeeks/dadata-suggest' => 'main.php',
                    ],
                ]
            ]
        ]
    ],


];