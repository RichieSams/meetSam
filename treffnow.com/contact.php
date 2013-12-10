<?php
session_start();
include_once 'functions.php';
createHeader(array("style.css"), array());

?>

<div class="main_body">
	<div class="contact">
		<h1> Meet SAM </h1>
		<p>
			<a href = "http://zweb.cs.utexas.edu/users/cs329e/smf2256/subDir/hwk3/hwk3.html">Steven </a><br/>
			A Mechanical Engineering major at the University of Texas at Austin<br/>
		</p>
		<p>
			<a href = "http://zweb.cs.utexas.edu/users/cs329e/adastley/hw3/hw3.html">Adrian </a><br/>
			A Mechanical Engineering major at the University of Texas at Austin<br/>@adastley
		</p>
		<p>
			<a href = "http://zweb.cs.utexas.edu/users/cs329e/mars011/hw3/resume.html">Martin </a><br/>
			A Physics major at the University of Texas at Austin<br/>@Lothilius
		</p>
		<br/>

		<h1>Special Thanks To:</h1>
		<p>	
			Chris Veness for his help with calculating latitude and longatude by use of the 
			<a href = "http://www.movable-type.co.uk/scripts/latlong.html">Haversine Functions</a>.<br/>
		</p>
		<p>	
			<a href = "http://oi915.com/"><img src="images/oi915dotcom.png" hight = "96" width =" 204" /></a>
			for generously providing a server to run our site.
		</p>
	</div>
</div> <!-- End of main_body -->

<?php include 'footer.php'; ?>