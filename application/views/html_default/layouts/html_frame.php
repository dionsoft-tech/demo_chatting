<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="EN">
<head>
	<!-- meta -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<title><?php echo $html['title'] ?? '' ; ?></title>
	<link rel="icon" href="../assets/img/favicon.ico" type="image/x-icon"/>

	<!-- js - header load -->
	<!-- Fonts and icons -->
	<?php if (isset($html['js']['header']) && is_array($html['js']['header']) && count($html['js']['header']) > 0) {
		foreach ($html['js']['header'] as $js) {
			echo script_tag($js);
		}
	}
	?>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['../assets/css/fonts.min.css']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>
	
	<!-- css load -->
	<?php if (isset($html['css']) && is_array($html['css']) && count($html['css']) > 0) {
		foreach ($html['css'] as $key => $css) {
			echo link_tag($css);
		}
	}
	?>
	
</head>
<body data-background-color="dark">

<?php echo $html['output']; ?>

<!-- js - footer load -->
<?php if (isset($html['js']['footer']) && is_array($html['js']['footer']) && count($html['js']['footer']) > 0) {
	foreach ($html['js']['footer'] as $js) {
		echo script_tag($js);
	}
}
?>
</body>
</html>