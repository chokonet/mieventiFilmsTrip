<h3 class="inf-admin">Hola, <?php echo $info_replase->user_nick ?></h3>
<p class="inf-admin">Bienvenido a Mi Evento - filmstrip-club.com</p>
<div class="links-admin">
	<a href="<?php echo base_url(); ?>admin/eventos/nuevo-evento/" class="boton inf-admin">Crear nuevo Evento</a>
	<a href="<?php echo base_url(); ?>admin/eventos/" class="boton inf-admin">Ver Eventos</a>
</div>
<div class="ultimos-eventos clearfix">
	<h3>Ultimos Eventos</h3>
	<div class="content-event">
		<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
		<p><a href="">Nombre Evento</a></p>
		<span>Boda</span>
		<span class="eliminar-evento">Eliminar</span>
	</div>
	<div class="content-event">
		<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
		<p><a href="">Nombre Evento</a></p>
		<span>XV Años</span>
		<span class="eliminar-evento">Eliminar</span>
	</div>
	<div class="content-event">
		<a href=""><img src="<?php echo base_url(); ?>uploads/img-p.png"></a>
		<p><a href="">Nombre Evento</a></p>
		<span>Primera comunion</span>
		<span class="eliminar-evento">Eliminar</span>
	</div>
</div>