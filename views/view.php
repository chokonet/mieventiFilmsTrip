<?php
function get_template_header($opcion_name = 'header') {
    global $info_replase;
    $file = PATH_MIEVENTO.'/template/'.$opcion_name.'.html';
    $template = file_get_contents($file);
    $template = str_replace('{site_url}', base_url(), $template);
    $template = str_replace('{user_nick}', $info_replase->user_nick, $template);
    return $template;
}

function get_template_footer() {
    $file = PATH_MIEVENTO.'/template/footer.html';
    $template = file_get_contents($file);
    $template = str_replace('{site_url}', base_url(), $template);
    return $template;
}


/*********** VISTAS ADMIN *****************/