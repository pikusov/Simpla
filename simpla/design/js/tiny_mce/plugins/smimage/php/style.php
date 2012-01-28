<style type="text/css">
/* <![CDATA[ */
.image {
padding-top: 5px;
height: <?php echo($SESSION["thumbnail_size"] + 5); ?>px;
width: <?php echo($SESSION["thumbnail_size"] + 10); ?>px;
background-color: #f6f9fb;
cursor: pointer;
}

.textbox {
line-height: 20px;
width: <?php echo($SESSION["thumbnail_size"] + 10); ?>px;
overflow: hidden;
white-space: nowrap;
}

.image_menu {
display: none;
white-space: nowrap;
overflow: hidden;
position: absolute;
margin-top: -110px;
margin-left: -1px;
list-style: none;
font-size: 10pt;
width: <?php echo($SESSION["thumbnail_size"] + 10); ?>px;
background: #ffffff url("img/image_menu_bg.gif") repeat-y;
border: 1px solid #a8adb4;
text-align: left;
filter: alpha(opacity=90);
-moz-opacity: 0.9;
opacity: 0.9;
}

.image_menu2 {
display: none;
white-space: nowrap;
overflow: hidden;
margin-top: -78px;
width: 130px;
margin-left: 6px;
}

.image_menu2_default {
display: none;
white-space: nowrap;
overflow: hidden;
margin-top: -34px;
width: 130px;
margin-left: 6px;
}

.folder_menu {
display: none;
white-space: nowrap;
overflow: hidden;
margin-top: -65px;
border: 1px solid #ffcc66;
}
-->
</style>
