<div class="links-admin links-event">
	<a href="<?php echo base_url(); ?>admin/eventos/" class="boton inf-admin">Ver Eventos</a>
	<a href="<?php echo base_url(); ?>admin/eventos/nuevo-evento/" class="boton inf-admin">Crear nuevo Evento</a>
</div>
<div class="ultimos-eventos container-eventos clearfix">
	<h3>Usuarios</h3>
	<div class="error-login active_error_form" style="display: none;">
		<b>ERROR:</b> Favor de llenar todos los campos.
	</div>
	<div class="caja-crear-categoria clearfix shadow crea-usu-caja">
		<h4>Crear Usuario</h4>

		<form action="<?php echo base_url().'admin/usuarios'; ?>" method="post" name="cuser" id="cuser">
			<label>Nombre del usuario</label>
			<input type="text" name="usu_name" id="usu_name">
			<label class="segundos">Nick</label>
			<input type="text" name="usu_nick" id="usu_nick" class="segundos">
			<label>Email</label>
			<input type="text" name="usu_email" id="usu_email">
			<label class="segundos">Contraseña</label>
			<input type="text" name="usu_password" id="usu_password" class="segundos">
			<input type="hidden" name="action" id="action" value="setSave">
			<input type="submit" value="Crear usuario">
		</form>
	</div>
	<div class="caja-crear-categoria segunda clearfix shadow">
		<h4>Todos los usuarios</h4>
		<div class="caja-usuarios">
			<div class="nombre-usu">Nombre</div>
			<div class="nick-usu">Nick</div>
			<div class="email-usu">Email</div>
			<div class="permisos-usu">Permisos</div>
			<div class="count-usu">Eventos</div>
		</div>
		<?php if (!empty($info_vew['usuarios']) ) :
			foreach ($info_vew['usuarios'] as $key => $usuario) :?>

				<div class="caja-usuarios">
					<div class="nombre-usu"><?php echo $usuario->usu_nombre; ?></div>
					<div class="nick-usu"><?php echo $usuario->usu_nick; ?></div>
					<div class="email-usu"><?php echo $usuario->usu_email; ?></div>
					<div class="permisos-usu"><?php echo $usuario->tipo; ?></div>
					<div class="count-usu"><?php echo $usuario->count; ?></div>
					<?php if ($usuario->usu_id != 1): ?>
						<div class="hover-usu">
							<a href="<?php echo base_url().'admin/usuarios/editar-usuario/'.$usuario->usu_id ?>">Editar Usuario</a>
							<?php if ($usuario->usu_id != 1 AND $usuario->count == 0) : ?>
								<a href="<?php echo base_url().'admin/usuarios/eliminar-usuario/'.$usuario->usu_id ?>">Eliminar Usuario</a>
							<?php elseif ($usuario->usu_id != 1):?>
								<p>Para eliminar no debe de tener eventos asignados.</p>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach;
		endif; ?>
	</div>

</div>