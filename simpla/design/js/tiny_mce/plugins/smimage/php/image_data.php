<div id="window_imagedata_top" class="top"></div>

<div class="content">
	<form name="form_imagedata" action="" method="post" enctype="multipart/form-data">
		<div>
			<div style="margin-bottom:2px;"><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.insert_label_1', '?'));</script>:</b></div>
			<div><input style="margin-bottom:8px; width:98%;" type="text" name="edit1" onfocus="Input_OnFocus(this);" onblur="Input_OnBlur(this);"></div>
		</div>
		<div>
			<div style="margin-bottom:2px;"><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.insert_label_2', '?'));</script>:</b></div>
			<div><input style="margin-bottom:8px; width:98%;" type="text" name="edit2" onfocus="Input_OnFocus(this);" onblur="Input_OnBlur(this);"></div>
		</div>
		<div>
			<div style="margin-bottom:2px;"><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.insert_label_3', '?'));</script>:</b></div>
			<div style="margin-bottom:6px;">
				<img id="imagedata_alignment_1" class="button_mouseout" style="margin-right:8px;" src="img/icon_float_none_24x24.png" height="24" width="24" border="0" onmouseover="Button_MouseOver(this);" onmouseout="Button_MouseOut(this);" onclick="SMImage_SetImageDataAlignment(this, '');" /><img id="imagedata_alignment_2" class="button_mouseout" style="margin-right:8px;" src="img/icon_float_left_24x24.png" height="24" width="24" border="0" onmouseover="Button_MouseOver(this);" onmouseout="Button_MouseOut(this);" onclick="SMImage_SetImageDataAlignment(this, 'float:left;');" /><img id="imagedata_alignment_3" class="button_mouseout" style="margin-right:8px;" src="img/icon_float_right_24x24.png" height="24" width="24" border="0" onmouseover="Button_MouseOver(this);" onmouseout="Button_MouseOut(this);" onclick="SMImage_SetImageDataAlignment(this, 'float:right;');" />
			</div>
		</div>
		<div>
			<div style="margin-bottom:2px;"><b><script language="javascript" type="text/javascript">document.write(tinyMCEPopup.getLang('smimage.insert_label_4', '?'));</script>:</b></div>
			<div><input style="margin-bottom:14px; width:98%;" type="text" name="edit3" onfocus="Input_OnFocus(this);" onblur="Input_OnBlur(this);"></div>
		</div>
		<div style="margin:0 auto; width:215px;">
			<script language="javascript" type="text/javascript">
			/* <![CDATA[ */
			var jSMB1 = new jSMButton();
			var jSMB2 = new jSMButton();

			jSMB1.SetStyle('float:left;');
			jSMB2.SetStyle('float:left; margin-left:15px;');
			jSMB1.Paint('jSMB1', tinyMCEPopup.getLang('smimage.button_ok_caption', '?'), 'SMImage_InsertNewImage(document.form_imagedata.edit1.value, document.form_imagedata.edit2.value, document.form_imagedata.edit3.value);');
			jSMB2.Paint('jSMB2', tinyMCEPopup.getLang('smimage.button_cancel_caption', '?'), 'SMImage_CloseImageData();');
			/* ]]> */
			</script>
		</div>
	</form>
</div>