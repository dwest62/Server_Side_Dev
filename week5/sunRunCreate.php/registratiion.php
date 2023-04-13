<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
<!-- registration.php - Register new racers - edit, delete 
  Student Name
  Written:  Current Date 
  Revised:  
  -->
 <title>SunRun Registration</title>
<link rel="stylesheet" type="text/css" href="registration.css">

<?PHP
   // Set up connection constants
   // Using default username and password for AMPPS  
   define("SERVER_NAME","localhost");
   define("DBF_USER_NAME", "root");
   define("DBF_PASSWORD", "mysql");
   define("DATABASE_NAME", "sunRun");
   
   // Global connection object
   $conn = NULL;

   // Link to external library file
   echo "PATH (Current Working Directory): " . getcwd( ) . "\sunRunLib.php" . "<br />";
   require_once(getcwd( ) . "\sunRunLib.php");   
   // Connect to database
   createConnection();
    // Is this a return visit?
    if(array_key_exists('hidIsReturning',$_POST)) {
        echo '<h1>Welcome BACK</h1>';
        echo "<hr /><strong>\$_POST: </strong>";
        print_r($_POST);
        
        
        // Determine which button may have been clicked
        switch($_POST['btnSubmit']){
        // = = = = = = = = = = = = = = = = = = = 
        // DELETE  
        // = = = = = = = = = = = = = = = = = = = 
        case 'delete':
          echo "<hr />DEBUG DELETE button pushed<br />";
          break;
        // = = = = = = = = = = = = = = = = = = = 
        // ADD NEW RUNNER 
        // = = = = = = = = = = = = = = = = = = = 
        case 'new':
          echo '<hr />DEBUG ADD button pushed<br />';
          break;
        
        // = = = = = = = = = = = = = = = = = = = 
        // UPDATE   
        // = = = = = = = = = = = = = = = = = = = 
        case 'update':
          echo '<hr />DEBUG UPDATE button pushed<br />';
          break;
                    
       } // end of switch( )
        
    }
    else // or, a first time visitor?
    {
      echo '<h1>Welcome FIRST TIME</h1>';
    } // end of if new else returning
?>

</head>
<body>
<div id="frame">
<h1>SunRun Registration</h1>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
      method="POST"
      name="frmRegistration"
      id="frmRegistration">

     <label for="lstRunner"><strong>Select Runner's Name</strong></label>

     <select name="lstRunner" id="lstRunner" onChange="this.form.submit();">
        <option value="new">Select a name</option>
        <?PHP
           // Loop through the runner table to build the <option> list
           $sql = "SELECT id_runner, CONCAT(fName,' ',lName) AS 'name' 
           FROM runner ORDER BY lName";
           $result = $conn->query($sql);
           while($row = $result->fetch_assoc()) {    
              echo "<option value='" . $row['id_runner'] . "'>" . $row['name'] . "</option>\n";
           }
        ?>
   </select> 
   &nbsp;&nbsp;<a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">New</a>
   <br />
   <br />
   
   <fieldset>
      <legend>Runner's Information</legend>
            
      <div class="topLabel">
         <label for="txtFName">First Name</label>
         <input type="text" name="txtFName"   id="txtFName"   value="Fred" />
         
      </div>
      
      <div class="topLabel">
         <label for="txtLName">Last Name</label>
         <input type="text" name="txtLName"   id="txtLName"   value="Flintstone" />
      </div>
      
      <div class="topLabel">
         <label for="txtPhone">Phone</label>
         <input type="text" name="txtPhone"   id="txtPhone"   value="123-456-7890" />
      </div>
      
      <div class="topLabel">
         <label for="lstGender">Gender</label>
         <select name="lstGender" id="lstGender">
            <option value="female">Female</option>
            <option value="male">Male</option>
         </select> 
      </div>
      
      <div class="topLabel">
         <label for="txtSponsor">Sponsor</label>
         <input type="text" name="txtSponsor" id="txtSponsor" value="Barney Rubble Tires" />
      </div>
   </fieldset>
   
   <br />
   <button name="btnSubmit" 
           value="delete"
           style="float:left;"
           onclick="this.form.submit();">
           Delete
   </button>
          
   <button name="btnSubmit"    
           value="new"  
           style="float:right;"
           onclick="this.form.submit();">
           Add New Runner Information
   </button>
          
   <button name="btnSubmit" 
           value="update" 
           style="float:right;"
           onclick="this.form.submit();">
           Update
   </button>
   <br />     
  <!-- Use a hidden field to tell server if return visitor -->
  <input type="hidden" name="hidIsReturning" value="true" />
</form>
<br /><br />
<h2>Registered Runners</h2>
<table>     
   <tr>
      <th>Name</th>
      <th>Phone</th>
      <th>Gender</th>
      <th>Sponsor</th>
   </tr>

   <tr>
      <td>First Runner</td>
      <td>123-456-7890</td>
      <td>Male</td>
      <td>3M Corporation</td>
   </tr>
   <tr>
      <td>Second Runner</td>
      <td>223-256-2222</td>
      <td>Female</td>
      <td>Nike</td>
   </tr>
   <tr>
      <td>Third Runner</td>
      <td>333-256-3333</td>
      <td>Female</td>
      <td>Wells Fargo</td>
   </tr>
</table>

</div>
</body>
</html>