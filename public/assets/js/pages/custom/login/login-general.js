"use strict";

// Class Definition
var KTLogin = function() {
	var _login;

	var _showForm = function(form) {
		var cls = 'login-' + form + '-on';
		var form = 'kt_login_' + form + '_form';

		_login.removeClass('login-forgot-on');
		_login.removeClass('login-reset-password-on');
		_login.removeClass('login-token-on');
		_login.removeClass('login-signin-on');
		_login.removeClass('login-signup-on');

		_login.addClass(cls);

		KTUtil.animateClass(KTUtil.getById(form), 'animate__animated animate__backInUp');
	}

	var _handleSignInForm = function() {
		var validation;

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_signin_form'),
			{
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Email is required'
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: 'Password is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					submitButton: new FormValidation.plugins.SubmitButton(),
					//defaultSubmit: new FormValidation.plugins.DefaultSubmit(), // Uncomment this line to enable normal button submit after form validation
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		$('#kt_login_signin_submit').on('click', function (e) {
			e.preventDefault();

			validation.validate().then(function(status) {
				if (status == 'Valid') {
					var dataSet={
						_token:$("#token").val(),'email':$("#email").val(),'password':$("#password").val(), 'user_type':1
					};
					/*if($("#remember_me").is(':checked')){
						data.remember_me=true;
					}*/
					var form = $("#kt_login_signin_form");
					$.ajax({
						url:$("#kt_login_signin_form").attr('action'),
						type:"post",
						data:form.serialize(),
						dataType:"json",
						success:function (data) {
							if(data.success){
								if(data.success.otp_required){
									$("#user_id").val(data.success.user.id);
									$("#remember_me_otp").val(data.success.remember_me);
									_showForm('token');
									swal.fire({
										text: data.success.message+' - '+data.success.otp,
										icon: "success",
										buttonsStyling: false,
										confirmButtonText: "Ok, got its!",
										customClass: {
											confirmButton: "btn font-weight-bold btn-light-primary"
										}
									});
								}else{
									swal.fire({
										text: data.success.message,
										icon: "success",
										buttonsStyling: false,
										confirmButtonText: "Ok, got it!",
										customClass: {
											confirmButton: "btn font-weight-bold btn-light-primary"
										}
									}).then(function() {
										window.location.href=data.success.url
									});
								}


							}else{
								swal.fire({
									text: data.error.message,
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn font-weight-bold btn-light-danger"
									}
								});
							}
						}
					})
				} else {
					swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
					}).then(function() {
						KTUtil.scrollTop();
					});
				}
			});
		});

		// Handle forgot button
		$('#kt_login_forgot').on('click', function (e) {
			e.preventDefault();
			_showForm('forgot');
		});
		$('#kt_login_reset_password').on('click', function (e) {
			e.preventDefault();
			_showForm('reset-password');
		});
		$('#kt_login_token').on('click', function (e) {
			e.preventDefault();
			_showForm('token');
		});

		// Handle signup
		$('#kt_login_signup').on('click', function (e) {
			e.preventDefault();
			_showForm('signup');
		});
	}

	var _handleSignUpForm = function(e) {
		var validation;
		var form = KTUtil.getById('kt_login_signup_form');

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			form,
			{
				fields: {
					fullname: {
						validators: {
							notEmpty: {
								message: 'Username is required'
							}
						}
					},
					email: {
						validators: {
							notEmpty: {
								message: 'Email address is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: 'The password is required'
							}
						}
					},
					cpassword: {
						validators: {
							notEmpty: {
								message: 'The password confirmation is required'
							},
							identical: {
								compare: function() {
									return form.querySelector('[name="password"]').value;
								},
								message: 'The password and its confirm are not the same'
							}
						}
					},
					agree: {
						validators: {
							notEmpty: {
								message: 'You must accept the terms and conditions'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		$('#kt_login_signup_submit').on('click', function (e) {
			e.preventDefault();

			validation.validate().then(function(status) {
				if (status == 'Valid') {
					swal.fire({
						text: "All is cool! Now you submit this form",
						icon: "success",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
					}).then(function() {
						KTUtil.scrollTop();
					});
				} else {
					swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
					}).then(function() {
						KTUtil.scrollTop();
					});
				}
			});
		});

		// Handle cancel button
		$('#kt_login_signup_cancel').on('click', function (e) {
			e.preventDefault();

			_showForm('signin');
		});
	}

	var _handleForgotForm = function(e) {
		var validation;

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_forgot_form'),
			{
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Email address is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		// Handle submit button
		$('#kt_login_forgot_submit').on('click', function (e) {
			e.preventDefault();

			validation.validate().then(function(status) {
				if (status == 'Valid') {
					var dataSet={
						_token:$("#token").val(),'email':$("#forgot_email").val(), 'user_type':1
					};

					$.ajax({
						url:$("#kt_login_forgot_form").attr('action'),
						type:"post",
						data:dataSet,
						dataType:"json",
						success:function (data) {
							if(data.success){

								swal.fire({
									text: data.success.message,
									icon: "success",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn font-weight-bold btn-light-primary"
									}
								});
								var mail = $("#forgot_email").val();
								$("#reset_password_email").val(mail);
								_showForm('reset-password');
							}else{
								swal.fire({
									text: data.error.message,
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn font-weight-bold btn-light-danger"
									}
								});
							}
						}
					});
					KTUtil.scrollTop();
				} else {
					swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
					}).then(function() {
						KTUtil.scrollTop();
					});
				}
			});
		});

		// Handle cancel button
		$('#kt_login_forgot_cancel').on('click', function (e) {
			e.preventDefault();

			_showForm('signin');
		});
	}

	var _handleResetPasswordForm = function(e) {
		var validation;

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_reset_password_form'),
			{
				fields: {
					code: {
						validators: {
							notEmpty: {
								message: 'This field is required'
							},
						}
					},
					password: {
						validators: {
							notEmpty: {
								message: 'This field is required'
							},
						}
					},
					confirm_password: {
						validators: {
							notEmpty: {
								message: 'This field is required'
							},
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		// Handle submit button
		$('#kt_login_reset_password_submit').on('click', function (e) {
			e.preventDefault();

			validation.validate().then(function(status) {
				if (status == 'Valid') {
					var dataSet={
						_token:$("#token").val(),
						'email':$("#reset_password_email").val(),
						'password':$("#new_reset_password").val(),
						'password_confirmation':$("#confirm_new_reset_password").val(),
						'code':$("#reset_password_code").val(),
						'user_type':1
					};

					$.ajax({
						url:$("#kt_login_reset_password_form").attr('action'),
						type:"post",
						data:dataSet,
						dataType:"json",
						success:function (data) {
							if(data.success){
								swal.fire({
									text: data.success.message,
									icon: "success",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn font-weight-bold btn-light-primary"
									}
								}).then(function() {
									window.location.href=data.success.url
								});
							}else{
								swal.fire({
									text: data.error.message,
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn font-weight-bold btn-light-danger"
									}
								});
							}
						}
					});
					KTUtil.scrollTop();
				} else {
					swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
					}).then(function() {
						KTUtil.scrollTop();
					});
				}
			});
		});

		// Handle cancel button
		$('#kt_login_reset_password_cancel').on('click', function (e) {
			e.preventDefault();

			_showForm('signin');
		});
	}


	var _handleTokenForm = function(e) {
		var validation;

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			KTUtil.getById('kt_login_token_form'),
			{
				fields: {
					otp: {
						validators: {
							notEmpty: {
								message: 'OTP is required'
							}
						}
					}
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		// Handle submit button
		$('#kt_login_token_submit').on('click', function (e) {
			e.preventDefault();

			validation.validate().then(function(status) {
				if (status == 'Valid') {
					var dataSet={
						_token:$("#token").val(),'otp':$("#otp").val(),'user_id':$("#user_id").val()
					};

					$.ajax({
						url:$("#kt_login_token_form").attr('action'),
						type:"post",
						data:dataSet,
						dataType:"json",
						success:function (data) {
							if(data.success){
								swal.fire({
									text: data.success.message,
									icon: "success",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn font-weight-bold btn-light-primary"
									}
								}).then(function() {
									window.location.href=data.success.url
								});
							}else{
								swal.fire({
									text: data.error.message,
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn font-weight-bold btn-light-danger"
									}
								});
							}
						}
					});
				} else {
					swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
					}).then(function() {
						KTUtil.scrollTop();
					});
				}
			});
		});

		// Handle cancel button
		$('#kt_login_token_cancel').on('click', function (e) {
			e.preventDefault();

			_showForm('signin');
		});
	}


	var _handleInvitationForm = function(e) {
		var validation;

		// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
		validation = FormValidation.formValidation(
			KTUtil.getById('kt_invite_form'),
			{
				fields: {
					email: {
						validators: {
							notEmpty: {
								message: 'Email address is required'
							},
							emailAddress: {
								message: 'The value is not a valid email address'
							}
						}
					},
				},
				plugins: {
					trigger: new FormValidation.plugins.Trigger(),
					bootstrap: new FormValidation.plugins.Bootstrap()
				}
			}
		);

		// Handle submit button
		$('#kt_invitation_submit').on('click', function (e) {
			e.preventDefault();

			validation.validate().then(function(status) {
				if (status == 'Valid') {
					var dataSet={
						_token:$("#token").val(),'email':$("#invite_email").val()
					};

					$.ajax({
						url:$("#kt_invite_form").attr('action'),
						type:"post",
						data:dataSet,
						dataType:"json",
						success:function (data) {

							if(data.success){
								swal.fire({
									text: data.success.message,
									icon: "success",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn font-weight-bold btn-light-primary"
									}
								}).then(function() {
									$("#invite_email").val("");
									$("#kt_invite_people_modal").modal('toggle');
								});
							}else{
								swal.fire({
									text: data.error.message,
									icon: "error",
									buttonsStyling: false,
									confirmButtonText: "Ok, got it!",
									customClass: {
										confirmButton: "btn font-weight-bold btn-light-danger"
									}
								});
							}
						}
					})
				} else {
					swal.fire({
						text: "Sorry, looks like there are some errors detected, please try again.",
						icon: "error",
						buttonsStyling: false,
						confirmButtonText: "Ok, got it!",
						customClass: {
							confirmButton: "btn font-weight-bold btn-light-primary"
						}
					}).then(function() {
						KTUtil.scrollTop();
					});
				}
			});
		});

	}

	// Public Functions
	return {
		// public functions
		init: function() {
			_login = $('#kt_login');

			_handleSignInForm();
			_handleSignUpForm();
			_handleForgotForm();
			_handleResetPasswordForm();
			_handleTokenForm();
			_handleInvitationForm();
		}
	};
}();

// Class Initialization
jQuery(document).ready(function() {
	KTLogin.init();
});
