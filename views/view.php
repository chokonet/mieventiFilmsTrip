<?php
function get_template_header($opcion_name = 'header') {
    global $info_replase;
    $opcion_name = (isset($_GET['admin']) AND $_GET['admin'] == 'galeria') ? 'header' : $opcion_name;
    $file = PATH_MIEVENTO.'/template/'.$opcion_name.'.html';
    $template = file_get_contents($file);
    $template = str_replace('{site_url}', base_url(), $template);

    if ($opcion_name == 'header'):
        $template = str_replace('{class_b}', 'galerias', $template);
    else:
         $template = str_replace('{class_b}', '', $template);
    endif;

    $template = str_replace('{user_nick}', $info_replase->user_nick, $template);
    return $template;
}

function get_template_login_header() {
    global $info_replase;

    $file = PATH_MIEVENTO.'/template/header-login.html';
    $template = file_get_contents($file);
    $template = file_get_contents($file);
    $template = str_replace('{site_url}', base_url(), $template);
    return $template;
}

function get_template_footer() {
    $file = PATH_MIEVENTO.'/template/footer.html';
    $template = file_get_contents($file);
    $arch = (isset($_GET['admin']) AND $_GET['admin'] == 'galeria') ? 'functions' : 'functions-admin';
    $template = str_replace('{function}', $arch, $template);
    $template = str_replace('{site_url}', base_url(), $template);
    return $template;
}


/*********** VISTAS ADMIN *****************/