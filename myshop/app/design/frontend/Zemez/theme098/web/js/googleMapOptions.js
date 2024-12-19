define([
    'jquery',
    'jquery/ui',
    'googleMapPagePlugin'
], function($, mageTemplate ,pluginTemplate) {
    'use strict';

    $.widget('Zemez.googleMapOptions', $.Zemez.googleMapPagePlugin, {

        options: {
            contactSelector: '.google-map-wrapper'
        },

        _create: function() {
            this._super();
        }

    });

    return $.Zemez.googleMapOptions;
});