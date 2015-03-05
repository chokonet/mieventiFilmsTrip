<?php $estatus = isset($_GET['error']) ? $_GET['error'] : false;?>
<h2 class="tit-log">Mi evento</h2>
<?php if (isset($_GET['error'])):
	$text = ($estatus == 4) ? '<b>ERROR:</b> Nombre de usuario o contraseña no válidos.' : '' ; ?>
	<div class="error-login">
		<?php echo $text; ?>
	</div>
<?php endif; ?>

<div class="caja_login shadow">
	<form class="form" action="<?php echo base_url(); ?>" method="post">

		<label>Usuario</label>
		<input type="text" name="nick" required="true" placeholder="Introduce tu Usuario" />

		<label>Contraseña</label>
		<input type="password" name="password" required="true" placeholder="Introduce tu Contraseña" />

		<input type="hidden" name="action" value="login-user" />

		<input type="submit" value="Acceder" />

	</form>
</div>