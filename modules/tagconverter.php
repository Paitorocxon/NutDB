<?php

function tagConv ($string){
    $string = htmlspecialchars($string);
    date_default_timezone_set($GLOBALS['timezone']);
    ini_set("highlight.comment", "#0F0");
    ini_set("highlight.default", "#000000");
    ini_set("highlight.html", "#808080");
    ini_set("highlight.keyword", "#0000BB; font-weight: bold");
    ini_set("highlight.string", "#DD0000");
    
    while (strpos($string, '[list]') !== false && strpos($string, '[/list]') !== false) {
        $mstring = get_string_between($string, '[list]', '[/list]');
        $string = str_replace('[list]'.$mstring.'[/list]','<div class="table">'.str_replace("\n".'-','<br>• ',$mstring).'</div>',$string);      
    }
    
    while (strpos($string, '[b]') !== false && strpos($string, '[/b]') !== false) {
        $mstring = get_string_between($string, '[b]', '[/b]');
        $string = str_replace('[b]'.$mstring.'[/b]','<b>'.$mstring.'</b>',$string);      
    }
    while (strpos($string, '[i]') !== false && strpos($string, '[/i]') !== false) {
        $mstring = get_string_between($string, '[i]', '[/i]');
        $string = str_replace('[i]'.$mstring.'[/i]','<i>'.$mstring.'</i>',$string);      
    }
    while (strpos($string, '[h1]') !== false && strpos($string, '[/h1]') !== false) {
        $mstring = get_string_between($string, '[h1]', '[/h1]');
        $string = str_replace('[h1]'.$mstring.'[/h1]','<h1>'.$mstring.'</h1>',$string);      
    }
    while (strpos($string, '[h2]') !== false && strpos($string, '[/h2]') !== false) {
        $mstring = get_string_between($string, '[h2]', '[/h2]');
        $string = str_replace('[h2]'.$mstring.'[/h2]','<h2>'.$mstring.'</h2>',$string);      
    }
    while (strpos($string, '[h3]') !== false && strpos($string, '[/h3]') !== false) {
        $mstring = get_string_between($string, '[h3]', '[/h3]');
        $string = str_replace('[h3]'.$mstring.'[/h3]','<h3>'.$mstring.'</h3>',$string);      
    }
    while (strpos($string, '[h4]') !== false && strpos($string, '[/h4]') !== false) {
        $mstring = get_string_between($string, '[h4]', '[/h4]');
        $string = str_replace('[h4]'.$mstring.'[/h4]','<h4>'.$mstring.'</h4>',$string);      
    }
    while (strpos($string, '[h5]') !== false && strpos($string, '[/h5]') !== false) {
        $mstring = get_string_between($string, '[h5]', '[/h5]');
        $string = str_replace('[h5]'.$mstring.'[/h5]','<h5>'.$mstring.'</h5>',$string);      
    }
    while (strpos($string, '[h6]') !== false && strpos($string, '[/h6]') !== false) {
        $mstring = get_string_between($string, '[h6]', '[/h6]');
        $string = str_replace('[h6]'.$mstring.'[/h6]','<h6>'.$mstring.'</h6>',$string);      
    }
    while (strpos($string, '[a]') !== false && strpos($string, '[/a]') !== false) {
        $mstring = get_string_between($string, '[a]', '[/a]');
        $string = str_replace('[a]'.$mstring.'[/a]','🔗<a href="'.$mstring.'">'.$mstring.'</a>',$string);      
    }
    while (strpos($string, '[progress]') !== false && strpos($string, '[/progress]') !== false) {
        $mstring = get_string_between($string, '[progress]', '[/progress]');
        if (is_numeric($mstring) && $mstring < 101 && $mstring > -1) {
            $string = str_replace('[progress]'.$mstring.'[/progress]','<div class="progress_bg"><div class="progress" style="width:'.$mstring.'%"></div></div>',$string);
        }        
    }
    
    
    
    
    
    
        $string = str_replace('\'','&#39;',$string);
        $string = str_replace('\"','&#34;',$string);
        $string = str_replace('\´','&#180;',$string);
        $string = str_replace('\`','&#96;',$string);
    
    
        $string = str_replace("\n",'<br />',$string);
        
        $string = str_replace('[strike]','<strike>',$string);
        $string = str_replace('[/strike]','</strike>',$string);
        
        
        $string = str_replace('[break]','<br />',$string);
        
        $string = str_replace('[time]',date('H:i:s A'),$string);
        $string = str_replace('[date]',date('l jS F Y'),$string);
        
        $string = str_replace('[hr]','<hr>',$string);
        
        $string = str_replace('[center]','<center>',$string);
        $string = str_replace('[/center]','</center>',$string);
    return $string;
}















function tagDeconv ($string){
    //$string = htmlspecialchars($string);
    date_default_timezone_set($GLOBALS['timezone']);
    ini_set("highlight.comment", "#0F0");
    ini_set("highlight.default", "#000000");
    ini_set("highlight.html", "#808080");
    ini_set("highlight.keyword", "#0000BB; font-weight: bold");
    ini_set("highlight.string", "#DD0000");
    
    while (strpos($string, '<div class="table">') !== false && strpos($string, '</div>') !== false) {
        $mstring = get_string_between($string, '<div class="table">', '</div>');
        $string = str_replace('<div class="table">'.$mstring.'</div>','[list]'.str_replace('<br>• ', "\n".'-', $mstring).'[/list]',$string);      
    }
    
    while (strpos($string, '<b>') !== false && strpos($string, '</b>') !== false) {
        $mstring = get_string_between($string, '<b>', '</b>');
        $string = str_replace('<b>'.$mstring.'</b>','[b]'.$mstring.'[/b]',$string);      
    }
    while (strpos($string, '<i>') !== false && strpos($string, '</i>') !== false) {
        $mstring = get_string_between($string, '<i>', '</i>');
        $string = str_replace('<i>'.$mstring.'</i>','[i]'.$mstring.'[/i]',$string);      
    }
    while (strpos($string, '<h1>') !== false && strpos($string, '</h1>') !== false) {
        $mstring = get_string_between($string, '<h1>', '</h1>');
        $string = str_replace('<h1>'.$mstring.'</h1>','[h1]'.$mstring.'[/h1]',$string);      
    }
    while (strpos($string, '<h2>') !== false && strpos($string, '</h2>') !== false) {
        $mstring = get_string_between($string, '<h2>', '</h2>');
        $string = str_replace('<h2>'.$mstring.'</h2>','[h2]'.$mstring.'[/h2]',$string);      
    }
    while (strpos($string, '<h3>') !== false && strpos($string, '</h3>') !== false) {
        $mstring = get_string_between($string, '<h3>', '</h3>');
        $string = str_replace('<h3>'.$mstring.'</h3>','[h3]'.$mstring.'[/h3]',$string);      
    }
    while (strpos($string, '<h4>') !== false && strpos($string, '</h4>') !== false) {
        $mstring = get_string_between($string, '<h4>', '</h4>');
        $string = str_replace('<h4>'.$mstring.'</h4>','[h4]'.$mstring.'[/h4]',$string);      
    }
    while (strpos($string, '<h5>') !== false && strpos($string, '</h5>') !== false) {
        $mstring = get_string_between($string, '<h5>', '</h5>');
        $string = str_replace('<h5>'.$mstring.'</h5>','[h5]'.$mstring.'[/h5]',$string);      
    }
    while (strpos($string, '<h6>') !== false && strpos($string, '</h6>') !== false) {
        $mstring = get_string_between($string, '<h6>', '</h6>');
        $string = str_replace('<h6>'.$mstring.'</h6>','[h6]'.$mstring.'[/h6]',$string);      
    }
    
    
    while (strpos($string, '🔗<a ') !== false && strpos($string, '</a>') !== false) {
        $mstring = get_string_between($string, '<a href="', '">');
        $string = str_replace('🔗<a href="'.$mstring.'">'.$mstring.'</a>','[a]'.$mstring.'[/a]',$string);      
    }
    
    while (strpos($string, '<div class="progress_bg"><div class="progress" style="width:') !== false && strpos($string, '%"></div></div>') !== false) {
        $mstring = get_string_between($string, '<div class="progress_bg"><div class="progress" style="width:', '%"></div></div>');
        if (is_numeric($mstring) && $mstring < 101 && $mstring > -1) {
            $string = str_replace('<div class="progress_bg"><div class="progress" style="width:'.$mstring.'%"></div></div>', '[progress]'.$mstring.'[/progress]',$string);
        }
    }
    
    
    
        $string = str_replace('&#39;','\'',$string);
        $string = str_replace('&#34;','\"',$string);
        $string = str_replace('&#180;','\´',$string);
        $string = str_replace('&#96;','\`',$string);
    
    
        $string = str_replace("<br />","\n",$string);
        
        $string = str_replace('<strike>','[strike]',$string);
        $string = str_replace('</strike>','[/strike]',$string);
        
        
        $string = str_replace('<br />','[break]',$string);
        
        $string = str_replace('[time]',date('H:i:s A'),$string);
        $string = str_replace('[date]',date('l jS F Y'),$string);
        
        $string = str_replace('<hr>','[hr]',$string);
        
        $string = str_replace('<center>','[center]',$string);
        $string = str_replace('</center>','[/center]',$string);
    return $string;
}


function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function listTickets() {
    
}