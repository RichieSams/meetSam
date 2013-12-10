<?php

session_start();

include_once 'functions.php';
createHeader(array("style.css"), array());

    $connection = connectMySql();

    $query = "SELECT m.name, mu.idHash, m.status, DATE_FORMAT(m.lastActivity, '%c-%d-%Y') AS lastActivity, mu.confirmed
                  FROM MeetingUsers AS mu
                  INNER JOIN Meetings AS m
                  ON m.meetingId=mu.meetingId
                  INNER JOIN Users AS u
                  ON mu.userId=u.UserId
                  WHERE u.UserId='" . $_SESSION['userId'] . "'";

    

    $result = $connection->query($query);

    echo '
    <div class="main_body">
		<div class="viewTreff"><h2>Your Treff\'s</h2></div>
        <table class = "viewTreffTable">            
			<tr>
				<td class="tdName"><u>Treff Name</u></td><td class="tdCon"><u>Confirmed</u></td><td class="tdStatus"><u>Treff Status</u></td><td class="tdLast"><u>Last Activity</u></td>
			</tr>';

    while ($row = $result->fetch_assoc()) {
		if($row['confirmed'] == "1"){
			$confirm = "Yes";
		}else{
			$confirm = "No";
		}

        echo '<tr>
                  <td><a href=" http://treffnow.com/treff.php?idHash=' . $row['idHash'] . '">' . $row['name'] . '</a></td>
				  <td>' . $confirm . '</td>
				  <td>' . $row['status'] . '</td>
				  <td>' . $row['lastActivity'] . '</td>
              </tr>';
    }
	echo '
		</table>
	</div>';

    $result->free();
    $connection->close();

    


include 'footer.php';