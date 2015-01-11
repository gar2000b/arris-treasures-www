<?php

   // Get URL path from PHP..
   $site_url = "http://" . $_SERVER["SERVER_NAME"];
   
   // Get root folder from PHP..
   $doc_root = $_SERVER['DOCUMENT_ROOT'];
   
   // Edit upload location here
   $destination_path = getcwd().DIRECTORY_SEPARATOR . "../images/banner/";

   $result = 0;
   $target_new = '1';
   
   $target_path = $destination_path . basename( $_FILES['myfile']['name']);

   if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
      $result = 1;
	  // $target_path = str_replace("\\", "-", $target_path);
	  // $target_path = str_replace("/", "-", $target_path);
	  $target_new = '1';
   }
   
   sleep(1);
   
?>

<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result; ?>, '<?php echo $destination_path; ?>');</script>   
