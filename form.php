<?php
session_start();

class DbUtil{
   public static $user = "CS4750eaa4deb";
   public static $pass = "spring2018";
   public static $host = "stardock.cs.virginia.edu";
   public static $schema = "CS4750eaa4de";

   public static function loginConnection() {
      $db = new mysqli(DbUtil::$host, DbUtil::$user,
      DbUtil::$pass, DbUtil::$schema);
      if($db->connect_errno) {
        echo "fail";
        $db->close();
        exit();
      }
      return $db;
  }

}

$link = DbUtil::loginConnection();
//$link = mysqli_connect("https://stardock.cs.virginia.edu/pma/", "cs4750eaa4deb", "spring2018", "cs4750eaa4de");
 
//echo "hi";
//header("Location: index.php");
if ( isset($_POST['submit']) && ($_POST['firstname']!=NULL) && ($_POST['lastname']!=NULL) && ($_POST['compID']!=NULL)
  && isset($_POST['age'])
  && isset($_POST['gender']) && isset($_POST['school'])
  && isset($_POST['major1']) 
  && isset($_POST['hobby1']) && isset($_POST['hobbyLevel1'])
  && isset($_POST['sport1']) && isset($_POST['sportLevel1'])
  && isset($_POST['club1']) && isset($_POST['clubInvolvement1']) && isset($_POST['clubStatus1'])
  && isset($_POST['show'])
  && isset($_POST['song']) && isset($_POST['songArtist'])  
  ){

  //header("Location: index.php");
    //echo "hello??";

    $firstname = ucwords(trim($_POST['firstname']));
    $lastname = ucwords(trim($_POST['lastname']));
    $compID = trim($_POST['compID']);
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $user_counter = 0;
    $user_status = "Bronze";
    $stmt = $link->prepare("INSERT INTO Person (compID, gender, first_name, last_name, age, counter) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $compID, $gender, $firstname, $lastname, $age, $user_counter);
    $stmt->execute();
    $stmt->close();

    $stmt_status = $link->prepare("INSERT INTO Level (compID, status) VALUES (?, ?)");
    $stmt_status->bind_param("ss", $compID, $user_status);
    $stmt_status->execute();
    $stmt_status->close();

    $major = $_POST['major1'];
    $major2 = "null";
    $minor = "null";
    $school = $_POST['school'];
    if (isset($_POST['major2']) && isset($_POST['minor'])){
      $major2 = $_POST['major2'];
      $minor = $_POST['minor'];
    }
    $stmt_one = $link->prepare("INSERT INTO Studies(compID, uni_name, major1, major2, minor) VALUES (?, ?, ?, ?, ?)");
    $stmt_one->bind_param("sssss", $compID, $school, $major, $major2, $minor);
    $stmt_one->execute();
    $stmt_one->close();


    $emptystring = "";


    //INSERT INTO `Enjoys`(`compID`, `hobby_name`, `skill_level`, `sport_name`) VALUES ([value-1],[value-2],[value-3],[value-4])
    $hobby1 = ucwords(trim($_POST['hobby1']));
    $hobbyLevel1 = $_POST['hobbyLevel1'];
    $stmt_two = $link->prepare("INSERT INTO Enjoys(compID, hobby_name, skill_level, sport_name) VALUES (?, ?, ?, ?)");
    $stmt_two->bind_param("ssss", $compID, $hobby1, $hobbyLevel1, $emptystring);
    $stmt_two->execute();
    $stmt_two->close();

    $hobby = "INSERT INTO Hobby (hobby_name, type) VALUES ('".$hobby1."', '".$_POST["hobbyType1"]."')";
    $hobbyInsert = mysqli_query($link, $hobby);


    $sport1 = ucwords(trim($_POST['sport1']));
    $sportLevel1 = $_POST['sportLevel1'];
    $stmt_thr = $link->prepare("INSERT INTO Enjoys(compID, hobby_name, skill_level, sport_name) VALUES (?, ?, ?, ?)");
    $stmt_thr->bind_param("ssss", $compID, $emptystring, $sportLevel1, $sport1);
    $stmt_thr->execute();
    $stmt_thr->close();

    $sport = "INSERT INTO Sport (sport_name, type, classification) VALUES ('".$sport1."', '".$_POST["sportType1"]."', '".$_POST["sportClassification1"]."')";
    $sportInsert = mysqli_query($link, $sport);
    
    $song = ucwords(trim($_POST['song']));
    $songArtist = ucwords(trim($_POST['songArtist']));
   // VALUES ([value-1],[value-2],[value-3])
    $stmt_fou = $link->prepare("INSERT INTO Likes(compID, title, artist) VALUES (?, ?, ?)");
    $stmt_fou->bind_param("sss", $compID, $song, $songArtist);
    $stmt_fou->execute();
    $stmt_fou->close();

    $music = "INSERT INTO Music (title, artist) VALUES ('".$song."', '".$songArtist."')";
    $songInsert = mysqli_query($link, $music);

    $club1 = ucwords(trim($_POST['club1']));
    $clubInvolvement1 = $_POST['clubInvolvement1'];
    $clubStatus1 = $_POST['clubStatus1'];
    $stmt_fiv = $link->prepare("INSERT INTO Participates_In (compID, club_name, level_of_involvement, status) VALUES (?, ?, ?, ?)");
    $stmt_fiv->bind_param("ssss", $compID, $club1, $clubInvolvement1, $clubStatus1);
    $stmt_fiv->execute();
    $stmt_fiv->close();

    $club = "INSERT INTO Club (club_name, type) VALUES ('".$club1."', '".$clubType1."')";
    $clubInsert = mysqli_query($link, $club);
    
    $show = ucwords(trim($_POST['show']));
    $stmt_six = $link->prepare("INSERT INTO `Watches`(`compID`, `show_name`) VALUES (?, ?)");
    $stmt_six->bind_param("ss", $compID, $show);
    $stmt_six->execute();
    $stmt_six->close();

    $showInsert = "INSERT INTO Movies_TVShows (show_name, year_released) VALUES ('".$show."', '".$_POST['showYear']."')";
    $showInsert1 = mysqli_query($link, $showInsert);
    
    echo "form submitted";


    $user_arr = array( $compID, $age, $major, $major2, $minor, $school, $hobby1, $hobbyLevel1, $sport1, $sportLevel1, $song, $songArtist, $club1, $clubInvolvement1, $clubStatus1, $show );

    $sql = "SELECT compID FROM Person WHERE compID != '".$compID."'";
    $result = mysqli_query($link,$sql);
    $sim_count = array();
    if ($result->num_rows > 0) {
    // output data of each row
        while($row = $result->fetch_assoc()) {
            echo $row["compID"];

            $sim_count[$row["compID"]] = 0;

            $enjoysS = "SELECT * FROM Enjoys WHERE compID = '".$row["compID"]."'";
            $enjoys = mysqli_query($link, $enjoysS);
            $enjoys_row = $enjoys->fetch_assoc();
            if ($enjoys_row["hobby_name"] == $user_arr[6]){
                $sim_count[$row["compID"]] += 1;
                echo $enjoys_row["hobby_name"];
            }
            if ($enjoys_row["sport_name"] == $user_arr[8]){
                $sim_count[$row["compID"]] += 1;
                echo $enjoys_row["sport_name"];
            }

            $likesS = "SELECT * FROM Likes WHERE compID = '".$row["compID"]."'";
            $likes = mysqli_query($link, $likesS);
            $likes_row = $likes->fetch_assoc();
            if ($likes_row["title"] == $user_arr[10]){
                $sim_count[$row["compID"]] += 1;
                echo $likes_row["title"];
            }
            if ($likes_row["artist"] == $user_arr[11]){
                $sim_count[$row["compID"]] += 1;
                echo $likes_row["artist"];
            }


            $partS = "SELECT * FROM Participates_In WHERE compID = '".$row["compID"]."'";
            $part = mysqli_query($link, $partS);
            $part_row = $part->fetch_assoc();
            if ($part_row["club_name"] == $user_arr[12]){
                $sim_count[$row["compID"]] += 1;
                echo $part_row["club_name"];
            }


            $studiesS = "SELECT * FROM Studies WHERE compID = '".$row["compID"]."'";
            $studies = mysqli_query($link, $studiesS);
            $studies_row = $studies->fetch_assoc();
            if ($studies_row["uni_name"] == $user_arr[5]){
                $sim_count[$row["compID"]] += 1;
                echo $studies_row["uni_name"];
            }
            if ($studies_row["major1"] == $user_arr[2] && $studies_row["major1"] != ""){
                $sim_count[$row["compID"]] += 1;
                echo $studies_row["major1"];
            }
            if ($studies_row["major2"] == $user_arr[3] && $studies_row["major2"] != ""){
                $sim_count[$row["compID"]] += 1;
                echo $studies_row["major2"];
            }
            if ($studies_row["minor"] == $user_arr[4] && $studies_row["minor"] != ""){
                $sim_count[$row["compID"]] += 1;
                echo $studies_row["minor"];
            }

            $match_ageS = "SELECT age FROM Person WHERE compID = '".$row["compID"]."'";
            $match_age = mysqli_query($link, $match_ageS);
            $match_age_row = $match_age->fetch_assoc();
            if ($match_age_row["age"] == $user_arr[1]){
                $sim_count[$row["compID"]] += 1;
                echo $match_age_row["age"];
            }
        }
    } else {
        echo "0 results";
    }
    arsort($sim_count);
    $output = "<br>";
    //echo "<br>";
    foreach($sim_count as $x => $x_value) {
        if ($x_value >= 3){
            $user_counter +=1;
        }
        $userdisplay_start = "SELECT * FROM Person WHERE compID = '".$x."'";
        $userdisplay = mysqli_query($link, $userdisplay_start);
        $userdisplay_row = $userdisplay->fetch_assoc();

        $output .= "<tr>";
        $output .= "<td>" .$userdisplay_row["first_name"]. " " .$userdisplay_row["last_name"]. "</td>";
        $output .= "<td>" . $userdisplay_row["compID"] . "</td>";
        $output .= "<td>" . $userdisplay_row["age"] . "</td>";
        $calc = ($x_value/10) * 100;
        $output .= "<td>" . $calc . "%</td>";
        $output .= "</tr>";

    }
    
    asort($sim_count);
    $output_asc = "<br>";
    //echo "<br>";
    foreach($sim_count as $x => $x_value) {
        if ($x_value >= 3){
            $user_counter +=1;
        }
        $userdisplay_start = "SELECT * FROM Person WHERE compID = '".$x."'";
        $userdisplay = mysqli_query($link, $userdisplay_start);
        $userdisplay_row = $userdisplay->fetch_assoc();

        $output_asc .= "<tr>";
        $output_asc .= "<td>" .$userdisplay_row["first_name"]. " " .$userdisplay_row["last_name"]. "</td>";
        $output_asc .= "<td>" . $userdisplay_row["compID"] . "</td>";
        $output_asc .= "<td>" . $userdisplay_row["age"] . "</td>";
        $calc = ($x_value/10) * 100;
        $output_asc .= "<td>" . $calc . "%</td>";
        $output_asc .= "</tr>";

    }


    $setCounter = "UPDATE Person SET counter='$user_counter' WHERE compID = '".$user_arr[0]."'";
    $setCounterResult = mysqli_query($link, $setCounter);
    $link->close();

    $_SESSION['output'] = $output;
    $_SESSION['output_asc'] = $output_asc;
    $_SESSION['compID'] = $user_arr[0];
    $_SESSION['name'] = $firstname;
    //echo $output;
    header("Location: results.php");
}

// Close connection

?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="main.css">
  <title>Friend Finder</title>
</head>

<body>

  <header>

    <h1>Friend Finder</h1>
    <h2>First tell us a little bit about yourself</h2>


  </header>

  <h3>Your Info</h3>


  <footer>
  </footer>

</body>

<div id = "main" class="container">

  <div id = "main" class="sectionDiv" style="display:flex;justify-content:center;align-items:center;">

    <form name="my_form" onsubmit="return validateForm()" action="" method="POST" />
      Name:
      <br />
      <input type="text" name="firstname" class = "inputform" placeholder="First Name" required/>
      <input type="text" name="lastname" class = "inputform" placeholder="Last Name" required/>
      <br />
      <br />
      Computing ID:
      <br />
      <input type = "text" name="compID" class = "inputform" placeholder="mst3k" required/>
      <br />
      Age: 
      <input type="number" name="age" min="1" max="100" value="1" class = "inputform" required>
      Gender:
      <select name="gender" size="1" class = "inputform" required>
                <option value="Select">Select</option>
                <option value="Female">Female</option>
                <option value="Male">Male</option>
                <option value="Other">Other</option>
              
      </select>
      <br />
      School:
      <br />
      <select name= "school" size="1" class = "inputform" required>
        <option value="Select One"></option>
        <option value="College of Arts and Sciences"> College of Arts and Sciences</option>
        <option value ="School of Engineering and Applied Science">School of Engineering and Applied Science</option>
        <option value="Curry School of Eduction">Curry School of Eduction</option>
        <option value="McIntire School of Commerce">McIntire School of Commerce</option>
        <option value="School of Architecture">School of Architecture</option>
        <option value="School of Nursing">School of Nursing</option>
        <option value="Darden School of Business">Darden School of Business</option>
        <option value="School of Law">School of Law</option>
        <option value="School of Medicine">School of Medicine</option>
        <option value="Graduate School of Arts and Sciences">Graduate School of Arts and Sciences</option>
        <option value="School of Continuing and Professional Studies">School of Continuing and Professional Studies</option>
      </select>
      <br />
      Major 1:
      <select id="MajorsList" name="major1" class = "inputform" required></select>
      Major 2:
      <select id="MajorsList2" name ="major2" class = "inputform"></select>
      <br />
      Minor:
      <select id="MinorsList" name="minor" class = "inputform"></select>
      <br />
      Hobby:
      <br />
      <input type="text" name="hobby1" class = "inputform" placeholder="Hobby Name" required/>
      Level:
      <select name="hobbyLevel1" size="1" class = "inputform" required>
        <option value ="Select Level">Select Level</option>
        <option value ="Beginner">Beginner</option>
        <option value ="Intermediate">Intermediate</option>
        <option value ="Advanced">Advanced</option>
        <option value ="Expert">Expert</option>
      </select>
      Type:
      <select name="hobbyType1" size="1" class = "inputform" required>
        <option value ="Select Type">Select Type</option>
        <option value ="Indoor">Indoor</option>
        <option value="Outdoor">Outdoor</option>
        <option value="Collection">Collection</option>
        <option value="Competitive">Competitive</option>
        <option value="Observation">Observation</option>
        <option value="Other">Other</option>
      </select> 
      <br />
      Sport:
      <br />
      <input type="text" name="sport1" class = "inputform" placeholder="Sport Name" required/>
      Level:
      <select name="sportLevel1" size="1" class = "inputform" required>
        <option value ="Select Level">Select Level</option>
        <option value ="Beginner">Beginner</option>
        <option value ="Intermediate">Intermediate</option>
        <option value ="Advanced">Advanced</option>
        <option value ="Expert">Expert</option>
      </select>
      Type:
      <select name="sportType1" size="1" class = "inputform">
        <option value ="Select Type">Select Type</option>
        <option value ="Indoor">Indoor</option>
        <option value="Outdoor">Outdoor</option>
        <option value="Collection">Collection</option>
        <option value="Competitive">Competitive</option>
        <option value="Observation">Observation</option>
        <option value="Other">Other</option>
      </select> 
      Classification:
      <select name="sportClassification1" size="1" class = "inputform">
        <option value ="Select Type">Select Type</option>
        <option value ="Team">Team</option>
        <option value="Individual">Individual</option>
        <option value="Team/Individual">Team/Individual</option>
      </select> 
      <br />
     <!-- Hobby 2:
      <br />
      <input type="text" name="hobby2" class = "inputform" placeholder="Hobby Name"/>
      Level:
      <select name="level2" size="1" class = "inputform">
        <option value ="Select Level">Select Level</option>
        <option value ="Beginner">Beginner</option>
        <option value ="Intermediate">Intermediate</option>
        <option value ="Advanced">Advanced</option>
        <option value ="Expert">Expert</option>
      </select>
      Type:
      <select name="hobbyType2" size="1" class = "inputform">
        <option value ="Select Type">Select Type</option>
        <option value ="Indoor">Indoor</option>
        <option value="Outdoor">Outdoor</option>
        <option value="Collection">Collection</option>
        <option value="Competitive">Competitive</option>
        <option value="Observation">Observation</option>
        <option value="Other">Other</option>
      </select> 
      <br />
      Hobby 3:
      <br />
      <input type="text" name="hobby3" class = "inputform" placeholder="Hobby Name"/>
      Level:
      <select name="level3" size="1" class = "inputform">
        <option value ="Select Level">Select Level</option>
        <option value ="Beginner">Beginner</option>
        <option value ="Intermediate">Intermediate</option>
        <option value ="Advanced">Advanced</option>
        <option value ="Expert">Expert</option>
      </select>
      Type:
      <select name="hobbyType3" size="1" class = "inputform">
        <option value ="Select Type">Select Type</option>
        <option value ="Indoor">Indoor</option>
        <option value="Outdoor">Outdoor</option>
        <option value="Collection">Collection</option>
        <option value="Competitive">Competitive</option>
        <option value="Observation">Observation</option>
        <option value="Other">Other</option>
      </select> -->
      <br />
      Club
      <br />
      <input type = "text" name = "club1" class="inputform" placeholder="Club Name" required/>
      Type:
      <select id="ClubList" name ="clubType1" class = "inputform" required></select>
      Level of Involvement:
      <select name="clubInvolvement1" size="1" class = "inputform" required>
        <option value ="Select Involvement">Select Type</option>
        <option value ="None">None</option>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
      </select>
      Status:
      <select name="clubStatus1" size="1" class = "inputform" required>
        <option value ="Select Status">Select Type</option>
        <option value ="Officer">Officer</option>
        <option value="Member">Member</option>
      </select>
      <br />
     <!-- Club 2:
      <br />
      <input type = "text" name = "club2" class="inputform" placeholder="Club Name"/>
      Type:
      <select id="ClubList2" name ="clubType2" class = "inputform"></select>
      Level of Involvement:
      <select name="clubInvolvement2" size="1" class = "inputform">
        <option value ="Select Involvement">Select Type</option>
        <option value ="None">None</option>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
      </select>
      Status:
      <select name="clubStatus2" size="1" class = "inputform">
        <option value ="Select Status">Select Type</option>
        <option value ="Officer">None</option>
        <option value="Member">Low</option>
      </select>
      <br />
      Club 3:
      <br />
      <input type = "text" name = "club3" class="inputform" placeholder="Club Name"/>
      Type:
      <select id="ClubList3" name ="clubType3" class = "inputform"></select>
      Level of Involvement:
      <select name="clubInvolvement3" size="1" class = "inputform">
        <option value ="Select Involvement">Select Type</option>
        <option value ="None">None</option>
        <option value="Low">Low</option>
        <option value="Medium">Medium</option>
        <option value="High">High</option>
      </select>
      Status:
      <select name="clubStatus3" size="1" class = "inputform">
        <option value ="Select Status">Select Type</option>
        <option value ="Officer">None</option>
        <option value="Member">Low</option>
      </select>
      <br />-->
      Favorite TV Show/Movie:
      <input type = "text" name = "show" class = "inputform" placeholder="Movie Title" required/>
      <!--Genre:
      <select id = "genreList" name = "genreList" class = "inputform"></select>-->
      Year:
      <input id="showYear" name="showYear" type="number" min="1800" max="2019" class = "inputform" required>
      <!--<select id = "years" name = "movieYear" class = "inputform"></select>-->
      <br />
       
      Favorite Song:
      <input type = "text" name = "song" class = "inputform" placeholder="Song Title" required/>
      Artist:
      <input id="songArtist" name="songArtist" type="text" class = "inputform" required>
      <!--<select id = "years2" name = "songYear" class = "inputform"></select>-->
      <br />
      <br />


      <input type="submit" id="submit" name="submit" value="Submit" />

    </form>
  
  </div>

 

</div>

<script type="text/javascript">
  var majors = ['','Accelerated B.A./Master of Public Policy (MPP) Program ',' Accounting ',' Aerospace Engineering ',' African American & African Studies ',
 ' American Studies ',' Anthropology ',' Architectural History ',' Architecture ',' Art History ',' Art, Studio ',' Astronomy ',' Astronomy-Physics ',
 ' B.A. in Public Policy and Leadership ',' B.S./M.S. in Teaching ',' Bachelor of Science in Nursing (BSN) ',' Biology ',' Biomedical Engineering ',
  'Business',' Chemical Engineering ',' Chemistry ',' Chinese Language & Literature ',' Civil Engineering ',' Classics ',' Cognitive Science ',' Comparative Literature ',' Computer Engineering ',' Computer Science ',' Computer Science ',' Drama ',' East Asian Studies ',' Echols Interdisciplinary Major ',' Economics ',
    'Electrical Engineering ',' Engineering Science ',' English ',' Environmental Sciences ',' Environmental Thought & Practice ',' Finance ',' French '
    ,' German ',' Global Studies ',' History ',' Human Biology ',' Information Technology ',' Italian ',' Japanese Language & Literature ',' Jewish Studies '
    ,' Kinesiology ',' Latin American Studies ','Leadership',' Linguistics ',' Management ',' Marketing ',' Mathematics ',' Mechanical Engineering ',' Media Studies '
    ,' Medieval Studies ',' Middle Eastern and South Asian Languages and Cultures ',' Music ',' Neuroscience ',' Philosophy ',' Physics '
    ,' Political and Social Thought ',' Political Philosophy, Policy, and Law ',' Politics ',' Psychology ',' Religious Studies ',' RN to BSN '
    ,' Slavic Languages and Literatures ',' Sociology ',' South Asian Studies ',' Spanish ',' Speech Pathology & Audiology  ',' Statistics '
    ,' Systems Engineering ',' Teacher Education ',' Urban & Environmental Planning ',' Women, Gender, and Sexuality ',' Youth & Social Innovation Major','Other'];     
  var sel = document.getElementById('MajorsList');
    for(var i = 0; i < majors.length; i++) {
      var opt = document.createElement('option');
      opt.innerHTML = majors[i];
      opt.value = majors[i];
      sel.appendChild(opt);
    }
  var sel2 = document.getElementById('MajorsList2');
    for(var i = 0; i < majors.length; i++) {
      var opt2 = document.createElement('option');
      opt2.innerHTML = majors[i];
      opt2.value = majors[i];
      sel2.appendChild(opt2);
    }
  var sel3 = document.getElementById('MinorsList');
    for(var i = 0; i < majors.length; i++) {
      var opt3 = document.createElement('option');
      opt3.innerHTML = majors[i];
      opt3.value = majors[i];
      sel3.appendChild(opt3);
    }

  var clubList = ['Select Club Type','Academic/Professional', 'Arts', 'Greek Life', 'Sports', 'Religious','Cultural','Media' , 'Public service', 'Political' , 'Social', 'Non-profit', 'Other'];
    var clubs = document.getElementById('ClubList');
    for(var i = 0; i < clubList.length; i++) {
      var opt = document.createElement('option');
      opt.innerHTML = clubList[i];
      opt.value = clubList[i];
      clubs.appendChild(opt);
    }
    var clubs2 = document.getElementById('ClubList2');
    for(var i = 0; i < clubList.length; i++) {
      var opt = document.createElement('option');
      opt.innerHTML = clubList[i];
      opt.value = clubList[i];
      clubs2.appendChild(opt);
    }
    var clubs3 = document.getElementById('ClubList3');
    for(var i = 0; i < clubList.length; i++) {
      var opt = document.createElement('option');
      opt.innerHTML = clubList[i];
      opt.value = clubList[i];
      clubs3.appendChild(opt);
    }

    var genreList =['Select Genre', 'Action', 'Anime', 'Comedy', 'Documentary', 'Drama', 'Faith and Spirituality','Horror',
                    'International', 'Musical', 'Romance' , 'Thrillers','Sci-Fi and Fantasy','Romantic Comedy','Other'];
    var gen = document.getElementById('genreList');
    for(var i = 0; i < genreList.length; i++) {
      var opt = document.createElement('option');
      opt.innerHTML = genreList[i];
      opt.value = genreList[i];
      gen.appendChild(opt);
    }

    var years = document.getElementById('years');
    var opt = document.createElement('option');
    opt.innerHTML = "----";
    opt.value = "----";
    years.appendChild(opt);
    for(var i = 2019; i > 1888; i--) {
      opt = document.createElement('option');
      opt.innerHTML = i;
      opt.value = i;
      years.appendChild(opt);
    }

    var years2 = document.getElementById('years2');
    var optSong = document.createElement('option');
    optSong.innerHTML = "----";
    optSong.value = "----";
    years2.appendChild(optSong);
    for(var i = 2019; i > 1800; i--) {
      opt2 = document.createElement('option');
      optSong.innerHTML = i;
      optSong.value = i;
      years2.appendChild(optSong);
    }


</script>


<script type="text/javascript">
  function validateForm() {
    var my_form = document.forms["my_form"];

        //check Name is not empty
        var x = my_form["eventName"].value;
        if(x == "") {
          alert("Event Name field must be filled out!");
          return false;
        }

        //Check location is not empty
        x = my_form["Location"].value
        if(x == "") {
          alert("Location field must be filled out!");
          return false;
        }
        //check description is not empty
        x = my_form["eventDescription"].value
        if(x == "") {
          alert("Description field must be filled out!");
          return false;
        }
        

      }     

    </script>

</html>