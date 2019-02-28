<?php
	$pdf=NULL;
	$pdf1=NULL;
	
	if($_GET['pdf']){
			$pdf = $_GET['pdf'];
	}
	
	if($_GET['pdf1']){
		if($_GET['pdf1'] != 'N'){
			$pdf1 = $_GET['pdf1'];
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<script type="text/javascript">
		document.oncontextmenu = function(){return false;}
	</script>
	<title>VISOR PDF</title>
</head>
<body>
	<br/>
	<img alt="PDF" src="./output/<?php echo $pdf ?>" />
	<?php
		if($pdf1 != 'N'){
			echo '<img src="./output/'.$pdf1.'" />';
		}
	?>
	<br/>&nbsp;
	<!--iframe src="LASA2017.pdf&embedded=true" style="width:500px; height:375px;" frameborder="0"></iframe-->
</body>

</html>
