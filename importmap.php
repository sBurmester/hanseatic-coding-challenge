<?php

/**
 * Returns the importmap for this application.
 *
 * - "path" is a path inside the asset mapper system. Use the
 *     "debug:asset-map" command to see the full list of paths.
 *
 * - "entrypoint" (JavaScript only) set to true for any module that will
 *     be used as an "entrypoint" (and passed to the importmap() Twig function).
 *
 * The "importmap:require" command can be used to add new entries to this file.
 */
return [
    'app' => [
        'path' => './assets/app.js',
        'entrypoint' => true,
    ],
    '@hotwired/stimulus' => [
        'version' => '3.2.2',
    ],
    '@symfony/stimulus-bundle' => [
        'path' => './vendor/symfony/stimulus-bundle/assets/dist/loader.js',
    ],
    '@hotwired/turbo' => [
        'version' => '7.3.0',
    ],
    '@reduxjs/toolkit/query/react' => [
        'version' => '2.2.5',
    ],
    '@reduxjs/toolkit/query' => [
        'version' => '2.2.5',
    ],
    '@reduxjs/toolkit' => [
        'version' => '2.2.5',
    ],
    'react' => [
        'version' => '18.3.1',
    ],
    'react-redux' => [
        'version' => '9.1.2',
    ],
    'reselect' => [
        'version' => '5.1.1',
    ],
    'immer' => [
        'version' => '10.1.1',
    ],
    'redux' => [
        'version' => '5.0.1',
    ],
    'redux-thunk' => [
        'version' => '3.1.0',
    ],
    'use-sync-external-store/with-selector.js' => [
        'version' => '1.2.2',
    ],
];
