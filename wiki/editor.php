<?php
	require_once('../php_scripts/connect_db.php');
	require_once('../php_scripts/common.php');
	require_once('../php_scripts/wiki.php');
	session_start(); // start up your PHP session!
	
	$pageId = $_GET['pageId'];
	$query = "SELECT * FROM wiki_pages WHERE Id = $pageId;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$content = $row['content'];
		// $content = str_replace("&gt;", ">", $content);
		$pageName = $row['page_name'];
		$description = $row['description'];
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<title><?php echo "$pageName" . " (edit)"; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>

<!-- OF COURSE YOU NEED TO ADAPT NEXT LINE TO YOUR tiny_mce.js PATH -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="../google-code-prettify/run_prettify.js"></script>

<script type="text/javascript">
tinyMCE.init({
        // General options
		// encoding : "xml",
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
        theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,blockquote,pagebreak,|,insertfile,insertimage",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true,

        // Skin options
        skin : "o2k7",
        skin_variant : "silver",

        // Example content CSS (should be your site CSS)
        content_css : "css/example.css",

        // Drop lists for link/image/media/template dialogs
        template_external_list_url : "js/template_list.js",
        external_link_list_url : "js/link_list.js",
        external_image_list_url : "js/image_list.js",
        media_external_list_url : "js/media_list.js",

        // Replace values for the template plugin
        template_replace_values : {
                username : "Some User",
                staffid : "991234"
        }
});
</script>
<link type="image/x-icon" href="/images/layout/favicon.ico" rel="icon">
</head>
<body bgcolor="#003366">
<!-- OF COURSE YOU NEED TO ADAPT ACTION TO WHAT PAGE YOU WANT TO LOAD WHEN HITTING "SAVE" -->
<form method="post" action="editor_submit.php">
        <p style="color:#CCCCCC">     
                Page Name: 
                  <input name="pageName" type="text" id="pageName" value="<?php echo "$pageName"; ?>" size="28" />
Page Description:
<input name="pageDescription" type="text" id="pageDescription" value = "<?php echo "$description"; ?>" size="28" />
        </p>
        <p>
          <textarea name="content" cols="100" rows="16"><?php
					echo "$content";
				?>
                </textarea>
          <br />
          <input type="button" value="Launch Image Manager" onclick="window.open('image_manager.php');" /> <input type="submit" value="Save and Preview" />
        </p>
        <input type="hidden" id="pageId" name="pageId" value="<?php echo "$_GET[pageId]"; ?>" />
</form>

</body>
</html>