"use strict";

// const Global = require('./global');

// let	_this;

let _this = module.exports = {
	/*-------------------------------------------------------------------------------
		# Cache dom and strings
	-------------------------------------------------------------------------------*/
	$dom: {
		myInput: $('.frm_form_field > input'),
		formSubmit: $('.frm_submit_button_tertiary'), 
		formSection: $('.frm_form_field.frm_section_heading'),
		formSectionHeading: $('.form-field > .toggle-form-section-wrap'),
		formSectionBody: $('.toggle-form-section-wrap + *'),
    },

    vars: {
	},

	/*-------------------------------------------------------------------------------
		# Initialize
	-------------------------------------------------------------------------------*/

	init: function () {
		if( _this ){
			
			/**
			 * Variables
			 */
			var icon = '<svg class="bc-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><g><path id="icon-success" d="M12.71,21.67,23.33,11.05,21.87,9.59l-9.16,9.16L8.09,14.14,6.63,15.59ZM15,30A14.88,14.88,0,0,1,0,15,14.9,14.9,0,0,1,14.79,0H15A14.92,14.92,0,0,1,30,14.83V15a14.67,14.67,0,0,1-1.17,5.88A14.91,14.91,0,0,1,15,30Zm0-2A12.88,12.88,0,0,0,28,15.31V15A12.87,12.87,0,0,0,15.31,2,1.6,1.6,0,0,0,15,2,12.87,12.87,0,0,0,2,14.69V15A12.88,12.88,0,0,0,14.69,28Z"/></g></svg>';
			var currentSectionHeading = _this.$dom.formSectionHeading[0];
			var entry = [];
			var animationDuration = 300;
			var isAutosaveInit = false;

			/**
			 * Events
			 */
			_this.$dom.myInput.on('blur', inputValidStyle);
			_this.$dom.formSectionHeading.on('click', sectionToggleCollapse);
			_this.$dom.formSectionBody.on('click', validateBody);

			/**
			 * Initialize
			 */
			_this.$dom.formSection.each(sectionsInit);
			validateSubmitReady();

			/**
			 * Initialize section attributes and classes
			 * @param i Integer: Index of form section element
			 * @param el HTML: Form section element
			 */
			function sectionsInit(i, el) {
				if(i < _this.$dom.formSection.length) {
					// Expand all sections
					expand(_this.$dom.formSectionHeading[i]);

					// Add section index
					el.setAttribute('bc-section-entry', i);

					// Add section type labels
					let typeEl = _this.$dom.formSectionHeading[i].querySelector('[bc-section-type]'); 
					if(typeEl) {
						let type = typeEl.getAttribute('bc-section-type');
						if(type == 'single-choice' || type == 'multiple-choice') {
							let label = type.split('-');
							typeEl.innerHTML = label[0] + ' ' + label[1];
						}
					}

					// Add section classes
					_this.$dom.formSectionHeading[i].classList.add('bc-heading');
					_this.$dom.formSectionBody[i].classList.add('bc-body');

					// Add success icon
					let span = document.createElement('span');
					span.innerHTML = icon;
					_this.$dom.formSectionHeading[i].prepend(span.children[0]);
				}
			}

			/**
			 * Style input fields after validation
			 * @param e Event
			 */
			function inputValidStyle(e) {
				let isError = this.parentNode.querySelector('.frm_error');

				if( !isError && this.value != '') {
					this.classList.add('bc-valid');
				} else if(this.classList.contains('bc-valid')){
					this.classList.remove('bc-valid');
				}
			}

			/**
			 * Toggle section collapse expand state
			 * @param e Event
			 */
			function sectionToggleCollapse(e) {
				let isCollapsed = this.parentNode.classList.contains('bc-collapse');

				if(isCollapsed) {
					expand(this);
				} else {
					collapse(this, true);
				}
			}

			/**
			 * Expand form section
			 * @param el HTML: Form section heading element
			 * @param isValidate Boolean: Decide if expand should validate and autosave
			 */
			function collapse(el, isValidate=false) {
				el.parentNode.classList.remove('bc-expand');
				el.parentNode.classList.add('bc-collapse');
				el.parentNode.style.height = el.getBoundingClientRect().height + 'px';

				if(isValidate) {
					if(validate(el.parentNode)) {
						autosaveFormSegments(el);
					}
				}
			}

			/**
			 * Expand form section
			 * @param el HTML: Form section heading element
			 * @param isValidate Boolean: Decide if expand should collapse previous section
			 */
			function expand(el, isValidate=false) {
				el.parentNode.classList.remove('bc-collapse');
				el.parentNode.classList.add('bc-expand');
				el.parentNode.style.height = el.nextElementSibling.getBoundingClientRect().height + el.getBoundingClientRect().height + 'px';

				if(isValidate) {
					validateCollapse(el);
					currentSectionHeading = el;
				}
			}

			/**
			 * Validate and Collapse after succefful validation
			 * @param el HTML: Form section heading element
			 */
			function validateCollapse(el) {
				if(currentSectionHeading && currentSectionHeading != el) {
					let currentSection = currentSectionHeading.parentNode;

					if(validate(currentSection)) {
						if( !currentSection.classList.contains('bc-collapse')) {
							collapse(currentSectionHeading);

							autosaveFormSegments(currentSectionHeading);
						}
						
						sectionScroll(el);
					} 

					let type = getSectionType(el);

					if( type == 'single-choice') {
						if( validate(el.parentNode, type) ) {
							collapse(el);
	
							autosaveFormSegments(el);
						}
					}
				} 
			}

			/**
			 * Validate previus saction fields after clicking on new section fields
			 * @param e Event
			 */
			function validateBody(e) {
				// console.log(this);
				var _this = this;
				//_this.parentNode.classList.add('bc-display');

				setTimeout(function(){
					//Test if selected section is valid
					if( validate(_this.parentNode)) {
						validateCollapse(_this.previousElementSibling);
						currentSectionHeading = _this.previousElementSibling;
					} 
					
					//Test if previus section is valid
					if( validate(currentSectionHeading.parentNode) ) {
						validateCollapse(_this.previousElementSibling);
						currentSectionHeading = _this.previousElementSibling;
					}
				}, animationDuration);
			}

			/**
			 * Validate saction fields
			 * @param el HTML: Form section element
			 * @param type String (Optional): Form section type 
			 */
			function validate(el, type=false) {
				if(!type) { type = getSectionType(el); }
				var isError = true;

				if(type == 'multiple-choice' || type == 'single-choice') {
					isError = (el.querySelector('input:checked')) ? false : true;
				} else if(type == 'inputs') {
					isError = false;

					let inputs = $( el.querySelectorAll('[aria-required="true"]') );

					inputs.each(function(i, input){
						if( !input.classList.contains('bc-valid') ) {
							isError = true;
						}
					});
				}

				if(!isError) {
					el.classList.add('bc-success');
					return true;
				} else {
					el.classList.remove('bc-success');
					return false;
				}
			}

			/**
			 * Scroll to section top
			 * @param el HTML: Form section heading element
			 */
			function sectionScroll(el){
				setTimeout(function(){
					window.scrollTo({
						top: el.offsetTop,
						left: 0,
						behavior: 'smooth'
					});
				}, animationDuration);
			}

			/**
			 * Get section fields type
			 * @param el HTML: Form section heading element
			 */
			function getSectionType(el){
				let type = el.querySelector('[bc-section-type]');
				type = (type) ? type.getAttribute('bc-section-type') : false;

				return type;
			}

			/**
			 * Captcher and save partial form information inside individual sections
			 * @param el HTML: Form section heading element
			 */
			function autosaveFormSegments(el) {
				let autosaveEl = el.querySelector('[bc-section-autosave]');
				if(!isAutosaveInit) {
					isAutosaveInit = (autosaveEl.getAttribute('bc-section-autosave') == 'start');
				}
				let isAutosave = (autosaveEl) ? true : false;

				if(isAutosave) {
					let section = el.parentNode;
					let entryIndex = el.parentNode.getAttribute('bc-section-entry');
					let type = getSectionType(el);
					let values = [];

					if(type == "multiple-choice" || type == "single-choice") {
						let choices = section.querySelectorAll('input:checked');
						loop(choices, function(i, el){
							values[i] = {
								name: el.name, 
								value: stripHtml(el.value)
							}
						});
					} else if(type == "inputs") {
						let inputs = section.querySelectorAll('input');

						loop(inputs, function(i, el){
							values[i] = {
								name: el.name, 
								value: stripHtml(el.value),
							}
						});
					}

					entry[entryIndex] = values;
				}

				if(isAutosaveInit) {
					// AUTOSAVE DATABASE COMMUNICATION
					// - Use Formidable plugin API for AJAX saving of entry record 
					// - or create custom query for saving of entry record (this should be a last option)
					// console.log(entry);
					var form_id = $('.frm_form_fields input[name="form_id"]').val();

                    $.ajax({
                        url: theme.ajax_url,
                        type: 'POST',
                        dataType: 'HTML',
                        data: {
                            action: 'create_entry_before_submit',
							form_id: form_id,
                            entry: entry,
                        },
                    }).done(function (){});
				}

				validateSubmitReady();
			}

			/**
			 * Validate if submit button is ready to be shown
			 * @return Boolean
			 */
			function validateSubmitReady() {
				if(_this.$dom.formSubmit.is('[bc-submit-ready]')) {
					if(entry.length == _this.$dom.formSectionHeading.length) {
						_this.$dom.formSubmit.attr('bc-submit-ready', 'yes');
						return true;
					} else {
						_this.$dom.formSubmit.attr('bc-submit-ready', 'no');
						return false;
					}
				}
			}

			/**
			 * Loop through array (helper function)
			 * @param arr Array: data to loop through
			 * @param fun Function: function to run in individual iteration
			 */
			function loop(arr, fun) {
				for (var i=0; i<arr.length; i++) {
					fun(i, arr[i]);
				}
			}

			/**
			 * Strip HTML tags oput of string (helper function)
			 * @param html String
			 */
			function stripHtml(html) {
				let tmp = document.createElement("DIV");
				tmp.innerHTML = html;

				return tmp.textContent || tmp.innerText || "";
			}
		}
    },

};