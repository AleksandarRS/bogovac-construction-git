'use strict';

$ = require('jquery');

const Navigation = require('./core/navigation');
const validInput = require('./site/valid-input');
const example = require('./site/example');

jQuery( function(){

  /**
   * Initialize site navigation
   */
  Navigation.init();

   /**
   * Initialize site navigation
   */
    validInput.init();

  /**
   * Initialize sample module
   */
  example.init();

});