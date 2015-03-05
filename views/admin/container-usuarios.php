<div class="links-admin links-event">
	<a href="<?php echo base_url(); ?>admin/eventos/" class="boton inf-admin">Ver Eventos</a>
	<a href="<?php echo base_url(); ?>admin/eventos/nuevo-evento/" class="boton inf-admin">Crear nuevo Evento</a>
</div>
<div class="ultimos-eventos container-eventos clearfix">
	<h3>Usuarios</h3>
	<div class="caja-crear-categoria clearfix shadow">
		<h4>Crear Usuario</h4>
		<form action="<?php echo base_url().'admin/usuarios'; ?>" method="post" name="ccatego" id="ccatego">
			<label>Nombre del usuario</label>
			<input type="text" name="usu_name" id="usu_name">
			<input type="hidden" name="action" id="action" value="setSave">
			<input type="submit" value="Crear usuario">
		</form>
	</div>
	<div class="caja-crear-categoria clearfix shadow">
		<h4>Todos los usuarios</h4>
		<?php if (!empty($info_vew['usuarios']) ) :
			foreach ($info_vew['usuarios'] as $key => $usuarios) : ?>

			<?php endforeach;
		endif; ?>
	</div>

</div>