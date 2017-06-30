<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
</head>
<body>
    <?= $this->load->view('members/dashboard_top', null, true); ?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="first-step-form">
					<div class="form-title">
						<h5>Step 1 of 3 - Add Details</h5>
					</div>
					<div class="join-form-body">
						<div class="from-body-container">
							<h4 class="form-tagline">Fill in your Profile info</h4>
							<form role="form" method="post" action="<?php echo base_url();?>dashboard/memberdetail">
								<div class="details-form-group">
									<div class="step-label-col">
										<label class="step-label">City & Country:</label>
									</div>
									<div class="step-input-field">
										<div class="first-name-field">
										<input type="text" placeholder="Your City Name" name="city" class="join-form-control" required/>
										</div>
										<div class="last-name-field">
										<input type="text" placeholder="Your Country name"  name="country"class="join-form-control" required/>
										</div>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-label-col">
										<label class="step-label">Relationship Status</label>
									</div>
									<div class="step-input-field">
										<div class="relationship-field">
											<select name="relationship_status" class="join-form-control">
												<option>Single</option>
												<option>Dating</option>
												<option>In a relationship</option>
												<option>Engaged</option>
												<option>Married</option>
												<option>It's Complicated</option>
												<option>Open Relationship</option>
												<option>Separated</option>
												<option>Divorced</option>
												<option>Widowed</option>
											</select>
										</div>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-label-col">
										<label class="interested-in-label">Interested In:</label>
									</div>
									<div class="step-input-field">
										<div class="interest-checkbox-section">
											<div class="checkbox-col">
												<input type="checkbox" id="dating" class="interest-checkbox" value="Dating" name="dating"/>
												<label for="dating" class="interest-label">Dating</label>
											</div>
											<div class="checkbox-col">
												<input type="checkbox" id="friends" name="friends" value="Friends" class="interest-checkbox"/>
												<label for="friends" class="interest-label">Friends</label>
											</div>
										</div>
										<div class="interest-checkbox-section">
											<div class="checkbox-col">
												<input type="checkbox" id="serious-relationship" class="interest-checkbox" name="serious_relationship" value="Serious Relationship"/>
												<label for="serious-relationship" class="interest-label">Serious Relationship</label>
											</div>
											<div class="checkbox-col">
												<input type="checkbox" id="networking" class="interest-checkbox" name="networking" value="Networking"/>
												<label for="networking" class="interest-label">Networking</label>
											</div>
										</div>
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-label-col">
										<label class="step-label">Religion:</label>
									</div>
									<div class="step-input-field">
										<input type="text" placeholder="Your Religion" name="religion" class="join-form-control" />
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-label-col">
										<label class="step-label">School:</label>
									</div>
									<div class="step-input-field">
										<input type="text" placeholder="Your School Name" name="school" class="join-form-control" />
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-label-col">
										<label class="step-label">College:</label>
									</div>
									<div class="step-input-field">
										<input type="text" placeholder="Your College Name" name="college" class="join-form-control" />
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-label-col">
										<label class="step-label">University:</label>
									</div>
									<div class="step-input-field">
										<input type="text" placeholder="Your University Name" name="university" class="join-form-control" />
									</div>
								</div>
								<div class="details-form-group">
									<div class="step-label-col">
									</div>
									<div class="step-input-field">
										<input type="submit" value="Save & Continue" class="add-detail-submit-button" />
										<div class="skip-button">
											<span>or</span>
										<a class="add-detail-skip" href="<?php echo base_url('dashboard/aboutyourself'); ?>"> Skip </a>
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