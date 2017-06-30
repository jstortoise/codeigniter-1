<!DOCTYPE html>
<html>
<head>
    <title>Orriz - Report</title>
    <?= $this->load->view('public/headIncludes', null, true) ?>
</head>
<body>
<?= $this->load->view('members/dashboard_top', null, true) ?>
</div>
<div class="clearfix"></div>
<div class="container">
    <div class="row">
        <?php
        print_r(validation_errors());
        if (!empty($message)) {
            echo $message;
        }
        ?>
        <div class="col-xs-12">
            <div style="color: #F8BB22"></div>
            <div class="first-step-form">
                <div class="form-title">
                    <h5>Report us</h5>
                </div>
                <div class="join-form-body">
                    <div class="from-body-container">
                        <h4 class="form-tagline">Your Profile info</h4>
                        <form role="form" method="post" action="http://orriz.com/members/report">
                            <div class="details-form-group">
                                <div class="step-label-col">
                                    <label class="step-label">Name:</label>
                                </div>
                                <div class="step-input-field">
                                    <div class="first-name-field">
                                        <input type="text" style="width: 384px;" placeholder="Your Name" name="name"
                                               value="" class="join-form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-label-col">
                                    <label class="step-label">Email:</label>
                                </div>
                                <div class="step-input-field">
                                    <div class="first-name-field">
                                        <input type="text" style="width: 384px;" placeholder="Your Email Address"
                                               name="email" value="" class="join-form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <div class="step-label-col">
                                    <label class="step-label">Message:</label>
                                </div>
                                <div class="step-input-field">
                                    <div class="first-name-field">
                                        <textarea style="width: 384px; height: 164px;" class="form-control"
                                                  name="reported_issue" cols="100" rows"50"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="details-form-group">
                                <input type="submit" value="Submit" class="btn btn-success">
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