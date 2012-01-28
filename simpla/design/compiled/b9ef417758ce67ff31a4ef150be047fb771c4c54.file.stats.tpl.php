<?php /* Smarty version Smarty-3.0.7, created on 2011-10-21 18:39:25
         compiled from "simpla/design/html/stats.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8533726474ea1922d54fcd9-72216320%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b9ef417758ce67ff31a4ef150be047fb771c4c54' => 
    array (
      0 => 'simpla/design/html/stats.tpl',
      1 => 1319211562,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8533726474ea1922d54fcd9-72216320',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php ob_start(); ?>
		<li class="active"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['url'][0][0]->url_modifier(array('module'=>'StatsAdmin'),$_smarty_tpl);?>
">Статистика</a></li>
<?php  Smarty::$_smarty_vars['capture']['tabs']=ob_get_clean();?>
<?php $_smarty_tpl->tpl_vars['meta_title'] = new Smarty_variable('Статистика', null, 1);?>

<script src="design/js/highcharts/js/highcharts.js" type="text/javascript"></script>

<script>
var chart;

$(function() {


var options = {
      chart: {
         renderTo: 'container',
         defaultSeriesType: 'line'
      },
      title: {
         text: 'Статистика заказов'
      },
      subtitle: {
         text: ''
      },
      xAxis: {
         type: 'datetime'
      },
      yAxis: {
		title: {
            text: '<?php echo $_smarty_tpl->getVariable('currency')->value->name;?>
'
         }
      },

 
      plotOptions: {
         line: {
            dataLabels: {
               enabled: true
            },
            enableMouseTracking: true
         }
      },
      series: []

};

	$.get('ajax/stat/stat.php', function(data) {
	
	           var series = {
	                data: []
	            };
	
	    series.name = 'Сумма заказов, <?php echo $_smarty_tpl->getVariable('currency')->value->sign;?>
';
	    
	    d = new Date();
		for(i=0; i<31; i++)
		{	
 			series.data.push([Date.UTC(1900+d.getYear(), d.getMonth(), d.getDate()), 0]);
			d.setDate(d.getDate()-1);
 		}
	    
	    // Iterate over the lines and add categories or series
	    $.each(data, function(lineNo, line) {

   	                    series.data.push([Date.UTC(line.year, line.month-1, line.day), parseInt(line.y)]);

	  
	    });
	    options.series.push(series);
	    
	    // Create the chart
	    var chart = new Highcharts.Chart(options);
	});
	
 

});
 

 
Highcharts.theme = {
   colors: ["#DDDF0D", "#7798BF", "#55BF3B", "#DF5353", "#aaeeee", "#ff0066", "#eeaaee", 
      "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
   chart: {
      backgroundColor: {
         linearGradient: [0, 0, 0, 400],
         stops: [
            [0, 'rgb(96, 96, 96)'],
            [1, 'rgb(16, 16, 16)']
         ]
      },
      borderWidth: 0,
      borderRadius: 15,
      plotBackgroundColor: null,
      plotShadow: false,
      plotBorderWidth: 0
   },
   title: {
      style: { 
         color: '#FFF',
         font: '16px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
      }
   },
   subtitle: {
      style: { 
         color: '#DDD',
         font: '12px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
      }
   },
   xAxis: {
      gridLineWidth: 0,
      lineColor: '#999',
      tickColor: '#999',
      labels: {
         style: {
            color: '#999',
            fontWeight: 'bold'
         }
      },
      title: {
         style: {
            color: '#AAA',
            font: 'bold 12px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
         }            
      }
   },
   yAxis: {
      alternateGridColor: null,
      minorTickInterval: null,
      gridLineColor: 'rgba(255, 255, 255, .1)',
      lineWidth: 0,
      tickWidth: 0,
      labels: {
         style: {
            color: '#999',
            fontWeight: 'bold'
         }
      },
      title: {
         style: {
            color: '#AAA',
            font: 'bold 12px Lucida Grande, Lucida Sans Unicode, Verdana, Arial, Helvetica, sans-serif'
         }            
      }
   },
   legend: {
      itemStyle: {
         color: '#CCC'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#333'
      }
   },
   labels: {
      style: {
         color: '#CCC'
      }
   },
   tooltip: {
      backgroundColor: {
         linearGradient: [0, 0, 0, 50],
         stops: [
            [0, 'rgba(96, 96, 96, .8)'],
            [1, 'rgba(16, 16, 16, .8)']
         ]
      },
      borderWidth: 0,
      style: {
         color: '#FFF'
      }
   },
   
   
   plotOptions: {
      line: {
         dataLabels: {
            color: '#CCC'
         },
         marker: {
            lineColor: '#333'
         }
      },
      spline: {
         marker: {
            lineColor: '#333'
         }
      },
      scatter: {
         marker: {
            lineColor: '#333'
         }
      }
   },
   
   toolbar: {
      itemStyle: {
         color: '#CCC'
      }
   },
   
   navigation: {
      buttonOptions: {
         backgroundColor: {
            linearGradient: [0, 0, 0, 20],
            stops: [
               [0.4, '#606060'],
               [0.6, '#333333']
            ]
         },
         borderColor: '#000000',
         symbolStroke: '#C0C0C0',
         hoverSymbolStroke: '#FFFFFF'
      }
   },
   
   exporting: {
      buttons: {
         exportButton: {
            symbolFill: '#55BE3B'
         },
         printButton: {
            symbolFill: '#7797BE'
         }
      }
   },   
   
   // special colors for some of the demo examples
   legendBackgroundColor: 'rgba(48, 48, 48, 0.8)',
   legendBackgroundColorSolid: 'rgb(70, 70, 70)',
   dataLabelsColor: '#444',
   textColor: '#E0E0E0',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
var highchartsOptions = Highcharts.setOptions(Highcharts.theme); 
 
</script>

 
 
<div>
<div id='container'>
</div>
 
</div>
