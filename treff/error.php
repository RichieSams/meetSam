<?php

include_once 'functions.php';
createHeader(array("style.css"), array());

?>

<div class="main_body">
	<div class="info">
		<h1>Oops oh no!</h1>
		<p>
            There was an error in the link that was submitted<br /><br />
            Please register or login to create a Treff.<br />
            Or ask the Treff creator to resubmit invitation. 
	    </p>
	</div>

	<div class="login">
		<div class="create">
			<a href="dummy.php">Create a Treff</a>
		</div>
		<div class="join">
			<a href="dummy.php">Join a Treff</a>
		</div>
	</div>
</div> <!-- End of main_body -->

<?php include 'footer.php'; ?>