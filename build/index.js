/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _assets_scss_style_scss__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../assets/scss/style.scss */ "./assets/scss/style.scss");
/* harmony import */ var _modules_zmain__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./modules/zmain */ "./src/modules/zmain.js");
/* harmony import */ var _modules_anchor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/anchor */ "./src/modules/anchor.js");
/* harmony import */ var _modules_target_blank__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modules/target_blank */ "./src/modules/target_blank.js");
/* harmony import */ var _modules_timeBar__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./modules/timeBar */ "./src/modules/timeBar.js");
/* harmony import */ var _modules_recommendation__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./modules/recommendation */ "./src/modules/recommendation.js");






const zmain = new _modules_zmain__WEBPACK_IMPORTED_MODULE_1__["default"]();
const anchor = new _modules_anchor__WEBPACK_IMPORTED_MODULE_2__["default"]();
const targetBlank = new _modules_target_blank__WEBPACK_IMPORTED_MODULE_3__["default"]();
const timeBar = new _modules_timeBar__WEBPACK_IMPORTED_MODULE_4__["default"]();
const recommendation = new _modules_recommendation__WEBPACK_IMPORTED_MODULE_5__["default"]();

/***/ }),

/***/ "./src/modules/anchor.js":
/*!*******************************!*\
  !*** ./src/modules/anchor.js ***!
  \*******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
class Ancher {
  constructor() {
    var headings = document.querySelectorAll('.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6');

    for (var i = 0; i < headings.length; i++) {
      if (headings[i].getAttribute('id')) {
        var img = document.createElement('img');
        img.setAttribute('src', ashad.assets_url + '/img/link-symbol.svg');
        var a = document.createElement('a');
        a.setAttribute('href', '#' + headings[i].getAttribute('id'));
        a.classList.add('anchor');
        a.appendChild(img);
        headings[i].insertBefore(a, headings[i].firstChild);
      }
    }
  }

}

/* harmony default export */ __webpack_exports__["default"] = (Ancher);

/***/ }),

/***/ "./src/modules/classie.js":
/*!********************************!*\
  !*** ./src/modules/classie.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/*!
 * classie - class helper functions
 * from bonzo https://github.com/ded/bonzo
 * 
 * classie.has( elem, 'my-class' ) -> true/false
 * classie.add( elem, 'my-new-class' )
 * classie.remove( elem, 'my-unwanted-class' )
 * classie.toggle( elem, 'my-class' )
 */

/*jshint browser: true, strict: true, undef: true */

/*global define: false */
// class helper functions from bonzo https://github.com/ded/bonzo
function classReg(className) {
  return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
} // classList support for class management
// altho to be fair, the api sucks because it won't accept multiple classes at once


var hasClass, addClass, removeClass;

if ('classList' in document.documentElement) {
  hasClass = function (elem, c) {
    return elem.classList.contains(c);
  };

  addClass = function (elem, c) {
    elem.classList.add(c);
  };

  removeClass = function (elem, c) {
    elem.classList.remove(c);
  };
} else {
  hasClass = function (elem, c) {
    return classReg(c).test(elem.className);
  };

  addClass = function (elem, c) {
    if (!hasClass(elem, c)) {
      elem.className = elem.className + ' ' + c;
    }
  };

  removeClass = function (elem, c) {
    elem.className = elem.className.replace(classReg(c), ' ');
  };
}

function toggleClass(elem, c) {
  var fn = hasClass(elem, c) ? removeClass : addClass;
  fn(elem, c);
}

var classie = {
  // full names
  hasClass: hasClass,
  addClass: addClass,
  removeClass: removeClass,
  toggleClass: toggleClass,
  // short names
  has: hasClass,
  add: addClass,
  remove: removeClass,
  toggle: toggleClass
}; // transport
// if ( typeof define === 'function' && define.amd ) {
//   // AMD
//   define( classie );
// } else {
//   // browser global
//   window.classie = classie;
// }

/* harmony default export */ __webpack_exports__["default"] = (classie);

/***/ }),

/***/ "./src/modules/ouibounce.js":
/*!**********************************!*\
  !*** ./src/modules/ouibounce.js ***!
  \**********************************/
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_RESULT__;(function (root, factory) {
  if (true) {
    !(__WEBPACK_AMD_DEFINE_FACTORY__ = (factory),
		__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
		(__WEBPACK_AMD_DEFINE_FACTORY__.call(exports, __webpack_require__, exports, module)) :
		__WEBPACK_AMD_DEFINE_FACTORY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else {}
})(this, function (require, exports, module) {
  return function ouibounce(el, custom_config) {
    "use strict";

    var config = custom_config || {},
        aggressive = config.aggressive || false,
        sensitivity = setDefault(config.sensitivity, 20),
        timer = setDefault(config.timer, 1000),
        delay = setDefault(config.delay, 0),
        callback = config.callback || function () {},
        cookieExpire = setDefaultCookieExpire(config.cookieExpire) || '',
        cookieDomain = config.cookieDomain ? ';domain=' + config.cookieDomain : '',
        cookieName = config.cookieName ? config.cookieName : 'viewedOuibounceModal',
        sitewide = config.sitewide === true ? ';path=/' : '',
        _delayTimer = null,
        _html = document.documentElement;

    function setDefault(_property, _default) {
      return typeof _property === 'undefined' ? _default : _property;
    }

    function setDefaultCookieExpire(days) {
      // transform days to milliseconds
      var ms = days * 24 * 60 * 60 * 1000;
      var date = new Date();
      date.setTime(date.getTime() + ms);
      return "; expires=" + date.toUTCString();
    }

    setTimeout(attachOuiBounce, timer);

    function attachOuiBounce() {
      if (isDisabled()) {
        return;
      }

      _html.addEventListener('mouseleave', handleMouseleave);

      _html.addEventListener('mouseenter', handleMouseenter);

      _html.addEventListener('keydown', handleKeydown);
    }

    function handleMouseleave(e) {
      if (e.clientY > sensitivity) {
        return;
      }

      _delayTimer = setTimeout(fire, delay);
    }

    function handleMouseenter() {
      if (_delayTimer) {
        clearTimeout(_delayTimer);
        _delayTimer = null;
      }
    }

    var disableKeydown = false;

    function handleKeydown(e) {
      if (disableKeydown) {
        return;
      } else if (!e.metaKey || e.keyCode !== 76) {
        return;
      }

      disableKeydown = true;
      _delayTimer = setTimeout(fire, delay);
    }

    function checkCookieValue(cookieName, value) {
      return parseCookies()[cookieName] === value;
    }

    function parseCookies() {
      // cookies are separated by '; '
      var cookies = document.cookie.split('; ');
      var ret = {};

      for (var i = cookies.length - 1; i >= 0; i--) {
        var el = cookies[i].split('=');
        ret[el[0]] = el[1];
      }

      return ret;
    }

    function isDisabled() {
      return checkCookieValue(cookieName, 'true') && !aggressive;
    } // You can use ouibounce without passing an element
    // https://github.com/carlsednaoui/ouibounce/issues/30


    function fire() {
      if (isDisabled()) {
        return;
      }

      if (el) {
        el.style.display = 'block';
      }

      callback();
      disable();
    }

    function disable(custom_options) {
      var options = custom_options || {}; // you can pass a specific cookie expiration when using the OuiBounce API
      // ex: _ouiBounce.disable({ cookieExpire: 5 });

      if (typeof options.cookieExpire !== 'undefined') {
        cookieExpire = setDefaultCookieExpire(options.cookieExpire);
      } // you can pass use sitewide cookies too
      // ex: _ouiBounce.disable({ cookieExpire: 5, sitewide: true });


      if (options.sitewide === true) {
        sitewide = ';path=/';
      } // you can pass a domain string when the cookie should be read subdomain-wise
      // ex: _ouiBounce.disable({ cookieDomain: '.example.com' });


      if (typeof options.cookieDomain !== 'undefined') {
        cookieDomain = ';domain=' + options.cookieDomain;
      }

      if (typeof options.cookieName !== 'undefined') {
        cookieName = options.cookieName;
      }

      document.cookie = cookieName + '=true' + cookieExpire + cookieDomain + sitewide; // remove listeners

      _html.removeEventListener('mouseleave', handleMouseleave);

      _html.removeEventListener('mouseenter', handleMouseenter);

      _html.removeEventListener('keydown', handleKeydown);
    }

    return {
      fire: fire,
      disable: disable,
      isDisabled: isDisabled
    };
  }
  /*exported ouibounce */
  ;
});

/***/ }),

/***/ "./src/modules/recommendation.js":
/*!***************************************!*\
  !*** ./src/modules/recommendation.js ***!
  \***************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
class recommendation {
  constructor() {
    this.recommendation = document.querySelector('.recommendation');
    this.isVisible = false;
    this.timeOut;
    this.events();
  }

  events() {
    if (this.recommendation) {
      // Back to top button
      var goBackToTop = this.recommendation.querySelector('.message button');
      goBackToTop.addEventListener('click', this.backToTop.bind(this)); // Hide

      document.addEventListener('stillReading', this.hide.bind(this), false); // Show

      document.addEventListener('finishedReading', this.show.bind(this), false);
    }
  }

  backToTop() {
    this.scrollToTop();
    return false;
  }

  hide(elem) {
    if (this.isVisible) {
      this.recommendation.style.bottom = '-100%';
      this.isVisible = false;
    }
  }

  show(elem) {
    if (!this.isVisible) {
      this.recommendation.style.bottom = '0%';
      this.isVisible = true;
    }
  }

  scrollToTop() {
    console.log(this);

    if (document.body.scrollTop != 0 || document.documentElement.scrollTop != 0) {
      window.scrollBy(0, -50);
      this.timeOut = setTimeout(this.scrollToTop.bind(this), 10);
    } else clearTimeout(this.timeOut);
  }

}

/* harmony default export */ __webpack_exports__["default"] = (recommendation);

/***/ }),

/***/ "./src/modules/scrollanimation.js":
/*!****************************************!*\
  !*** ./src/modules/scrollanimation.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _classie__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./classie */ "./src/modules/classie.js");
/**
 * animOnScroll.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2013, Codrops
 * http://www.codrops.com
 */


(function (window) {
  'use strict';

  var docElem = window.document.documentElement;

  function getViewportH() {
    var client = docElem['clientHeight'],
        inner = window['innerHeight'];
    if (client < inner) return inner;else return client;
  }

  function scrollY() {
    return window.pageYOffset || docElem.scrollTop;
  } // http://stackoverflow.com/a/5598797/989439


  function getOffset(el) {
    var offsetTop = 0,
        offsetLeft = 0;

    do {
      if (!isNaN(el.offsetTop)) {
        offsetTop += el.offsetTop;
      }

      if (!isNaN(el.offsetLeft)) {
        offsetLeft += el.offsetLeft;
      }
    } while (el = el.offsetParent);

    return {
      top: offsetTop,
      left: offsetLeft
    };
  }

  function inViewport(el, h) {
    var elH = el.offsetHeight,
        scrolled = scrollY(),
        viewed = scrolled + getViewportH(),
        elTop = getOffset(el).top,
        elBottom = elTop + elH,
        // if 0, the element is considered in the viewport as soon as it enters.
    // if 1, the element is considered in the viewport only when it's fully inside
    // value in percentage (1 >= h >= 0)
    h = h || 0;
    return elTop + elH * h <= viewed && elBottom - elH * h >= scrolled;
  }

  function extend(a, b) {
    for (var key in b) {
      if (b.hasOwnProperty(key)) {
        a[key] = b[key];
      }
    }

    return a;
  }

  function loadImageUrl(img) {
    if (img) {
      var image = new Image();

      image.onload = function () {
        img.src = image.src;
      };

      image.src = img.getAttribute('data-url');
    }
  }

  function AnimOnScroll(el, options) {
    this.el = el;
    this.options = extend(this.defaults, options);

    this._init();
  }

  AnimOnScroll.prototype = {
    defaults: {
      // Minimum and a maximum duration of the animation (random value is chosen)
      minDuration: 0,
      maxDuration: 0,
      // The viewportFactor defines how much of the appearing item has to be visible in order to trigger the animation
      // if we'd use a value of 0, this would mean that it would add the animation class as soon as the item is in the viewport. 
      // If we were to use the value of 1, the animation would only be triggered when we see all of the item in the viewport (100% of it)
      viewportFactor: 0
    },
    _init: function () {
      this.items = Array.prototype.slice.call(document.querySelectorAll('#' + this.el.id + ' > article'));
      this.itemsCount = this.items.length;
      this.itemsRenderedCount = 0;
      this.didScroll = false;
      var self = this; // the items already shown...

      self.items.forEach(function (el, i) {
        if (inViewport(el)) {
          self._checkTotalRendered();

          _classie__WEBPACK_IMPORTED_MODULE_0__["default"].add(el, 'shown');
          loadImageUrl(el.querySelector('.preload'));
        }
      }); // animate on scroll the items inside the viewport

      window.addEventListener('scroll', function () {
        self._onScrollFn();
      }, false);
      window.addEventListener('resize', function () {
        self._resizeHandler();
      }, false);
    },
    _onScrollFn: function () {
      var self = this;

      if (!this.didScroll) {
        this.didScroll = true;
        setTimeout(function () {
          self._scrollPage();
        }, 60);
      }
    },
    _scrollPage: function () {
      var self = this;
      this.items.forEach(function (el, i) {
        if (!_classie__WEBPACK_IMPORTED_MODULE_0__["default"].has(el, 'shown') && !_classie__WEBPACK_IMPORTED_MODULE_0__["default"].has(el, 'animate') && inViewport(el, self.options.viewportFactor)) {
          setTimeout(function () {
            var perspY = scrollY() + getViewportH() / 2;
            self.el.style.WebkitPerspectiveOrigin = '50% ' + perspY + 'px';
            self.el.style.MozPerspectiveOrigin = '50% ' + perspY + 'px';
            self.el.style.perspectiveOrigin = '50% ' + perspY + 'px';

            self._checkTotalRendered();

            if (self.options.minDuration && self.options.maxDuration) {
              var randDuration = Math.random() * (self.options.maxDuration - self.options.minDuration) + self.options.minDuration + 's';
              el.style.WebkitAnimationDuration = randDuration;
              el.style.MozAnimationDuration = randDuration;
              el.style.animationDuration = randDuration;
            }

            _classie__WEBPACK_IMPORTED_MODULE_0__["default"].add(el, 'animate');
            loadImageUrl(el.querySelector('.preload'));
          }, 25);
        }
      });
      this.didScroll = false;
    },
    _resizeHandler: function () {
      var self = this;

      function delayed() {
        self._scrollPage();

        self.resizeTimeout = null;
      }

      if (this.resizeTimeout) {
        clearTimeout(this.resizeTimeout);
      }

      this.resizeTimeout = setTimeout(delayed, 1000);
    },
    _checkTotalRendered: function () {
      ++this.itemsRenderedCount;

      if (this.itemsRenderedCount === this.itemsCount) {
        window.removeEventListener('scroll', this._onScrollFn);
      }
    }
  }; // add to global namespace

  window.AnimOnScroll = AnimOnScroll;
})(window);

/***/ }),

/***/ "./src/modules/smoothscroll.js":
/*!*************************************!*\
  !*** ./src/modules/smoothscroll.js ***!
  \*************************************/
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_FACTORY__, __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
 * smooth-scroll v7.1.1: Animate scrolling to anchor links
 * (c) 2015 Chris Ferdinandi
 * MIT License
 * http://github.com/cferdinandi/smooth-scroll
 */
(function (root, factory) {
  if (true) {
    !(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_FACTORY__ = (factory(root)),
		__WEBPACK_AMD_DEFINE_RESULT__ = (typeof __WEBPACK_AMD_DEFINE_FACTORY__ === 'function' ?
		(__WEBPACK_AMD_DEFINE_FACTORY__.apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__)) : __WEBPACK_AMD_DEFINE_FACTORY__),
		__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
  } else {}
})(typeof __webpack_require__.g !== 'undefined' ? __webpack_require__.g : this.window || this.global, function (root) {
  'use strict'; //
  // Variables
  //

  var smoothScroll = {}; // Object for public APIs

  var supports = 'querySelector' in document && 'addEventListener' in root; // Feature test

  var settings, eventTimeout, fixedHeader, headerHeight; // Default settings

  var defaults = {
    selector: '[data-scroll]',
    selectorHeader: '[data-scroll-header]',
    speed: 500,
    easing: 'easeInOutCubic',
    offset: 0,
    updateURL: true,
    callback: function () {}
  }; //
  // Methods
  //

  /**
   * Merge two or more objects. Returns a new object.
   * @private
   * @param {Boolean}  deep     If true, do a deep (or recursive) merge [optional]
   * @param {Object}   objects  The objects to merge together
   * @returns {Object}          Merged values of defaults and options
   */

  var extend = function () {
    // Variables
    var extended = {};
    var deep = false;
    var i = 0;
    var length = arguments.length; // Check if a deep merge

    if (Object.prototype.toString.call(arguments[0]) === '[object Boolean]') {
      deep = arguments[0];
      i++;
    } // Merge the object into the extended object


    var merge = function (obj) {
      for (var prop in obj) {
        if (Object.prototype.hasOwnProperty.call(obj, prop)) {
          // If deep merge and property is an object, merge properties
          if (deep && Object.prototype.toString.call(obj[prop]) === '[object Object]') {
            extended[prop] = extend(true, extended[prop], obj[prop]);
          } else {
            extended[prop] = obj[prop];
          }
        }
      }
    }; // Loop through each object and conduct a merge


    for (; i < length; i++) {
      var obj = arguments[i];
      merge(obj);
    }

    return extended;
  };
  /**
   * Get the height of an element.
   * @private
   * @param  {Node} elem The element to get the height of
   * @return {Number}    The element's height in pixels
   */


  var getHeight = function (elem) {
    return Math.max(elem.scrollHeight, elem.offsetHeight, elem.clientHeight);
  };
  /**
   * Get the closest matching element up the DOM tree.
   * @private
   * @param  {Element} elem     Starting element
   * @param  {String}  selector Selector to match against (class, ID, data attribute, or tag)
   * @return {Boolean|Element}  Returns null if not match found
   */


  var getClosest = function (elem, selector) {
    // Variables
    var firstChar = selector.charAt(0);
    var supports = ('classList' in document.documentElement);
    var attribute, value; // If selector is a data attribute, split attribute from value

    if (firstChar === '[') {
      selector = selector.substr(1, selector.length - 2);
      attribute = selector.split('=');

      if (attribute.length > 1) {
        value = true;
        attribute[1] = attribute[1].replace(/"/g, '').replace(/'/g, '');
      }
    } // Get closest match


    for (; elem && elem !== document; elem = elem.parentNode) {
      // If selector is a class
      if (firstChar === '.') {
        if (supports) {
          if (elem.classList.contains(selector.substr(1))) {
            return elem;
          }
        } else {
          if (new RegExp('(^|\\s)' + selector.substr(1) + '(\\s|$)').test(elem.className)) {
            return elem;
          }
        }
      } // If selector is an ID


      if (firstChar === '#') {
        if (elem.id === selector.substr(1)) {
          return elem;
        }
      } // If selector is a data attribute


      if (firstChar === '[') {
        if (elem.hasAttribute(attribute[0])) {
          if (value) {
            if (elem.getAttribute(attribute[0]) === attribute[1]) {
              return elem;
            }
          } else {
            return elem;
          }
        }
      } // If selector is a tag


      if (elem.tagName.toLowerCase() === selector) {
        return elem;
      }
    }

    return null;
  };
  /**
   * Escape special characters for use with querySelector
   * @private
   * @param {String} id The anchor ID to escape
   * @author Mathias Bynens
   * @link https://github.com/mathiasbynens/CSS.escape
   */


  var escapeCharacters = function (id) {
    var string = String(id);
    var length = string.length;
    var index = -1;
    var codeUnit;
    var result = '';
    var firstCodeUnit = string.charCodeAt(0);

    while (++index < length) {
      codeUnit = string.charCodeAt(index); // Note: there’s no need to special-case astral symbols, surrogate
      // pairs, or lone surrogates.
      // If the character is NULL (U+0000), then throw an
      // `InvalidCharacterError` exception and terminate these steps.

      if (codeUnit === 0x0000) {
        throw new InvalidCharacterError('Invalid character: the input contains U+0000.');
      }

      if ( // If the character is in the range [\1-\1F] (U+0001 to U+001F) or is
      // U+007F, […]
      codeUnit >= 0x0001 && codeUnit <= 0x001F || codeUnit == 0x007F || // If the character is the first character and is in the range [0-9]
      // (U+0030 to U+0039), […]
      index === 0 && codeUnit >= 0x0030 && codeUnit <= 0x0039 || // If the character is the second character and is in the range [0-9]
      // (U+0030 to U+0039) and the first character is a `-` (U+002D), […]
      index === 1 && codeUnit >= 0x0030 && codeUnit <= 0x0039 && firstCodeUnit === 0x002D) {
        // http://dev.w3.org/csswg/cssom/#escape-a-character-as-code-point
        result += '\\' + codeUnit.toString(16) + ' ';
        continue;
      } // If the character is not handled by one of the above rules and is
      // greater than or equal to U+0080, is `-` (U+002D) or `_` (U+005F), or
      // is in one of the ranges [0-9] (U+0030 to U+0039), [A-Z] (U+0041 to
      // U+005A), or [a-z] (U+0061 to U+007A), […]


      if (codeUnit >= 0x0080 || codeUnit === 0x002D || codeUnit === 0x005F || codeUnit >= 0x0030 && codeUnit <= 0x0039 || codeUnit >= 0x0041 && codeUnit <= 0x005A || codeUnit >= 0x0061 && codeUnit <= 0x007A) {
        // the character itself
        result += string.charAt(index);
        continue;
      } // Otherwise, the escaped character.
      // http://dev.w3.org/csswg/cssom/#escape-a-character


      result += '\\' + string.charAt(index);
    }

    return result;
  };
  /**
   * Calculate the easing pattern
   * @private
   * @link https://gist.github.com/gre/1650294
   * @param {String} type Easing pattern
   * @param {Number} time Time animation should take to complete
   * @returns {Number}
   */


  var easingPattern = function (type, time) {
    var pattern;
    if (type === 'easeInQuad') pattern = time * time; // accelerating from zero velocity

    if (type === 'easeOutQuad') pattern = time * (2 - time); // decelerating to zero velocity

    if (type === 'easeInOutQuad') pattern = time < 0.5 ? 2 * time * time : -1 + (4 - 2 * time) * time; // acceleration until halfway, then deceleration

    if (type === 'easeInCubic') pattern = time * time * time; // accelerating from zero velocity

    if (type === 'easeOutCubic') pattern = --time * time * time + 1; // decelerating to zero velocity

    if (type === 'easeInOutCubic') pattern = time < 0.5 ? 4 * time * time * time : (time - 1) * (2 * time - 2) * (2 * time - 2) + 1; // acceleration until halfway, then deceleration

    if (type === 'easeInQuart') pattern = time * time * time * time; // accelerating from zero velocity

    if (type === 'easeOutQuart') pattern = 1 - --time * time * time * time; // decelerating to zero velocity

    if (type === 'easeInOutQuart') pattern = time < 0.5 ? 8 * time * time * time * time : 1 - 8 * --time * time * time * time; // acceleration until halfway, then deceleration

    if (type === 'easeInQuint') pattern = time * time * time * time * time; // accelerating from zero velocity

    if (type === 'easeOutQuint') pattern = 1 + --time * time * time * time * time; // decelerating to zero velocity

    if (type === 'easeInOutQuint') pattern = time < 0.5 ? 16 * time * time * time * time * time : 1 + 16 * --time * time * time * time * time; // acceleration until halfway, then deceleration

    return pattern || time; // no easing, no acceleration
  };
  /**
   * Calculate how far to scroll
   * @private
   * @param {Element} anchor The anchor element to scroll to
   * @param {Number} headerHeight Height of a fixed header, if any
   * @param {Number} offset Number of pixels by which to offset scroll
   * @returns {Number}
   */


  var getEndLocation = function (anchor, headerHeight, offset) {
    var location = 0;

    if (anchor.offsetParent) {
      do {
        location += anchor.offsetTop;
        anchor = anchor.offsetParent;
      } while (anchor);
    }

    location = location - headerHeight - offset;
    return location >= 0 ? location : 0;
  };
  /**
   * Determine the document's height
   * @private
   * @returns {Number}
   */


  var getDocumentHeight = function () {
    return Math.max(root.document.body.scrollHeight, root.document.documentElement.scrollHeight, root.document.body.offsetHeight, root.document.documentElement.offsetHeight, root.document.body.clientHeight, root.document.documentElement.clientHeight);
  };
  /**
   * Convert data-options attribute into an object of key/value pairs
   * @private
   * @param {String} options Link-specific options as a data attribute string
   * @returns {Object}
   */


  var getDataOptions = function (options) {
    return !options || !(typeof JSON === 'object' && typeof JSON.parse === 'function') ? {} : JSON.parse(options);
  };
  /**
   * Update the URL
   * @private
   * @param {Element} anchor The element to scroll to
   * @param {Boolean} url Whether or not to update the URL history
   */


  var updateUrl = function (anchor, url) {
    if (root.history.pushState && (url || url === 'true') && root.location.protocol !== 'file:') {
      root.history.pushState(null, null, [root.location.protocol, '//', root.location.host, root.location.pathname, root.location.search, anchor].join(''));
    }
  };

  var getHeaderHeight = function (header) {
    return header === null ? 0 : getHeight(header) + header.offsetTop;
  };
  /**
   * Start/stop the scrolling animation
   * @public
   * @param {Element} toggle The element that toggled the scroll event
   * @param {Element} anchor The element to scroll to
   * @param {Object} options
   */


  smoothScroll.animateScroll = function (toggle, anchor, options) {
    // Options and overrides
    var overrides = getDataOptions(toggle ? toggle.getAttribute('data-options') : null);
    var settings = extend(settings || defaults, options || {}, overrides); // Merge user options with defaults

    anchor = '#' + escapeCharacters(anchor.substr(1)); // Escape special characters and leading numbers
    // Selectors and variables

    var anchorElem = anchor === '#' ? root.document.documentElement : root.document.querySelector(anchor);
    var startLocation = root.pageYOffset; // Current location on the page

    if (!fixedHeader) {
      fixedHeader = root.document.querySelector(settings.selectorHeader);
    } // Get the fixed header if not already set


    if (!headerHeight) {
      headerHeight = getHeaderHeight(fixedHeader);
    } // Get the height of a fixed header if one exists and not already set


    var endLocation = getEndLocation(anchorElem, headerHeight, parseInt(settings.offset, 10)); // Scroll to location

    var animationInterval; // interval timer

    var distance = endLocation - startLocation; // distance to travel

    var documentHeight = getDocumentHeight();
    var timeLapsed = 0;
    var percentage, position; // Update URL

    updateUrl(anchor, settings.updateURL);
    /**
     * Stop the scroll animation when it reaches its target (or the bottom/top of page)
     * @private
     * @param {Number} position Current position on the page
     * @param {Number} endLocation Scroll to location
     * @param {Number} animationInterval How much to scroll on this loop
     */

    var stopAnimateScroll = function (position, endLocation, animationInterval) {
      var currentLocation = root.pageYOffset;

      if (position == endLocation || currentLocation == endLocation || root.innerHeight + currentLocation >= documentHeight) {
        clearInterval(animationInterval);
        anchorElem.focus();
        settings.callback(toggle, anchor); // Run callbacks after animation complete
      }
    };
    /**
     * Loop scrolling animation
     * @private
     */


    var loopAnimateScroll = function () {
      timeLapsed += 16;
      percentage = timeLapsed / parseInt(settings.speed, 10);
      percentage = percentage > 1 ? 1 : percentage;
      position = startLocation + distance * easingPattern(settings.easing, percentage);
      root.scrollTo(0, Math.floor(position));
      stopAnimateScroll(position, endLocation, animationInterval);
    };
    /**
     * Set interval timer
     * @private
     */


    var startAnimateScroll = function () {
      animationInterval = setInterval(loopAnimateScroll, 16);
    };
    /**
     * Reset position to fix weird iOS bug
     * @link https://github.com/cferdinandi/smooth-scroll/issues/45
     */


    if (root.pageYOffset === 0) {
      root.scrollTo(0, 0);
    } // Start scrolling animation


    startAnimateScroll();
  };
  /**
   * If smooth scroll element clicked, animate scroll
   * @private
   */


  var eventHandler = function (event) {
    var toggle = getClosest(event.target, settings.selector);

    if (toggle && toggle.tagName.toLowerCase() === 'a') {
      event.preventDefault(); // Prevent default click event

      smoothScroll.animateScroll(toggle, toggle.hash, settings); // Animate scroll
    }
  };
  /**
   * On window scroll and resize, only run events at a rate of 15fps for better performance
   * @private
   * @param  {Function} eventTimeout Timeout function
   * @param  {Object} settings
   */


  var eventThrottler = function (event) {
    if (!eventTimeout) {
      eventTimeout = setTimeout(function () {
        eventTimeout = null; // Reset timeout

        headerHeight = getHeaderHeight(fixedHeader); // Get the height of a fixed header if one exists
      }, 66);
    }
  };
  /**
   * Destroy the current initialization.
   * @public
   */


  smoothScroll.destroy = function () {
    // If plugin isn't already initialized, stop
    if (!settings) return; // Remove event listeners

    root.document.removeEventListener('click', eventHandler, false);
    root.removeEventListener('resize', eventThrottler, false); // Reset varaibles

    settings = null;
    eventTimeout = null;
    fixedHeader = null;
    headerHeight = null;
  };
  /**
   * Initialize Smooth Scroll
   * @public
   * @param {Object} options User settings
   */


  smoothScroll.init = function (options) {
    // feature test
    if (!supports) return; // Destroy any existing initializations

    smoothScroll.destroy(); // Selectors and variables

    settings = extend(defaults, options || {}); // Merge user options with defaults

    fixedHeader = root.document.querySelector(settings.selectorHeader); // Get the fixed header

    headerHeight = getHeaderHeight(fixedHeader); // When a toggle is clicked, run the click handler

    root.document.addEventListener('click', eventHandler, false);

    if (fixedHeader) {
      root.addEventListener('resize', eventThrottler, false);
    }
  }; //
  // Public APIs
  //


  return smoothScroll;
});

/***/ }),

/***/ "./src/modules/target_blank.js":
/*!*************************************!*\
  !*** ./src/modules/target_blank.js ***!
  \*************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
class TargetBlank {
  constructor() {
    var links = document.links;

    for (var i = 0, linksLength = links.length; i < linksLength; i++) {
      if (links[i].hostname != window.location.hostname) {
        links[i].target = '_blank';
      }
    }
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TargetBlank);

/***/ }),

/***/ "./src/modules/timeBar.js":
/*!********************************!*\
  !*** ./src/modules/timeBar.js ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
class TimeBar {
  constructor() {
    this.post = document.querySelector('.post-content');
    this.timeBar = document.querySelector('.time-bar');
    this.shouldShow = true;

    if (this.post && this.timeBar) {
      this.lastScrollTop = 0;
      this.maxScrollTop = this.post.scrollHeight;
      this.completed = this.timeBar.querySelector('.completed');
      this.remaining = this.timeBar.querySelector('.remaining');
      this.timeCompleted = this.timeBar.querySelector('.time-completed');
      this.timeRemaining = this.timeBar.querySelector('.time-remaining');
      document.addEventListener('scroll', this.scrollFunction.bind(this));
    }
  }

  scrollFunction() {
    this.scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (this.scrollTop > this.lastScrollTop && this.shouldShow) {
      this.timeBar.style.bottom = '0%';
    } else {
      this.timeBar.style.bottom = '-100%';
    }

    if (this.scrollTop <= this.maxScrollTop) {
      var percentage = this.scrollTop / this.maxScrollTop;
      var completedVal = (percentage * 100).toFixed(2);
      var remainingVal = 100 - parseFloat(completedVal);
      this.completed.style.width = completedVal.toString() + '%';
      this.remaining.style.width = remainingVal.toString() + '%';
      var totalSeconds = parseInt(this.timeBar.getAttribute('data-minutes')) * 60;
      var completedTime = parseInt(percentage * totalSeconds);
      var completedMin = parseInt(completedTime / 60);
      var completedSec = parseInt((completedTime / 60 - completedMin) * 60);
      var remainingTime = totalSeconds - completedTime;
      var remainingMin = parseInt(remainingTime / 60);
      var remainingSec = parseInt((remainingTime / 60 - remainingMin) * 60);
      completedMin = completedMin < 10 ? '0' + completedMin : completedMin;
      completedSec = completedSec < 10 ? '0' + completedSec : completedSec;
      remainingMin = remainingMin < 10 ? '0' + remainingMin : remainingMin;
      remainingSec = remainingSec < 10 ? '0' + remainingSec : remainingSec;
      this.timeCompleted.innerText = completedMin + ':' + completedSec;
      this.timeRemaining.innerText = remainingMin + ':' + remainingSec;
      this.shouldShow = true;
      this.triggerStillReading();
    } else {
      this.completed.style.width = '100%';
      this.remaining.style.width = '0%';
      var minutes = parseInt(this.timeBar.getAttribute('data-minutes'));
      minutes = minutes < 10 ? '0' + minutes : minutes;
      this.timeCompleted.innerText = '00:00';
      this.timeRemaining.innerText = minutes + ':00';
      this.shouldShow = false;
      this.triggerFinishedReading();
    }

    this.lastScrollTop = this.scrollTop;
  }

  triggerStillReading() {
    var readEvent = new Event('stillReading');
    document.dispatchEvent(readEvent);
  }

  triggerFinishedReading() {
    var readEvent = new Event("finishedReading");
    document.dispatchEvent(readEvent);
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TimeBar);

/***/ }),

/***/ "./src/modules/zmain.js":
/*!******************************!*\
  !*** ./src/modules/zmain.js ***!
  \******************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ouibounce__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ouibounce */ "./src/modules/ouibounce.js");
/* harmony import */ var _ouibounce__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_ouibounce__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _scrollanimation__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./scrollanimation */ "./src/modules/scrollanimation.js");
/* harmony import */ var _smoothscroll__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./smoothscroll */ "./src/modules/smoothscroll.js");
/* harmony import */ var _smoothscroll__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_smoothscroll__WEBPACK_IMPORTED_MODULE_3__);





class zmain {
  constructor() {
    this.previousValue;
    this.typingTimer;
    this.isSpinnerVisible = false; // Menu

    document.getElementById("menu").addEventListener("click", () => {
      document.querySelector("body").classList.add("push-menu-to-right");
      document.querySelector("#sidebar").classList.add("open");
      document.querySelector(".overlay").classList.add("show");
    });
    document.getElementById("mask").addEventListener("click", () => {
      document.querySelector("body").classList.remove("push-menu-to-right");
      document.querySelector("#sidebar").classList.remove("open");
      document.querySelector(".overlay").classList.remove("show");
    }); //Header

    window.addEventListener("scroll", () => {
      var supportPageOffset = window.pageXOffset !== undefined;
      var isCSS1Compat = (document.compatMode || "") === "CSS1Compat";
      var top = supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;

      if (top > 0) {
        document.querySelector("body").classList.add("light");
      } else {
        document.querySelector("body").classList.remove("light");
      }
    }); // Modals

    var closeBtn = document.querySelector('.modal .close');

    if (closeBtn) {
      closeBtn.addEventListener('click', () => {
        closeBtn.parentNode.parentNode.classList.add('closed');
      });
    }

    var exitModal = document.querySelectorAll('.modal.exit');

    if (exitModal.length) {
      _ouibounce__WEBPACK_IMPORTED_MODULE_1___default()(exitModal[0], {
        aggressive: true,
        callback: function () {
          exitModal[0].querySelector('.close').addEventListener('click', function () {
            exitModal[0].style.display = "none";
          });
        }
      });
    } // Search


    this.bs = {
      close: document.querySelector(".icon-remove-sign"),
      searchform: document.querySelector(".search-form"),
      canvas: document.querySelector("body"),
      searchFiled: document.querySelector('.search-field'),
      dothis: document.querySelector('.dosearch')
    };
    this.bs.dothis.addEventListener('click', () => {
      document.querySelector('.search-wrapper').classList.toggle('active');
      this.bs.searchform.classList.toggle('active');
      this.bs.searchFiled.focus();
      this.bs.canvas.classList.toggle('search-overlay');
      this.bs.searchFiled.addEventListener('keyup', this.typingLogic.bind(this));
    });
    this.bs.close.addEventListener('click', this.close_search.bind(this)); // Closing menu with ESC

    document.addEventListener('keyup', this.keyboardCloseSearch.bind(this)); // if (document.getElementsByClassName('home').length >= 1) {
    //     new AnimOnScroll(document.getElementById('grid'), {
    //         minDuration: 0.4,
    //         maxDuration: 0.7,
    //         viewportFactor: 0.2
    //     });
    // }
    // Init smooth scroll

    _smoothscroll__WEBPACK_IMPORTED_MODULE_3___default().init({
      selectorHeader: '.bar-header',
      // Selector for fixed headers (must be a valid CSS selector)
      speed: 500,
      // Integer. How fast to complete the scroll in milliseconds
      updateURL: false // Boolean. Whether or not to update the URL with the anchor hash on scroll

    });
  }

  close_search() {
    document.querySelector('.search-wrapper').classList.toggle('active');
    this.bs.searchform.classList.toggle('active');
    this.bs.canvas.classList.remove('search-overlay');
  }

  keyboardCloseSearch(e) {
    if (e.keyCode == 27 && jquery__WEBPACK_IMPORTED_MODULE_0___default()('.search-overlay').length) {
      this.close_search();
    }
  } // fetch() {
  //     $.ajax({
  //         url: ashad.fetchURL,
  //         type: 'post',
  //         data: { action: 'data_fetch', keyword: $('#keyword').val() },
  //         success: function(data) {
  //             $('#datafetch').html(data);
  //         }
  //     });
  // }


  typingLogic() {
    let s = this.bs.searchFiled.value;

    if (s != this.previousValue) {
      clearTimeout(this.typingTimer);

      if (s) {
        if (!this.isSpinnerVisible) {
          document.querySelector('.search-results').innerHTML = '<div class="spinner-loader"></div>';
          this.isSpinnerVisible = true;
        }

        this.typingTimer = setTimeout(this.getResults.bind(this), 750);
      } else {
        document.querySelector('.search-results').innerHTML = "";
        this.isSpinnerVisible = false;
      }
    }

    this.previousValue = s;
  }

  getResults() {
    let s = this.bs.searchFiled.value;
    jquery__WEBPACK_IMPORTED_MODULE_0___default().ajax({
      url: ashad.root_url + '/wp-json/ashad/v1/search?s=' + s,
      type: 'get',
      data: {
        action: 'data_fetch',
        keyword: jquery__WEBPACK_IMPORTED_MODULE_0___default()('#keyword').val()
      },
      success: data => {
        let postsHTML = '<h2 style="color: #fff;">Blog</h2>' + data.posts.map(post => `
                <li>
                    <article>
                        <a href="${post.url}">
                            <span class="entry-category">${post.categories[0]}</span>
                            ${post.title}
                            <span class="entry-date"><time datetime="${post.date}">${post.date}</time></span>
                        </a>
                    </article>
                </li>
                `).join('');
        let codeSnippetsHTML = '<h2 style="color: #fff;">Code Snippets</h2>' + data.code_snippets.map(post => `
                <li>
                    <article>
                        <a href="${post.url}">
                            <span class="entry-category">${post.languages[0].name}</span>
                            ${post.title}
                            <span class="entry-date"><time datetime="${post.date}">${post.date}</time></span>
                        </a>
                    </article>
                </li>
                `).join('');
        document.querySelector('.search-results').innerHTML = postsHTML + codeSnippetsHTML;
      }
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (zmain);

/***/ }),

/***/ "./assets/scss/style.scss":
/*!********************************!*\
  !*** ./assets/scss/style.scss ***!
  \********************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ (function(module) {

"use strict";
module.exports = window["jQuery"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/global */
/******/ 	!function() {
/******/ 		__webpack_require__.g = (function() {
/******/ 			if (typeof globalThis === 'object') return globalThis;
/******/ 			try {
/******/ 				return this || new Function('return this')();
/******/ 			} catch (e) {
/******/ 				if (typeof window === 'object') return window;
/******/ 			}
/******/ 		})();
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"index": 0,
/******/ 			"style-index": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkIds[i]] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkashad"] = self["webpackChunkashad"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["style-index"], function() { return __webpack_require__("./src/index.js"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;
//# sourceMappingURL=index.js.map