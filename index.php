<?php
// 91f7d09794d8da29f028e77df49d4907
function clrStr($in)
{
    $in = strtoupper($in);
    $in = str_replace('A', '<span style="color:#ffbf00">a</span>', $in);
    $in = str_replace('B', '<span style="color:#9A6324">b</span>', $in);
    $in = str_replace('C', '<span style="color:#808000">c</span>', $in);
    $in = str_replace('D', '<span style="color:#469990">d</span>', $in);
    $in = str_replace('E', '<span style="color:#ffb6c1">e</span>', $in);
    $in = str_replace('F', '<span style="color:#469990">f</span>', $in);
    $in = str_replace('G', '<span style="color:#e6194B">g</span>', $in);
    $in = str_replace('H', '<span style="color:#f58231">h</span>', $in);
    $in = str_replace('I', '<span style="color:#ffe119">i</span>', $in);
    $in = str_replace('J', '<span style="color:#bfef45">j</span>', $in);
    $in = str_replace('K', '<span style="color:#3cb44b">k</span>', $in);
    $in = str_replace('L', '<span style="color:#42d4f4">l</span>', $in);
    $in = str_replace('M', '<span style="color:#f08080">m</span>', $in);
    $in = str_replace('N', '<span style="color:#911eb4">n</span>', $in);
    $in = str_replace('O', '<span style="color:#f032e6">o</span>', $in);
    $in = str_replace('P', '<span style="color:#a9a9a9">p</span>', $in);
    $in = str_replace('Q', '<span style="color:#fabebe">q</span>', $in);
    $in = str_replace('R', '<span style="color:#ffd8b1">r</span>', $in);
    $in = str_replace('S', '<span style="color:#fffac8">s</span>', $in);
    $in = str_replace('T', '<span style="color:#aaffc3">t</span>', $in);
    $in = str_replace('U', '<span style="color:#e6beff">u</span>', $in);
    $in = str_replace('V', '<span style="color:#ffbf00">v</span>', $in);
    $in = str_replace('W', '<span style="color:#ffb6c1">w</span>', $in);
    $in = str_replace('X', '<span style="color:#ffffff">x</span>', $in);
    $in = str_replace('Y', '<span style="color:#ffbf00">y</span>', $in);
    $in = str_replace('Z', '<span style="color:#ffb6c1">z</span>', $in);
    return $in;
}

if(isset($_GET['z']))
{
    header('Location: http://'.$_GET['z']);
    exit;
}

if(isset($_GET['r']))
{
    function make_seed()
    {
        list($usec, $sec) = explode(' ', microtime());
        return $sec + $usec * 1000000;
    }
    mt_srand(make_seed());

    $links = explode(PHP_EOL, file_get_contents('oix/'.strtolower($_GET['r']).'.txt'));
    $ri = mt_rand(0, count($links)-1);
    
    header('Location: http://'.$_GET['r']."/".$links[$ri]);
    exit;
}

if(!is_dir('oix'))
    mkdir('oix');

if(stripos($_SERVER['REQUEST_URI'], 'kill') !== false)
{
    file_put_contents("oix/auth", "", LOCK_EX);
    echo "All remote hosts deauthorized.";
    exit;
}

if(stripos($_SERVER['REQUEST_URI'], 'authme') !== false)
{
    file_put_contents("oix/auth", $_SERVER['REMOTE_ADDR'] . ":", LOCK_EX | FILE_APPEND);
    echo $_SERVER['REMOTE_ADDR'] . " Authorized.";
    exit;
}

if(stripos($_SERVER['REQUEST_URI'], '?h=') === false && strlen($_SERVER['REQUEST_URI']) > 2 && stripos($_SERVER['REQUEST_URI'], '.') !== false)
    $_GET['a'] = str_replace('/?', '', $_SERVER['REQUEST_URI']);

if(isset($_GET['q']))
    $_GET['a'] = $_GET['q'];

if(isset($_GET['a']))
{
    $ourl = $_GET['a'];
    $_GET['a'] = str_replace('http://', '', $_GET['a']);
    $_GET['a'] = str_replace('https://', '', $_GET['a']);
    $_GET['a'] = str_replace('www.', '', $_GET['a']);
    $p = explode('/', $_GET['a'], 2);

    //Validate
    /*if(strlen($p[0]) <= 4 && strlen($p[1]) <= 3)
    {
    header('Location: '.$ourl);
    exit;
    }*/

    //Are you authorized?
    if(stripos(file_get_contents('oix/auth'), $_SERVER['REMOTE_ADDR']) !== false)
    {
        //Does it already exist?
        @$links = explode(PHP_EOL, file_get_contents('oix/'.strtolower($p[0]).'.txt'));
        foreach($links as $l)
        {
            if(trim($l) == $p[1])
            {
                header('Location: '.$ourl);
                exit;
            }
        }

        file_put_contents("oix/".strtolower($p[0]).".txt", $p[1]."\n", LOCK_EX | FILE_APPEND);
        header('Location: /?h='.strtolower($p[0]));
        exit;
    }
    else
    {
        echo "Sorry you are not authorized to do this.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#"> 
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="A Collaberative Database of Awesome Links">
<meta name="keywords" content="collaberative, collaberation, links, database"/>

<link rel="shortcut icon" href="favicon.ico">
<link rel="apple-touch-icon" href="favicon.ico">
<link rel="apple-touch-icon-precomposed" href="favicon.ico">
<meta property="og:image" content="favicon.ico">
<meta property="twitter:image:src" content="favicon.ico">
<link rel="icon" sizes="192x192" href="favicon.ico">
<meta name="image" content="favicon.ico">
<meta itemprop="image" content="favicon.ico">
<meta name="og:image" content="favicon.ico">
<meta name="og:url" content="">

<meta name="theme-color" content="#ffbf00">
<meta itemprop="name" content="A Collaberative Database of Awesome Links">
<meta itemprop="description" content="A Collaberative Database of Awesome Links">
<meta name="og:title" content="A Collaberative Database of Awesome Links">
<meta name="og:description" content="A Collaberative Database of Awesome Links">
<meta name="og:site_name" content="OIX">
<meta name="og:type" content="website">
<meta name="og:url" content="https://github.com/OIX-Shared-Bookmarks/">

<style>
    hr{
        border: 0;
        height: 1px;
        background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
    }

    .outline
    {
        font-family: Georgia;
        font-size: 0.8em;
        color: white;
        text-shadow:
            -1px -1px 0 #000,
            1px -1px 0 #000,
            -1px 1px 0 #000,
            1px 1px 0 #000;
        word-break: break-all;
    }
    a:hover, a:visited, a:link, a:active
    {
        font-family: Georgia;
        font-size: 1.6em;
        color: white;
        text-shadow:
            -1px -1px 0 #000,
            1px -1px 0 #000,
            -1px 1px 0 #000,
            1px 1px 0 #000;
        text-decoration: none;  
    }
    ::-webkit-scrollbar{width: 8px;height: 8px;}
    ::-webkit-scrollbar-button{width: 0px;height: 0px;}
    ::-webkit-scrollbar-thumb{background: #ffbf00;border: 0px none #333;border-radius: 0px;}
    ::-webkit-scrollbar-thumb:hover{background: #ff7b36;}
    ::-webkit-scrollbar-thumb:active{background: #ff7b36;}
    ::-webkit-scrollbar-track{background: #333;border: 0px none #333;border-radius: 0px;}
    ::-webkit-scrollbar-track:hover{background: #333;}
    ::-webkit-scrollbar-track:active{background: #333;}
    ::-webkit-scrollbar-corner{background: transparent;}
</style>

</head>
<body>
<canvas style="position:fixed;left:0;top:0;z-index:-3;" id="bgcan"></canvas>
<center class="outline">
<b>
<script type="text/javascript" src="//ra.revolvermaps.com/0/0/3.js?i=0ugbfo9y0be&amp;b=0&amp;s=40&amp;m=2&amp;cl=ff8a00&amp;co=ffc000&amp;cd=ff0000&amp;v0=88&amp;v1=0&amp;r=1" async="async"></script>
<br><br>
<?php if(!isset($_GET['h'])){echo "<a style=\"cursor:pointer;\" onclick=\"javascript:makePopup(location.href);\">[^]</a> ";} ?>
<a href="/" style="color:#ffbf00;"><?php if(isset($_GET['h'])){echo "< ";} echo $_SERVER['HTTP_HOST'];?></a>
<?php if(isset($_GET['h'])){echo " <a style=\"cursor:pointer;\" href=\"?r=".$_GET['h']."\" target=\"_blank\">[R]</a>";} ?>
<br><br>
<?php
    if(isset($_GET['h']))
    {
        $links = explode(PHP_EOL, file_get_contents('oix/'.strtolower($_GET['h']).'.txt'));
        foreach($links as $l)
        {
            if($l == ""){continue;}
            $l = trim($l);
            echo '<hr><a href="http://'.htmlspecialchars($_GET['h']).'/'.htmlspecialchars($l).'" rel="nofollow" target="_blank">' . htmlspecialchars($l) . "</a><br>";
        }
        echo '<hr>';
    }
    else
    {
        $ar = glob('oix/*.txt');
        foreach($ar as $k)
        {
            $n = str_replace('oix/', '', str_replace('.txt', '', $k));
            echo '<hr><a href="?h='.htmlspecialchars($n).'">' . clrStr(htmlspecialchars($n)) . "</a><br>";
        }
        echo '<hr>';
    }
?>
<br>
</b>
</center>
</body>
<script>
function makePopup(url)
{
    var w = 380;
    var h = 570;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url, "oix;" + url, "top="+top+", left="+left+", width="+w+", height="+h+", resizable=yes, toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, copyhistory=no").focus();
}
var c1=[255,0,0],c2=[0,255,0],rule=[0,1,0,1,0,1,0,1],seed=33;function setPixel(a,e,t,i,g,n,r){index=4*(e+t*a.width),a.data[index+0]=i,a.data[index+1]=g,a.data[index+2]=n,a.data[index+3]=r}function random(){var a=1e4*Math.sin(seed++);return a-Math.floor(a)}function gp(a,e,t){return index=4*(e+t*a.width),a.data[index+0]==c1[0]&&a.data[index+1]==c1[1]&&a.data[index+2]==c1[2]?0:1}function setup(){for(seed=Math.random(),i=0;i<7;++i)rule[i]=Math.floor(2*random());console.log("Rule: "+rule[0].toString()+"."+rule[1].toString()+"."+rule[2].toString()+"."+rule[3].toString()+"."+rule[4].toString()+"."+rule[5].toString()+"."+rule[6].toString()+"."+rule[7].toString()),c1[0]=255,c1[1]=202,c1[2]=52,c2[0]=255,c2[1]=123,c2[2]=54,drawCanvas()}function resizeCanvas(){element.width=window.innerWidth,element.height=window.innerHeight,imageData=c.createImageData(element.width,element.height),drawCanvas()}function drawCanvas(){var a=element.width,e=element.height;for(y=0;y<e;++y)for(x=0;x<a;++x)setPixel(imageData,x,y,c2[0],c2[1],c2[2],255);for(x=0;x<a;++x)r=Math.floor(2*Math.random()),1==r&&setPixel(imageData,x,0,c1[0],c1[1],c1[2],255);var t=Math.floor(8500*Math.random());for(i=0;i<t;++i)setPixel(imageData,Math.floor(Math.random()*a),Math.floor(Math.random()*e),c1[0],c1[1],c1[2],255);for(a--,y=1;y<e;++y)for(x=1;x<a;++x)1==rule[0]&&1==gp(imageData,x-1,y-1)&&1==gp(imageData,x,y-1)&&1==gp(imageData,x+1,y-1)&&setPixel(imageData,x,y,c1[0],c1[1],c1[2],255),1==rule[1]&&1==gp(imageData,x-1,y-1)&&1==gp(imageData,x,y-1)&&0==gp(imageData,x+1,y-1)&&setPixel(imageData,x,y,c1[0],c1[1],c1[2],255),1==rule[2]&&1==gp(imageData,x-1,y-1)&&0==gp(imageData,x,y-1)&&1==gp(imageData,x+1,y-1)&&setPixel(imageData,x,y,c1[0],c1[1],c1[2],255),1==rule[3]&&1==gp(imageData,x-1,y-1)&&0==gp(imageData,x,y-1)&&0==gp(imageData,x+1,y-1)&&setPixel(imageData,x,y,c1[0],c1[1],c1[2],255),1==rule[4]&&0==gp(imageData,x-1,y-1)&&1==gp(imageData,x,y-1)&&1==gp(imageData,x+1,y-1)&&setPixel(imageData,x,y,c1[0],c1[1],c1[2],255),1==rule[5]&&0==gp(imageData,x-1,y-1)&&1==gp(imageData,x,y-1)&&0==gp(imageData,x+1,y-1)&&setPixel(imageData,x,y,c1[0],c1[1],c1[2],255),1==rule[6]&&0==gp(imageData,x-1,y-1)&&0==gp(imageData,x,y-1)&&1==gp(imageData,x+1,y-1)&&setPixel(imageData,x,y,c1[0],c1[1],c1[2],255),1==rule[7]&&0==gp(imageData,x-1,y-1)&&0==gp(imageData,x,y-1)&&0==gp(imageData,x+1,y-1)&&setPixel(imageData,x,y,c1[0],c1[1],c1[2],255);c.putImageData(imageData,0,0)}element=document.getElementById("bgcan"),c=element.getContext("2d"),window.addEventListener("resize",resizeCanvas,!1),resizeCanvas(),setup();
</script>
</html>


