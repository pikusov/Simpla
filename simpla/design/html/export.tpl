{capture name=tabs}
	<li><a href="index.php?module=ImportAdmin">Импорт</a></li>
	<li class="active"><a href="index.php?module=ExportAdmin">Экспорт</a></li>
	<li><a href="index.php?module=BackupAdmin">Бекап</a></li>			
{/capture}
{$meta_title='Экспорт товаров' scope=parent}

<script>
{literal}
	
var in_process=false;

$(function() {

	// On document load
	$('input#start').click(function() {
 
    	$("#progressbar").progressbar({ value: 0 });
 		
    	$("#start").hide('fast');
		do_export();
    
	});
  
	function do_export(page)
	{
		page = typeof(page) != 'undefined' ? page : 1;

		$.ajax({
 			 url: "ajax/export.php",
 			 	data: {page:page},
 			 	dataType: 'json',
  				success: function(data){
  				
    				if(data && !data.end)
    				{
    					$("#progressbar").progressbar({ value: 100*data.page/data.totalpages });
    					do_export(data.page*1+1);
    				}
    				else
    				{	
    					$("#progressbar").hide('fast');
    					window.location.href = 'files/export/export.csv';
 
    				}
  				},
				error:function(xhr, status, errorThrown) {
                	alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
        		}  				
  				
		});
	
	} 
	
});
{/literal}
</script>

<style>
	.ui-progressbar-value { background-image: url(design/images/progress.gif); background-position:left; border-color: #009ae2;}
	#progressbar{ clear: both; height:29px; }
	#result{ clear: both; width:100%;}
	#download{ display:none;  clear: both; }
</style>


{if $message_error}
<!-- Системное сообщение -->
<div class="message message_error">
	<span>
	{if $message_error == 'no_permission'}Установите права на запись в папку {$export_files_dir}
	{else}{$message_error}{/if}
	</span>
</div>
<!-- Системное сообщение (The End)-->
{/if}


<div>
	<h1>Экспорт товаров</h1>
	{if $message_error != 'no_permission'}
	<div id='progressbar'></div>
	<input class="button_green" id="start" type="button" name="" value="Экспортировать" />	
	{/if}
</div>
 
