<?php

	##################################################################################
	##                                                                              ##
	##    DESARROLLADO POR: Edwin Fredy Mamani Calderon                             ##
	##    EMAIL: mcedwin@gmail.com                                                  ##
	##    URL: http://www.mcedwin.com                                               ##
	##    URL APP: http://www.mcedwin.com/excel/                                    ##
	##    URL ARTICULO: http://tecnato.com/generar-reportes-en-excel-con-php/       ##
	##    DESARROLLADO GRACIAS A: http://www.gruposistemas.com/                     ##
	##                                                                              ##
	##################################################################################
	
	class ExcelWriter{
			
		var $content = '';
		var $err = '';
		var $xs = 0;
		var $cls = '';
		var $col = 0;
		var $maxcol = 0;
		var $cols = array();
		
		function ExcelWriter(){
		
		}
		
		function GetXLS($namebase,$download=true){
			header ("Expires: Mon, 15 Dec 2003 05:00:00 GMT");
			header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
			header ("Cache-Control: no-cache, must-revalidate");
			header ("Pragma: no-cache");
			if($download){
				header ("Content-type: application/x-msexcel");
				header ("Content-Disposition: attachment; filename=\"" . basename($namebase.'.xls') . "\"" );
				header ("Content-Description: PHP/INTERBASE Generated Data" );
			}
			echo $this->GetHeader();
			echo $this->content;
			echo $this->GetFooter();
		}
		
		function Close(){
			$this->$content='';
			$this->$err='';
			$this->$newRow=false;
			$this->$xs = 0;
			$this->$cls = '';
			$this->$col = 0;
			$this->$maxcol = 0;
			$this->$cols = array();
		}
						
		function GetHeader()
		{
			$header = '<html xmlns:o="urn:schemas-microsoft-com:office:office"
					xmlns:x="urn:schemas-microsoft-com:office:excel"
					xmlns="http://www.w3.org/TR/REC-html40">
					
					<head>
					<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
					<meta name=ProgId content=Excel.Sheet>
					<meta name=Generator content="Microsoft Excel 11">
					<link rel=File-List href="tempo_archivos/filelist.xml">
					<link rel=Edit-Time-Data href="tempo_archivos/editdata.mso">
					<link rel=OLE-Object-Data href="tempo_archivos/oledata.mso">
					<!--[if gte mso 9]><xml>
					 <o:DocumentProperties>
					  <o:Author>WinuE</o:Author>
					  <o:LastAuthor>WinuE</o:LastAuthor>
					  <o:Created>2010-07-20T02:44:40Z</o:Created>
					  <o:LastSaved>2010-07-20T02:44:58Z</o:LastSaved>
					  <o:Company>Windows uE</o:Company>
					  <o:Version>11.8132</o:Version>
					 </o:DocumentProperties>
					</xml><![endif]-->
					<style>
					<!--table
						{mso-displayed-decimal-separator:"\.";
						mso-displayed-thousand-separator:"\,";}
					@page
						{margin:.98in .79in .98in .79in;
						mso-header-margin:0in;
						mso-footer-margin:0in;}
					tr
						{mso-height-source:auto;}
					col
						{mso-width-source:auto;}
					br
						{mso-data-placement:same-cell;}
					.style0
						{mso-number-format:General;
						text-align:general;
						vertical-align:bottom;
						white-space:nowrap;
						mso-rotate:0;
						mso-background-source:auto;
						mso-pattern:auto;
						color:windowtext;
						font-size:10.0pt;
						font-weight:400;
						font-style:normal;
						text-decoration:none;
						font-family:Arial;
						mso-generic-font-family:auto;
						mso-font-charset:0;
						border:none;
						mso-protection:locked visible;
						mso-style-name:Normal;
						mso-style-id:0;}
					td
						{mso-style-parent:style0;
						padding-top:1px;
						padding-right:1px;
						padding-left:1px;
						mso-ignore:padding;
						color:windowtext;
						font-size:10.0pt;
						font-weight:400;
						font-style:normal;
						text-decoration:none;
						font-family:Arial;
						mso-generic-font-family:auto;
						mso-font-charset:0;
						mso-number-format:General;
						text-align:general;
						vertical-align:bottom;
						border:none;
						mso-background-source:auto;
						mso-pattern:auto;
						mso-protection:locked visible;
						white-space:nowrap;
						mso-rotate:0;}
					.normal
						{mso-style-parent:style0;
						white-space:normal;}
					.numero
						{mso-style-parent:style0;
						white-space:normal;}
					.fecha
						{mso-style-parent:style0;
						mso-number-format:"Short Date";}
					.theader
						{mso-style-parent:style0;
						border:.5pt solid #000000;
						color: white;
						background: #999999;
						text-align:center; font-weight:700;
						font-size:10px;
						vertical-align:middle;
						white-space:normal;
						mso-pattern:auto none; }
					.bold
						{mso-style-parent:style0;
						font-weight:700;
						font-size:15px;
						}
				'.$this->cls.'				
				-->
				</style>
				<!--[if gte mso 9]><xml>
				 <x:ExcelWorkbook>
				  <x:ExcelWorksheets>
				   <x:ExcelWorksheet>
					<x:Name>Hoja1</x:Name>
					<x:WorksheetOptions>
					 <x:DefaultColWidth>10</x:DefaultColWidth>
					 <x:Selected/>
					 <x:ProtectContents>False</x:ProtectContents>
					 <x:ProtectObjects>False</x:ProtectObjects>
					 <x:ProtectScenarios>False</x:ProtectScenarios>
					</x:WorksheetOptions>
				   </x:ExcelWorksheet>
				  </x:ExcelWorksheets>
				  <x:WindowHeight>10740</x:WindowHeight>
				  <x:WindowWidth>17595</x:WindowWidth>
				  <x:WindowTopX>480</x:WindowTopX>
				  <x:WindowTopY>90</x:WindowTopY>
				  <x:ProtectStructure>False</x:ProtectStructure>
				  <x:ProtectWindows>False</x:ProtectWindows>
				 </x:ExcelWorkbook>
				</xml><![endif]-->
				</head>

				<body link=blue vlink=purple>
				<table x:str border=0 cellpadding=0 cellspacing=0 style="border-collapse: collapse;table-layout:fixed;">'."\n";
			
			for($i=0;$i<$this->maxcol;$i++){
				if(empty($this->cols[$i])) $header .= "<col width=80 style='width:60pt'>\n";
				else $header .= "<col width=".$this->cols[$i]." style='mso-width-source:userset;width:".round($this->cols[$i]*3/4)."pt'>\n";
			}
			return $header;
		}
		
		function GetFooter(){
			return "</table></body></html>";
		}
		
		function SetContent($content){
			$this->content .= $content;
		}
		
		function WriteLine($line_arr){
			$this->content .= "<tr>";
			foreach($line_arr as $col) $this->content .= "<td class=normal width=64 >$col</td>";
			$this->content .= "</tr>";
			if($this->maxcol<=count($line_arr))$this->maxcol = count($line_arr);
		}
		
		function GetContent(){
			return $this->content;
		}
		
		function OpenRow(){
			$this->content .= "<tr>\n";
			$this->col = 0;
		}
		
		function CloseRow(){
			$this->content .= "</tr>\n";
			$this->col = 0;
		}
		
		function NewCell($value,$autow=false,$style=''){
			$rel = '';
			$sty = '';
			$cl = '';
			$class = '';
			$width1 = 80;
			$dnum = 0;
			$width2 = round($width1*3/4);
			
			if($style['type']=='int'){
				$rel .= 'align=right x:num';
				$class = 'numero';
			}else if($style['type']=='date'){
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", '07/08/2000', $aFecIni);
				ereg( "([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})", $value, $aFecFin);
				$date1 = mktime(0,0,0,$aFecIni[2], $aFecIni[1], $aFecIni[3]);
				$date2 = mktime(0,0,0,$aFecFin[2], $aFecFin[1], $aFecFin[3]);
				$dnum = round(($date2-$date1)/24/60/60)+36745;
				$rel .= 'align=right x:num="'.$dnum.'"';
				$class = 'fecha';
				$cl .= ' mso-number-format:"Short Date"; ';
			}else if($style['type']=='moneda'){
				$rel .= 'align=right x:num'; 
				$class = 'numero';
			} else {
				$class = 'normal';
			}
			
			if($style['bold']=='true'){
				$cl .= ' font-weight:700; ';
			}
			
			if(!empty($style['align'])){
				$align .= ' align='.$style['align'].' ';
				$cl .= ' text-align:'.$style['align'].'; ';
			}
			
			if($autow==true){
				$width1 = strlen($value)*8;
				$width2 = round($width1*3/4);
				$sty .= ' width:'.$width2.'pt ';
			}else{
				if(!empty($style['width'])){
					$width1 = $style['width'];
					$width2 = round($width1*3/4);
					$sty .= ' width:'.$width2.'pt ';
				}else{
					$sty .= ' width:'.$width2.'pt ';
				}
			}
			$this->cols[$this->col] = $width1;
			$this->col++;
			if($this->maxcol<=$this->col)$this->maxcol = $this->col;
			
			if(!empty($style['border'])){
				$cl .= 'border: .5pt solid #'.$style['border'].'; ';
			}
			
			if(!empty($style['color'])){
				$cl .= 'color:#'.$style['color'].'; ';
			}
			if(!empty($style['background'])){
				$cl .= 'background:#'.$style['background'].'; mso-pattern:auto none; ';
			}
			
			if(!empty($sty)) $sty = "style='$sty'";
			
			if(!empty($cl)){
				$this->cls .= ".xs$this->xs{mso-style-parent:style0; $cl }\n";
				$class = "xs$this->xs";
				$this->xs++;
			}
			
			$this->content .= "<td class=$class $align width=$width1 $sty $rel>$value</td>\n";
		}
	}
?>