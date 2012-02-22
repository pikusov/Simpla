<form style="padding:10px;" name="form_upload" action="" method="post" enctype="multipart/form-data">
	<div style="margin-bottom:2px;"><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smexplorer.upload_label_1', '?'));</script>:</b></div>
	<div><input id="upload_input_1" style="margin-bottom:8px;" type="file" name="input1" size="64" onchange="SMExplorer_Upload_ShowFileName();"></div>
	<div style="margin-bottom:2px;"><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smexplorer.upload_label_2', '?'));</script>:</b></div>
	<div><input id="upload_edit_1" style="width:90%;" type="text" name="edit1" maxlength="50"><input id="upload_edit_2" style="width:40px; border-left:0px; font-weight:bold; background-color:#f6f9fb;" type="text" name="edit2" readonly></div>

	<div style="margin-top:12px; margin-bottom:57px;">
		<script language="javascript" type="text/javascript">
		/* <![CDATA[ */
		var jSMB_U1 = new jSMButton();
		jSMB_U1.SetStyle('float:left;');
		jSMB_U1.Paint('jSMB_U1', tinyMCEPopup.getLang('smexplorer.upload_button_1', '?'), 'SMExplorer_Upload_Save(\'<?php echo bin2hex(RC4("id=2&".$GET)); ?>\');');

		var jSMB_U2 = new jSMButton();
		jSMB_U2.SetStyle('float:left; margin-left:20px;');
		jSMB_U2.Paint('jSMB_U2', tinyMCEPopup.getLang('smexplorer.upload_button_2', '?'), 'SMExplorer_Upload_Close();');
		/* ]]> */
		</script>
	</div>

	<div id="upload_info">
		<table border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smexplorer.upload_info_1', '?'));</script>:</b></td>
			<td><?php if ($SESSION["upload_filetype"] != "") { echo str_replace(',', ',&nbsp;', $SESSION["upload_filetype"]); } else { echo "<script language=\"javascript\" type=\"text/javascript\">document.write(tinyMCEPopup.getLang('smexplorer.upload_info_11', '?'));</script>"; } ?></td>
		</tr>
			<td><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smexplorer.upload_info_2', '?'));</script>:</b></td>
			<td><?php if ($SESSION["upload_filesize"] != "") { echo $SESSION["upload_filesize"]."&nbsp;KB"; } else { echo (str_replace("M", "", ini_get('post_max_size')) * 1024)."&nbsp;KB"; } ?></td>
		</tr>
		</table>
	</div>
</form>