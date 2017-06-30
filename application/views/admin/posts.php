<!DOCTYPE html>
<html>
<head>
    <title>Site Title</title>
    <?= $this->load->view('admin/headIncludes', null, true) ?>
    <script>
        $(document).ready(function () {
//            $('#example').dataTable({
//                "bProcessing": true,
//                "bServerSide": true,
//                "sAjaxSource": "<?//= base_url('admin/get_posts') ?>//"
//            });
//            var xhttp = new XMLHttpRequest();
//            xhttp.onreadystatechange = function () {
//                if (this.readyState == 4 && this.status == 200) {
//                    document.getElementById("duration").value = this.responseText;
//                }
//            };
//            xhttp.open("GET", "<?php //echo base_url('admin/get_post_duration'); ?>//", true);
//            xhttp.send();
        });
    </script>
    <script language="javascript">
        function post_edit(id, duration) {
            document.getElementById("post_id").value = id;
            document.getElementById("duration_value").value = duration;
            document.getElementById("duration_popup").style.display = "block";
        }
        function cancel() {
            document.getElementById("duration_popup").style.display = "none";
        }
        function update() {
            if ((document.getElementById("duration_value").value).replace(/\s+/g, '') == "") {
                alert("Please input the duration value!");
            } else {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        if (this.responseText == "1") {
                            document.getElementById("duration_popup").style.display = "none";
                            $('#example').DataTable().draw();
                        } else if (this.responseText == "0") {
                            document.getElementById("duration_popup").style.display = "none";
                            alert("The action was failed!");
                        } else {
                            document.getElementById("duration_popup").style.display = "none";
                            alert("The action was failed!");
                        }
                    }
                };
                xhttp.open("GET", "<?php echo base_url('admin/update_duration'); ?>?id=" + document.getElementById("post_id").value + "&duration_value=" + document.getElementById("duration_value").value, true);
                xhttp.send();
            }
        }
        function updateAllDuration() {
            var duration = document.getElementById("duration").value;
            if (duration.replace(/\s+/g, '') == "") {
                swal('Error',
                    'Please input the duration of posts!',
                    'error');
                return;
            } else if (duration != parseInt(duration, 10)) {
                swal('Error',
                    'Please enter positive integer',
                    'error');
                return;
            }
            duration = parseInt(duration);
            if (duration < 1) {
                swal('Error',
                    'Please enter value greater than 0',
                    'error');
                return;
            }
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    if (this.responseText == "1") {
                        swal('Success',
                            'Value successfully changed',
                            'success').then(function () {
                            window.location.reload();
                        });
                    } else if (this.responseText == "0") {
                        swal('Error',
                            'Sorry, server error',
                            'error');
                    } else {
                        swal('Error',
                            'Sorry, server error',
                            'error');
                    }
                }
            };
            xhttp.open("GET", "<?php echo base_url('admin/update_post_duration'); ?>?duration=" + document.getElementById("duration").value, true);
            xhttp.send();
        }

        function deleteNow() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>cron/postclear',
                data: {},
                success: function (data) {
                    swal('Info',
                        data,
                        'info');
                },
                error: function (data) {
                    swal('Error',
                        'Sorry, server error',
                        'error');
                }
            });
        }
    </script>
</head>
<body>
<?= $this->load->view('admin/top', null, true) ?>
<div class="container">
    <!--<div id="duration_popup" class="duration_popup">
        <input type="hidden" id="post_id" /> Days
        <input type="input" id="duration_value" />
        <input type="button" value="Update" onclick="update()"/>
        <input type="button" value="Cancel" onclick="cancel()"/>
    </div>
        <h4>Posts</h4>
    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
        <thead>
        <tr>
            <th width="5%">ID</th>
            <th width="10%">Member</th>
            <th width="15%">Status</th>
            <th width="10%">Image</th>
            <th width="10%">Privacy</th>
            <th width="10%">Posted Time</th>
            <th width="10%">Duration</th>
            <th width="10%">Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td colspan="5" class="dataTables_empty">Loading data from server</td>
        </tr>
        </tbody>
        <tfoot>
        </tfoot>
    </table>-->
    <h4>Posts</h4>
    Current posts duration: <?= $post_duration ?> days.
    <div id="durationDiv" class="durationDiv">
        Set duration of All Posts&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;<input type="input" id="duration"/>&nbsp;&nbsp;&nbsp;Days&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="Update" onclick="updateAllDuration()"/>
    </div>
    <div>
        <input class="btn btn-danger" type="button" value="Delete expired posts now" onclick="deleteNow()"/>
    </div>
</div>
<?= $this->load->view('admin/footer', null, true) ?>
</body>
</html>