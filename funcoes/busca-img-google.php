<?php
/*function searchImage($search){

$url="http://www.bing.com/images/search?pq=".urlencode(strtolower($search))."&count=50&q=".urlencode($search);
$data=file_get_contents($url);

$rr=explode("<div class=\"item\">", $data);
$execc="";
for($r=2;$r<(count($rr));$r++){
    $nf=explode("\"", $rr[$r]);
    $nextFile=$nf[1];
    $no="stock;123;dreams";
    $x=true;
    $tt=explode(";", $no);
    for($a=0;$a<count($tt);$a++){

            if(strpos($nextFile, $tt[$a])!=false){
                    $x=false;
            }
    }
    if($x==true){
            $nextFil[]=$nextFile;
    }
}
return $nextFil;
}

//print_r(searchImage('Benfeitorias'));
?>
<img src="<?=searchImage('Sindico')[2];?>" alt="">
<?
exit;*/

 class wwwebbot{

	public $getcontent = ''; 
	public $codeout	= ''; 
	public $output = ''; 
	public $msgout = ''; 
	
	public $optrequest = array();
	
	public $multicontent = ''; 
	public $content = ''; 
	public $errcode = ''; 
	public $errmsg = ''; 
   
    public function init(){

	$initcurl = curl_init();
	
	if(!function_exists('curl_setopt_array')){
		function curl_setopt_array(&$init,$options){
			foreach ($options as $option => $value) {
				curl_setopt($init, $option, $value);
			}
			return true;                       
		}
	}
	
	curl_setopt_array($initcurl,$this->optrequest);
	$this->getcontent=curl_exec($initcurl);
	$this->multicontent=curl_multi_getcontent($initcurl);
	$this->codeout=curl_errno($initcurl);
	$this->msgout=curl_error($initcurl);
	$this->output=curl_getinfo($initcurl);
	curl_close($initcurl);                       
	}
}

function buscaImgGoogle($tag) {
	$tag = str_replace(' ', '+', $tag);
	$bot = new wwwebbot();
					
	$bot->optrequest = array(
	CURLOPT_URL => 'http://www.google.com.br/search?tbm=isch&source=lnt&tbs=isz:m&sa=X&dpr=1&biw=1366&bih=643&q='.$tag.'', 
		CURLOPT_RETURNTRANSFER => TRUE,
		CURLOPT_HEADER           => FALSE);

	$bot->init();
	
	$url = preg_match_all('/src="http:\/\/t3.gstatic.com\/images\?([^"]++)"/i',$bot->multicontent,$goo); 
	/*for($i=0;$i<$url;$i++):
	echo '<img src="http://t3.gstatic.com/images?'. $goo[1][$i] .'"> <P>'; 
	endfor;*/
	//echo '<img src="http://t3.gstatic.com/images?'. $goo[1][0] .'"> <P>'; 
	return("http://t3.gstatic.com/images?{$goo[1][0]}");
}
?>