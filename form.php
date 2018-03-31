<?php

$link = mysqli_connect("localhost", "root", "p", "baewatch");
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
//header("Location: index.php");
if (isset($_POST["submitbtn"]) && isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['birthdate']) && isset($_POST['gender']) && isset($_POST['password'])){

  //header("Location: index.php");

  $firstnameInsert = $_POST['firstname'];
    $lastnameInsert = $_POST['lastname'];
    $usernameInsert = $_POST['username'];
    $emailInsert = $_POST['email'];
    $birthdateInsert = $_POST['birthdate'];
    $genderInsert = $_POST['gender'];
    $passwordInsert = password_hash($_POST['confirm_password'], PASSWORD_DEFAULT);

  $stmt = $link->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
  $stmt->bind_param("ss", $usernameInsert, $emailInsert);
  $result = $stmt->execute();

  /*$stem = $link->prepare("SELECT * FROM users WHERE email = ?");
  $stem->bind_param("s", $emailInsert);
  $res = $stem->execute();*/
  //check if username is taken
  $assoc_array = array();
  while($row = $stmt->fetch()){
    array_push($assoc_array, $row);
  }
  //check is email is taken
  /*
  $assoc_array_em = array();
  while($row_em = $stem->fetch()){
    array_push($assoc_array_em, $row_em);
  }*/
  //if both are taken
  /*if (count($assoc_array_em) >= 1 && count($assoc_array) >= 1) {
      echo '<script> bothTaken(); </script>';  
    } */
    if (count($assoc_array) >= 1) {
      echo '<script> userTaken(); </script>'; 
    }/*
    else if (count($assoc_array_em) >= 1) {
      echo '<script> emailTaken(); </script>';
    }*/
    else {
      //$sql = "INSERT INTO users (name, email, address, city, state, zipcode, password) 
      //VALUES ('$usernameInsert', '$emailInsert', '$addressInsert', '$cityInsert', '$stateInsert', '$zipcodeInsert', '$passwordInsert')";
     echo '<script> userNotTaken(); </script>';

     $stmt_two = $link->prepare("INSERT INTO users (firstname, lastname, username, email, birthdate, gender, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
  
   $stmt_two->bind_param("sssssss", $firstnameInsert, $lastnameInsert, $usernameInsert, $emailInsert, $birthdateInsert, $genderInsert, $passwordInsert);


      if($stmt_two->execute()){
          echo "Records added successfully.";
          //header("Location: success.php");
          $stmt_two->close();
      //$link->close();
      } else{
        
          echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
          
      }

     // function SendMail( $ToEmail) {
      require "PHPMailer/src/PHPMailer.php";
      require "PHPMailer/src/OAuth.php";
      require "PHPMailer/src/SMTP.php";
      require "PHPMailer/src/POP3.php";
      require "PHPMailer/src/Exception.php";


      $mail = new PHPMailer\PHPMailer\PHPMailer();

      //$mail->SMTPDebug = 4;                               // Enable verbose debug output

      $mail->isSMTP();                                      // Set mailer to use SMTP
      $mail->Host = 'smtp.gmail.com;';  // Specify main and backup SMTP servers
      $mail->SMTPAuth = true;                               // Enable SMTP authentication
      $mail->Username = 'baewatch.help@gmail.com';                 // SMTP username
      $mail->Password = 'HelloHello!';                           // SMTP password
      $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
      $mail->Port = 587;                                    // TCP port to connect to

      $mail->setFrom('baewatch.help@gmail.com', 'baeWatch Support');
      $mail->addAddress($emailInsert, $usernameInsert);     // Add a recipient

      $mail->isHTML(true);                                  // Set email format to HTML

      $mail->Subject = 'Welcome to baeWatch, '. $firstnameInsert. '!';
      //$mail->AddEmbeddedImage('images/email.gif', 'jake');
      $mail->Body    = 'Thanks for joining! We look forward to you finding the one! <br> <br> <img src="https://media1.tenor.com/images/94d31b39f65d8bf4fd3e0aa1c1d0d6a8/tenor.gif?itemid=4347501" style="height: 60%; width: 60%;"/> <br> <br> Sincerely, <br> baeWatch Team';
      //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
      $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
      if(!$mail->send()) {
          echo 'Message could not be sent.';
          echo 'Mailer Error: ' . $mail->ErrorInfo;
      } else {
          echo 'Message has been sent';
      }
    
    //header("Location: login.php");
      //$link->close();
    }
}

// Close connection
mysqli_close($link);
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

    <form name="my_form" onsubmit="return validateForm()" action="friendInfo.html" method="POST" />
      Name:
      <br />
      <input type="text" name="firstName" class = "inputform" placeholder="First Name" required/>
      <input type="text" name="lastName" class = "inputform" placeholder="Last Name" required/>
      <br />
      <br />
      Computing ID:
      <br />
      <input type = "text" name="eventDescription" class = "inputform" placeholder="mst3k" required/>
      <br />
      Age: 
      <input type="number" min="1" max="100" value="1" class = "inputform" required>
      Gender:
      <select name="State" size="1" class = "inputform" required>
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
      <select name="sportType1" size="1" class = "inputform" required>
        <option value ="Select Type">Select Type</option>
        <option value ="Indoor">Indoor</option>
        <option value="Outdoor">Outdoor</option>
        <option value="Collection">Collection</option>
        <option value="Competitive">Competitive</option>
        <option value="Observation">Observation</option>
        <option value="Other">Other</option>
      </select> 
      Classification:
      <select name="sportClassification1" size="1" class = "inputform" required>
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
        <option value ="Officer">None</option>
        <option value="Member">Low</option>
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
      Favorite Show:
      <input type = "text" name = "show" class = "inputform" placeholder="Movie Title" required/>
      Genre:
      <select id = "genreList" name = "showGenre" class = "inputform" required></select>
      Year:
      <input id="years" name="movieYear" type="number" min="1800" max="2019" class = "inputform" required>
      <!--<select id = "years" name = "movieYear" class = "inputform"></select>-->
      <br />
       
      Favorite Song:
      <input type = "text" name = "song" class = "inputform" placeholder="Song Title" required/>
      Year:
      <input id="year2" name="songYear" type="number" min="1800" max="2019" class = "inputform" required>
      <!--<select id = "years2" name = "songYear" class = "inputform"></select>-->
      <br />
      <br />


      <input type="submit" value="Submit" />

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