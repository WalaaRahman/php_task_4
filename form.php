<?php

include 'helper.php';

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $name       =  clean($_POST['name']); 
    $password   =  clean($_POST['password']);
    $email      =  clean($_POST['email']);
    $address    =  clean($_POST['address']);
    $linkedIn   =  clean($_POST['linkedinURL']);
  
    $errors = [];
  
      if(!validate($name,'empty')){
         $errors['Name'] = "Field Required";
      }
  
      # Password Validation ... 
      if(!validate($password,'empty')){
          $errors['Password'] = "Field Required";
      }elseif(!validate($password,'size',6) ){
          $errors['Password'] = "Password Length Must >= 6 ch";
      }
  
        # Email Validation ... 
        if(!validate($email,'empty')){
          $errors['Email'] = "Field Required";
      }elseif(!validate($email,'email')){
          $errors['Email'] = "Invalid Email";
      }
  
  
  
        # linked Validation ... 
      if(!validate($linkedIn,'empty')){
          $errors['linkedIn'] = "Field Required";
      }elseif(!validate($linkedIn,'url')){
          $errors['linkedIn'] = "Invalid Url";
      }
  
      # use isset() to check if the gender exists or not, to avoid undefined warning
         if(isset($_POST['gender']))
         {
  
         $gender = clean($_POST['gender']);
         }else{
        
           $errors['gender'] = "Field Required";
      
         }


     # CV Validation 


         if(! empty($_FILES['cv']['name'])){

            $cvTemp = $_FILES['cv']['tmp_name'];
            $cvName = $_FILES['cv']['name'];
            $cvSize = $_FILES['cv']['size'];
            $cvType = $_FILES['cv']['type'];
    
            # Validate extension type
    
            $allowedEx=['pdf','docx'];
    
            $typeArray= explode('/',$cvType);
    
            if(in_array($typeArray[1],$allowedEx)){
    
                $fileName=rand(1,20).time().'.'.$typeArray[1]; // Creating new name to uploaded file
    
                $desPath='./uploades/'.$fileName; // creating destination path --> uploades folder
    
                if(move_uploaded_file($cvTemp,$desPath)) // moving file from temporary path to destienation path on server
                {
                    echo 'CV uploaded successfully'.'<br>';
                }
                else{
                    $errors['cv']= '* Error uploading file , Please Try Again !!';
                    // echo 'Error uploading file , Please Try Again !!';
                }
            }
            else{
                $errors['cv']= '* NOT Allowed CV Extension !!';

                // echo 'NOT Allowed CV Extension !!';
            }
        }
        else{
            $errors['cv']= '* CV Required !!';

            // echo '* CV Required !!';
        }
      
  
      if(count($errors) > 0){
          foreach($errors as $key => $val ){
              echo '* '.$key.' :  '.$val.'<br>';
          }
      }else{
          echo 'Valid Data';
         }


    setcookie('Name',$name,time()+86400,'/');     
    setcookie('Email',$email,time()+86400,'/');     
    setcookie('Password',$password,time()+86400,'/');     
    setcookie('Address',$address,time()+86400,'/');     
    setcookie('Gender',$gender,time()+86400,'/');     
    setcookie('Linkedin',$linkedIn,time()+86400,'/');     
    setcookie('CV',$fileName,time()+86400,'/');     
    
}
include './layouts/header.php';
?>





<div class="container">
  <h2>Register</h2>
  <form  action="<?php echo $_SERVER['PHP_SELF'];?>"   method="POST"   enctype ="multipart/form-data">

  

  <div class="form-group">
    <label for="exampleInputName">Name</label>
    <input type="text"  name="name"  class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
  </div>


  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="text"   name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">New Password</label>
    <input type="password"   name ="password"  class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>

  <div class="form-group">
    <label for="exampleInputAddress">Address</label>
    <input type="text"  name="address"  class="form-control" id="exampleInputAddress" aria-describedby="" placeholder="Enter Name">
  </div>

    <!-- Gender -->
  <div class="form-group">
  <input type="radio" id="male" name="gender" value="Male">
  <label for="html">Male</label>
  <input type="radio" id="female" name="gender" value="Female">
  <label for="css">Female</label><br>  </div>

  <div class="form-group">
    <label for="exampleInputLinkedinURL">Linkedin URL</label>
    <input type="text"  name="linkedinURL"  class="form-control" id="exampleInputLinkedinURL" aria-describedby="" placeholder="Enter Name">
  </div>


  <!-- Upload CV -->

  <div class="form-group">
        <label for="exampleInputPassword1">CV</label>
        <input type="file" name="cv">
 </div>



    <!-- <button type="submit" class="btn btn-primary">Upload</button> -->
 
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

</body>
</html>