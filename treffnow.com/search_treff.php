<?php

session_start();

include_once 'functions.php';
createHeader(array("style.css"), array("lib/jquery-1.10.2.min.js", "validate.js"));

if (isset($_POST['search'])) {
    $connection = connectMySql();

    $query = "SELECT m.name, mu.idHash
              FROM MeetingUsers AS mu
              INNER JOIN Meetings AS m
              ON m.meetingId=mu.meetingId
              INNER JOIN Users AS u
              ON mu.userId=u.UserId
              WHERE u.email='" . $_POST['email'] . "' AND mu.confirmed=FALSE";

    if (isset($_POST['meetingId']) && $_POST['meetingId'] != "") {
        $query .=  " AND mu.meetingId=" . $_POST['meetingId'];
    } if ($_POST['meetingName'] && $_POST['meetingName'] != "") {
        $query .=  " AND m.name=" . $_POST['meetingName'];
    }

    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        echo '
        <div class="main_body">
            <table>
                <tr>
                    <th>Treff Name</th>
                </tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                  <td>
                      <form action="jointreff.php" method="POST">
                          <input name="selectedTreff" type="radio" />' . $row['name'] . '
                          <input name="idHash" type="hidden" value="' . $row['idHash'] . '" />
                          <input name="email" type="hidden" value="' . $_POST['email'] . '" />
                      </form>
                  </td>
              </tr>';
        }

        echo '
            </table>
            <div><button onclick="submitJoin();">Submit</button></div>
        </div>';
    } else {
        echo '
        <div class="main_body">
            <h1 class="heading">You have no Treffs to join. You can create a Treff <a href="create1.php">here</a></h1>
        </div>';
    }

    $result->free();
    $connection->close();


} else {
    echo '
    <div class="main_body">
        <div class="jointreff">
            <h1 class="heading">Search for a Treff to Join</h1>
            <form id="joinForm" action="'. $_SERVER['PHP_SELF'] . '" method="POST" onsubmit="return validateSearch();">
                <div class="joinInfo">
                    <table>
                        <tr>
                            <td><input type="text" name="email" maxlength="50" placeholder="Your Email Address" /></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="meetingId" placeholder="Meeting Id" /></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="meetingName" maxlength="50" size="37" placeholder="Meeting Name" /></td>
                        </tr>
                    </table>
                </div>

                <div class="searchDiv">
                    <input name="search" class="searchButton" type="submit" value="Search"/>
                </div>
            </form>
        </div><!--// End of jointreff -->
    </div> <!--// End of main_body -->';
}

include 'footer.php';