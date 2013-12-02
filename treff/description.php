<?php
session_start();
include 'functions.php';
createHeader(array("style.css"), array());

?>

<div class="main_body">
	<div class="description">
        </p>
		<h1>FAQ</h1>
		<h4>What's a Treff?</h4> <p>It is German for the word "Meeting"</p>
        <h4>Why name it Treff?</h4> <p> Because it sounds cool. :) But really. We were trying to think of a name for this site and in the process started looking at Google Translate. We discovered the word "treff" and we really liked it.</p>
        <h4>Will the person I'm meeting see the information I enter?</h4> <p> Not at all. We only use your location in order to take the guess work out of finding a public meeting space.</p>
		<h4>How do I know the invitation was sent?</h4> <p> There will be a confirmation page that the message was sent.</p>
		<h4>What happens if they receive an invitation?</h4> <p> Once they receive your invitation they will have a chance to enter their location. Then a public halfway point will be found using Goggle Maps.</p>
		<h4>Is your meeting algorithm public?</h4> <p> Sorry in order to prevent "gaming" the meeting place we hold it under lock and key.</p>
	</div>
</div> <!-- End of main_body -->

<?php include 'footer.php'; ?>