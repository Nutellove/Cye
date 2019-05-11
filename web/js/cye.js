var Cye = {};

/**
 * Looking at the source, eh? … You're going to leave disappointed.
 * - It's the old Mootools LOL
 * - It's a HACK
 */
Cye.SmartField = new Class({

    Codes: {
        'ctrl': 17,
        'back': 8
    },

    Implements: [Options],

    options: {
        trigger: '<',
        getExpectedValue: function () {
            return 'Expected value'
        },
        onMatch: Function.from
    },

    initialize: function (field, options) {
        this.setOptions(options);
        this.field = document.id(field);
        this.smartmode = false;
        this.value = '';

        this.field.addEvent('keydown', this.keydown.bind(this));
        this.field.addEvent('keypress', this.keypress.bind(this));
        this.field.addEvent('keyup', this.keyup.bind(this));
    },

    keydown: function (event) {
        if (this.smartmode && event.code == this.Codes.back) {
            if (event.control) {
                this.value = '';
            } else {
                this.value = this.value.substring(0, this.value.length - 1);
            }
        }
    },

    keypress: function (event) {
        var character = String.fromCharCode(event.code);
        var expected = this.options.getExpectedValue();
        var value = this.field.get('value');

        if (event.code == this.Codes.back) {
            event.stopPropagation();
            return;
        }

        if (character == this.options.trigger) {
            if ('' == value || this.smartmode) {
                this.smartmode = !this.smartmode;
                event.stop();
                return;
            }
        }

        if (this.smartmode) {
            event.stop();
            this.field.set('value', value + expected.charAt(value.length));
            this.field.setCaretPosition(value.length + 1);
            this.value += character;
        }

        this.options.onKeyPress(character);
    },

    keyup: function (event) {
        var expected = this.options.getExpectedValue();
        var value = this.field.get('value');
        if (value.trim() == expected.trim()) {
            this.options.onMatch();
        }
    },

    getValue: function () {
        return this.value;
    }

});


Element.implement({

    disableSelection: function () {
        if (typeof this.onselectstart != "undefined") // IE route
            this.onselectstart = function () {
                return false
            };
        else if (typeof this.style.MozUserSelect != "undefined") // Firefox route
            this.style.MozUserSelect = "none";
        else // All other routes (ie: Opera)
            this.onmousedown = function () {
                return false
            };
        this.style.cursor = "default";
        this.addClass('-webkit-user-select', 'none');
        return this;
    },

    setCaretPosition: function (position) {
        if (this.createTextRange) {
            var range = this.createTextRange();
            range.move('character', position);
            range.select();
            return true;
        } else {
            if (this.selectionStart || this.selectionStart === 0) { // (el.selectionStart === 0 added for Firefox bug)
                this.focus();
                this.setSelectionRange(position, position);
                return true;
            } else { // fail city, fortunately this never happens (as far as I've tested) :)
                this.focus();
                return false;
            }
        }
    }

});