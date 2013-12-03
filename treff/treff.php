<?php
    $id = $_GET['meetingId'];
    include_once 'functions.php';
    $jscriptsLibs = array("https://maps.googleapis.com/maps/api/js?key=".$goKey."&sensor=true",'jsfunctions.js');
    createHeader(array("style.css"), $jscriptsLibs);
?>
<script type="text/javascript">
    codeAddress(centerDefault);
</script>
<div class="main_body">
    <div class="infoTreff">
        <div class="status">
            <h1>Status:</h1> <?php echo checkStat($id); ?>
        </div>
		<p> All atendees have submited a confirmation.
	    </p>
        <button type="button" onclick="getDirects(<?php echo getAddress('id') ?>);"><h1>Get Directions</h1></button>

        <button type="button" onclick="alert('Email Sent');"><h1>Send Reminder Email</h1></button>
        <div id="directions-panel">Click on buttons above for more info.
        </div>


	</div>
    <div id="map-canvas"></div>
</div>

<?php include 'footer.php'; ?>