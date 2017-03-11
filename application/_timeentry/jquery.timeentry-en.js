/* http://keith-wood.name/timeEntry.html
   English initialisation for the jQuery time entry extension
   Khemarin, customize for rakugo */
(function($) {
	$.timeEntry.regional['en'] = {show24Hours: true, separator: ':',
		ampmPrefix: '',
		ampmNames: ['AM', 'PM'],
		spinnerTexts: ['Now', 'Previous field', 'Next field', 'Increment', 'Decrement']};
	$.timeEntry.setDefaults($.timeEntry.regional['en']);
})(jQuery);


