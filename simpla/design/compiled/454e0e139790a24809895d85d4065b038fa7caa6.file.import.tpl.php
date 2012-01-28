<?php /* Smarty version Smarty-3.0.7, created on 2011-12-24 21:58:14
         compiled from "simpla/design/html/import.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3603065044ef62ed6b8f3e8-92647039%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '454e0e139790a24809895d85d4065b038fa7caa6' => 
    array (
      0 => 'simpla/design/html/import.tpl',
      1 => 1324670255,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3603065044ef62ed6b8f3e8-92647039',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_escape')) include '/Users/denispikusov/Sites/simpla/Smarty/libs/plugins/modifier.escape.php';
?><?php ob_start(); ?>
	<li class="active"><a href="index.php?module=ImportAdmin">Импорт</a></li>
	<li><a href="index.php?module=ExportAdmin">Экспорт</a></li>		
	<li><a href="index.php?module=BackupAdmin">Бекап</a></li>		
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Импорт товаров', null, 1);?>

<script>
<?php if ($_smarty_tpl->getVariable('filename')->value){?>

	
	var in_process=false;
	var count=1;

	// On document load
	$(function(){
    	$("#progressbar").progressbar({ value: 1 });
		in_process=true;
		do_import();	    
	});
  
	function do_import(from)
	{
		from = typeof(from) != 'undefined' ? from : 0;
		$.ajax({
 			 url: "ajax/import.php",
 			 	data: {from:from},
 			 	dataType: 'json',
  				success: function(data){
  					for(var key in data.items)
  					{
    					$('ul#import_result').prepend('<li><span class=count>'+count+'</span> <span title='+data.items[key].status+' class="status '+data.items[key].status+'"></span> <a target=_blank href="index.php?module=ProductAdmin&id='+data.items[key].product.id+'">'+data.items[key].product.name+'</a> '+data.items[key].variant.name+'</li>');
    					count++;
    				}

   					$("#progressbar").progressbar({ value: 100*data.from/data.totalsize });
  				
    				if(data != false && !data.end)
    				{
    					do_import(data.from);
    				}
    				else
    				{
    					$("#progressbar").hide('fast');
    					in_process = false;
    				}
  				},
				error: function(xhr, status, errorThrown) {
                	alert(errorThrown+'\n'+status+'\n'+xhr.statusText);
        		}  				
		});
	
	} 

<?php }?>
</script>

<style>
	.ui-progressbar-value { background-color:#b4defc; background-image: url(design/images/progress.gif); background-position:left; border-color: #009ae2;}
	#progressbar{ clear: both; height:29px;}
	#result{ clear: both; width:100%;}
</style>

<?php if ($_smarty_tpl->getVariable('message_error')->value){?>
<!-- Системное сообщение -->
<div class="message message_error">
	<span>
	<?php if ($_smarty_tpl->getVariable('message_error')->value=='no_permission'){?>Установите права на запись в папку <?php echo $_smarty_tpl->getVariable('import_files_dir')->value;?>

	<?php }elseif($_smarty_tpl->getVariable('message_error')->value=='convert_error'){?>Не получилось сконвертировать файл в кодировку UTF8
	<?php }elseif($_smarty_tpl->getVariable('message_error')->value=='locale_error'){?>На сервере не установлена локаль <?php echo $_smarty_tpl->getVariable('locale')->value;?>
, импорт может работать некорректно
	<?php }else{ ?><?php echo $_smarty_tpl->getVariable('message_error')->value;?>
<?php }?>
	</span>
</div>
<!-- Системное сообщение (The End)-->
<?php }?>

	<?php if ($_smarty_tpl->getVariable('message_error')->value!='no_permission'){?>
	
	<?php if ($_smarty_tpl->getVariable('filename')->value){?>
	<div>
		<h1>Импорт <?php echo smarty_modifier_escape($_smarty_tpl->getVariable('filename')->value);?>
</h1>
	</div>
	<div id='progressbar'></div>
	<ul id='import_result'></ul>
	<?php }else{ ?>
	
		<h1>Импорт товаров</h1>

		<div class="block">	
		<form method=post id=product enctype="multipart/form-data">
			<input type=hidden name="session_id" value="<?php echo $_SESSION['id'];?>
">
			<input name="file" class="import_file" type="file" value="" />
			<input class="button_green" type="submit" name="" value="Загрузить" />
			<p>
				(максимальный размер файла &mdash; <?php if ($_smarty_tpl->getVariable('config')->value->max_upload_filesize>1024*1024){?><?php echo $_smarty_tpl->getVariable('config')->value->max_upload_filesize/1024/round(1024,'2');?>
 МБ<?php }else{ ?><?php echo $_smarty_tpl->getVariable('config')->value->max_upload_filesize/round(1024,'2');?>
 КБ<?php }?>)
			</p>

			
		</form>
		</div>		
	
		<div class="block block_help">
		<p>
			Создайте бекап на случай неудачного импорта. 
		</p>
		<p>
			Сохраните таблицу в формате CSV
		</p>
		<p>
			В первой строке таблицы должны быть указаны названия колонок в таком формате:
	
			<ul>
				<li><label>Товар</label> название товара</li>
				<li><label>Категория</label> категория товара</li>
				<li><label>Бренд</label> бренд товара</li>
				<li><label>Вариант</label> название варианта</li>
				<li><label>Цена</label> цена товара товара</li>
				<li><label>Старая цена</label> старая цена товара</li>
				<li><label>Склад</label> количество товара на складе</li>
				<li><label>Артикул</label> артикул товара</li>
				<li><label>Видим</label> отображение товара на сайте (0 или 1)</li>
				<li><label>Рекомендуемый</label> является ли товар рекомендуемым (0 или 1)</li>
				<li><label>Аннотация</label> краткое описание товара</li>
				<li><label>Адрес</label> адрес страницы товара</li>
				<li><label>Описание</label> полное описание товара</li>
				<li><label>Изображения</label> имена локальных файлов или url изображений в интернете, через запятую</li>
				<li><label>Заголовок страницы</label> заголовок страницы товара (Meta title)</li>
				<li><label>Ключевые слова</label> ключевые слова (Meta keywords)</li>
				<li><label>Описание страницы</label> описание страницы товара (Meta description)</li>
			</ul>
		</p>
		<p>
			Любое другое название колонки трактуется как название свойства товара
		</p>
		<p>
			<a href='files/import/example.csv'>Скачать пример файла</a>
		</p>
		</div>		
	
	<?php }?>


<?php }?>