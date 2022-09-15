<?php /* Template Name: Custonm-Form */ ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php bloginfo('name'); ?></title>
	<link rel='stylesheet' href='<?php bloginfo('stylesheet_url'); ?>' />
	<?php wp_head(); ?>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css' />
	<script
  src="https://code.jquery.com/jquery-3.6.1.js"
  integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
  crossorigin="anonymous"></script>
</head>
<body <?php body_class(); ?> >
	<header>
		<h1><?php bloginfo('name'); ?></h1>
		<h4><?php bloginfo('description'); ?></h4>
		<?php wp_nav_menu('primary'); ?>
	</header>
	<?php
		global $wpdb;
		$table_name = $wpdb->prefix . 'form_submissions';


		if(isset($_POST['submitted'])){
			if(trim($_POST['firstName']) === ''){
				$firstNameError = 'enter first name';
				$hasError = true;
			} else {
				$firstName = trim($_POST['firstName']);
			}

			if(trim($_POST['lastName']) === ''){
				$lastNameError = 'enter last name';
				$hasError = true;
			} else {
				$lastName = trim($_POST['lastName']);
			}

			if(trim($_POST['email']) === ''){
				$emailError = 'enter an email address';
				$hasError = true;
			} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
				$emailError = 'email address must be valid';
				$hasError = true;
			} else {
				$email = trim($_POST['email']);
			}

			if(! is_numeric($_POST['telephone']) && $_POST['telephone'] === ''){
				$telephoneError = 'telephone number must be entered';
				$hasError = true;
			} else {
				$telephone = $_POST['telephone'];
			}

		}
	?>
	<div class="container">
		<form action="<?php the_permalink(); ?>" method="POST" class="custom-form">
			<?php // wp_nonce_field(); ?>
			<!-- <div class="control-form"> -->
				<label for="firstName" class="form-label">First name:</label>
				<input type="text" name="firstName" value="" placeholder="first">
				<label for="lastName" class="form-label">Last name:</label>
				<input type="text" name="lastName" value="" placeholder="last">
			<!-- </div>
			<div class="control-form"> -->
				<label for="email" class="form-label">Email:</label>
				<input type="email" name="email" value="" placeholder="email address">
			<!-- </div>
			<div class="control-form"> -->
				<label for="telephone" class="form-label">Phone:</label>
				<input type="telephone" name="telephone" value="" placeholder="telephone number">
			<!-- </div> -->
			<input type="submit" class="form-btn" value="submit" />
			<input type="hidden" name="submitted" id="submitted" value="true">
		</form>
	</div>
	<?php // partial template for the footer ?>
	<footer>
		the footer will go here
	</footer>
	<script>
		// $(document).ready(function($){
			$('custom-form').submit(function(evt){
				evt.preventDefault();
				
				var formData = {
					'firstName' : $('input[name=firstName]').val(),
					'lastName' : $('input[name=lastName]').val(),
					'email' : $('input[name=email]').val(),
					'telephone' : $('input[name=telephone]').val()
				}

				$.ajaz({
					type : 'POST',
					url : 'http://acwtrial/wp-content/themes/acwtrial/templates/template-custom-form.php',
					data : formData,
					dataType : 'json',
					encode : true
				}).done(function(data){
					console.log(data);

					if (! data.success){
						// errors for first name
						if (data.errors.firstName){
							$('firstName').addClass('show-error');
							$('firstName').append('<div class="help-block">' + data.errors.firstName + '</div>');
						}

						// errors for last name
						if (data.errors.lastName){
							$('lastName').addClass('show-error');
							$('lastName').append('<div class="help-block">' + data.errors.lastName + '</div>');
						}

						// errors for email
						if (data.errors.email){
							$('email').addClass('show-error');
							$('email').append('<div class="help-block">' + data.errors.email + '</div>');
						}

						// errors for telephone
						if (data.errors.telephone){
							$('telephone').addClass('show-error');
							$('telephone').append('<div class="help-block">' + data.errors.telephone + '</div>');
						}

					} else {
						$('contact-form').append('<div class="alert alert-success">' + data.message + '</div>');

						alert('success');
					}
				});
				evt.preventDefault();
			});
		// })(jQuery);
	</script>
	<script type='text/javascript' src='	https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js'></scrip>
</body>
</html>