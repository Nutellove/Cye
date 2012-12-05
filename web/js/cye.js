
function setCaretPosition (elemId, caretPos) {
  var el = document.getElementById(elemId);

  if (el !== null) {

    if (el.createTextRange) {
      var range = el.createTextRange();
      range.move('character', caretPos);
      range.select();
      return true;
    } else {
      if (el.selectionStart || el.selectionStart === 0) { // (el.selectionStart === 0 added for Firefox bug)
        el.focus();
        el.setSelectionRange(caretPos, caretPos);
        return true;
      } else { // fail city, fortunately this never happens (as far as I've tested) :)
        el.focus();
        return false;
      }
    }
  }

  return false;
}

var Cye = {};

Cye.SmartField = new Class ({

  Codes: {
    'ctrl': 17,
    'back': 8
  },

  Implements: [Options],

  options: {
    trigger: '<',
    getExpectedValue: function(){return 'Expected value'},
    onMatch: Function.from
  },

  initialize: function (field, options) {
    this.setOptions(options);
    this.field = document.id(field);
    this.smartmode = false;
    this.secondValue = '';

    this.field.addEvent('keydown', this.keydown.bind(this));
    this.field.addEvent('keypress', this.keypress.bind(this));
  },

  keydown: function (event) {
    console.log('keydown', event.code);
    if (event.code == this.Codes.back) {
      console.log('keydown back');
      if (event.control) {
        this.secondValue = '';
      } else {
        this.secondValue = this.secondValue.substring(0, this.secondValue.length - 1);
      }
    }
  },

  keypress: function (event) {
    var character = String.fromCharCode(event.code);
    var expected = this.options.getExpectedValue();
    console.log('keypress', event.code, character);

    if (event.code == this.Codes.back) {
      event.stopPropagation();
      return;
    }

    if (character == this.options.trigger) {
      if ('' == this.field.get('value') || this.smartmode) {
        this.smartmode = !this.smartmode;
        event.stop();
        return;
      }
    }

    event.stop();
    var value = this.field.get('value');
    if (this.smartmode) {
      this.field.set('value', value + expected.charAt(value.length));
      setCaretPosition(this.field.id, value.length+1);
      this.secondValue += character;
    } else {
      this.field.set('value', value + character);
      setCaretPosition(this.field.id, value.length+1);
    }

    if (this.field.get('value') == expected) {
      this.options.onMatch();
    }
  },

  getValue: function () {
    return this.field.getAttribute('value');
  },

  getSecondValue: function () {
    return this.secondValue;
  }

});


Element.implement({

	disableSelection: function(){
		if (typeof this.onselectstart!="undefined") //IE route
			this.onselectstart=function(){return false}
		else if (typeof this.style.MozUserSelect!="undefined") //Firefox route
			this.style.MozUserSelect="none"
		else //All other route (ie: Opera)
			this.onmousedown=function(){return false}
		this.style.cursor = "default"
		return this;
		this.addClass('-webkit-user-select','none');
	}

});