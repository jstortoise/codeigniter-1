<!DOCTYPE html>
<html>
<head>
    <title>Orriz - About</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
</head>
<body>
    <?= $this->load->view('members/dashboard_top', null, true); ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="second-step-form">
					<div class="form-title">
						<h5>Step 2 of 3 - Add About Yourself</h5>
					</div>
					<div class="join-form-body">
						<div class="second-step-body-container">
							<h4 class="form-tagline">Tell more about yourself</h4>
							<form role="form" METHOD="post" action="<?php echo base_url('dashboard/aboutyourself'); ?>">
								<div class="details-form-group">
									<div class="step-2-label-col">
										<label class="second-step-label">Music:</label>
									</div>
									<div class="step-2-input-field">
										<textarea placeholder="Your Fav. Music" name="music" class="join-form-control second-form-textarea"></textarea>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-2-label-col">
										<label class="second-step-label">Movies:</label>
									</div>
									<div class="step-2-input-field">
										<textarea placeholder="Your Fav. Movies" name="movies" class="join-form-control second-form-textarea"></textarea>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-2-label-col">
										<label class="second-step-label">TV:</label>
									</div>
									<div class="step-2-input-field">
										<textarea placeholder="Your Fav. TV Shows" name="tv" class="join-form-control second-form-textarea"></textarea>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-2-label-col">
										<label class="second-step-label">Books:</label>
									</div>
									<div class="step-2-input-field">
										<textarea placeholder="Your Fav. Books" name="books" class="join-form-control second-form-textarea"></textarea>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-2-label-col">
										<label class="second-step-label">Sports:</label>
									</div>
									<div class="step-2-input-field">
										<textarea placeholder="Your Fav. Sports" name="sports" class="join-form-control second-form-textarea"></textarea>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-2-label-col">
										<label class="second-step-label">Interests:</label>
									</div>
									<div class="step-2-input-field">
										<textarea placeholder="Your Interests" name="interests" class="join-form-control second-form-textarea"></textarea>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-2-label-col">
										<label class="second-step-label">Dreams:</label>
									</div>
									<div class="step-2-input-field">
										<textarea placeholder="Your Dreams" name="dreams" class="join-form-control second-form-textarea"></textarea>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-2-label-col">
										<label class="second-step-label">Best Feature:</label>
									</div>
									<div class="step-2-input-field">
										<textarea placeholder="Your Best Feature" name="best_feature" class="join-form-control second-form-textarea"></textarea>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-2-label-col">
										<label class="second-step-label">About Me:</label>
									</div>
									<div class="step-2-input-field">
										<textarea placeholder="About Me" name="about_me" class="join-form-control second-form-textarea"></textarea>
									</div>
								</div>
								
								<div class="details-form-group">
									<div class="step-label-col">
									</div>
									<div class="step-input-field">
										<input type="submit" value="Save & Continue" class="second-step-submit-button" />
										<div class="second-step-skip-button">
											<span>or</span>
											<a class="second-step-skip" href="<?php echo base_url('dashboard/uploadimage') ?>">Skip</a>
										</div>
									</div>
								</div>
							</form>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
    <?= $this->load->view('/public/footer', null, true); ?>
</body>
</html>