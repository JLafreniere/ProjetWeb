<?php
$xmlDoc=new DOMDocument();
$xmlDoc->load("pages.xml");

$x=$xmlDoc->getElementsByTagName('link');
function nav_inner($path){
 
  echo $path;
}
//get the q parameter from URL
$q=$_GET["q"];

//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";
  for($i=0; $i<($x->length); $i++) {
    $y=$x->item($i)->getElementsByTagName('title');
    $z=$x->item($i)->getElementsByTagName('url');
    if ($y->item(0)->nodeType==1) {
      //find a link matching the search text
      if (stristr($y->item(0)->childNodes->item(0)->nodeValue,$q)) {
        if ($hint=="") {
          $hint="<a href='" . 
          nav_inner($z->item(0)->childNodes->item(0)->nodeValue) . 
          "' target='_self'>" . 
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        } else {
          $hint=$hint . "<br /><a href='" . 
           nav_inner($z->item(0)->childNodes->item(0)->nodeValue) . 
          "' target='_self'>" . 
          $y->item(0)->childNodes->item(0)->nodeValue . "</a>";
        }
      }
    }
  }
}

// Set output to "no suggestion" if no hint was found
// or to the correct values
if ($hint=="") {
  $response="Aucune page trouvée.";
} else {
  $response=$hint;
}

//output the response
echo $response;
?>