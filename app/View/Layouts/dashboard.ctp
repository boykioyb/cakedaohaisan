<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<!DOCTYPE html>
<html>
	<head>
		<?php echo $this->Html->charset(); ?>
		<title>
			<?php echo $this->fetch('title'); ?>
		</title>
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
		<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css');
		echo $this->Html->css('animate');
		echo $this->Html->css('style');
		echo $this->fetch('css');

		// Mainly scripts
		echo $this->Html->script('jquery-2.1.1');
		echo $this->Html->script('bootstrap.min');
		echo $this->Html->script('plugins/metisMenu/jquery.metisMenu');
		echo $this->Html->script('select2.min');
		echo $this->Html->script('plugins/iCheck/icheck.min');

		// Custom and plugin javascript
		echo $this->Html->script('inspinia');
		echo $this->Html->script('plugins/pace/pace.min');
		echo $this->element('js/main');
		echo $this->fetch('script');
		?>

		<script>
			var BASE_URL = "<?php echo Router::url('/', true) ?>"
		</script>
	</head>
	<body>
		<div id="wrapper">
			<?php echo $this->element('navbar_new') ?>
			<div id="page-wrapper" class="gray-bg">
				<div class="row border-bottom">
					<?php echo $this->element('navbar-static-top', ['class' => 'white-bg']); ?>
				</div>
				<div class="wrapper wrapper-content animated fadeInRight">
					<?php echo $this->fetch('content'); ?>
				</div>
			</div>
		</div>
	</body>
</html>
