<?php

	function renderHeader() {
		echo "<div id=\"header\">
    <div class=\"logo\">
    	<img src=\"template_files/AT-Logo.png\" alt=\"\" title=\"\" border=\"0\"></a>
    </div>
  </div>";
	}

	function renderMenu() {
		echo "            <div id=\"menu_tab\">                                     
                    <ul class=\"menu\">                                                                               
                         <li><a href=\"index.php\" class=\"nav\"> Home </a></li>
                         <li class=\"divider\"></li>
                         <li></li>
                         <li class=\"divider\"></li>
                         <li><a href=\"#\" class=\"nav\"> Great Gift Ideas</a></li>
                         <li class=\"divider\"></li>
                         <li><a href=\"#\" class=\"nav\">Contact</a></li>
                         <li class=\"divider\"></li>
                         <li></li>
                         <li class=\"divider\"></li>
                         <li><a href=\"admin_login.php\" class=\"nav\"> Admin </a></li>
                    </ul>
  			</div>";
	}

?>