<?php
$files = scandir('sites_content/');
unset($files[1]);
unset($files[0]);
foreach($files as $file) {
    $out = fopen("sites/".pathinfo('sites_content/'.$file)['filename'].".php", "w");
    $in = file_get_contents('sites_content/'.$file);

    echo '*'.pathinfo('sites_content/'.$file)['filename'], "\n";
    $txt = '<?php'."\n".'require "../php/code.php";'."\n".'$content = "";'."\n";
    $txt .= site_generate($in);
    $txt .= '$rootoff = "../";'."\n".'require "../php/base.php";'."\n".'?>'."\n";
/*
    echo 'sites_content/', $file, "\n";
    echo $in;
    echo 'sites/', $file, "\n";
    echo $out;
*/
    fwrite($out, $txt);

}

function site_generate($source) {
    $output = "";
    $tokens = explode("ayylmao", $source);
    foreach($tokens as $token) {
        $output .= '$content .= ';
        $tokenid = substr($token,0,8);
        if($tokenid == "_TEXT___") {
            echo '_TEXT___'."\n";
            $output .= "format_p(";

        } else if($tokenid == "_BCODE__") {
            echo '_BCODE__'."\n";
            $output .= "format_code_block_p(";
            
        } else if($tokenid == "_CODE___") {
            echo '_CODE___'."\n";
            $output .= "format_code_inline_p(";

        } else {
            echo 'NOT FOUND !!!!!'."\n"."\n";

        }
        $output .= "<<<'EOD'";
        $output .= substr($token, 8);
        $output .= "\n".'EOD'."\n".');'."\n";

    }

    
    return $output;

}
?>