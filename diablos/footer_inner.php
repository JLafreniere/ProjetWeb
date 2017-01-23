<?php 
function footer_inner($path){
  echo $path;
}
?>


<div class="navbar navbar-default ">
  <div class="container">

  <img src="<?php footer_inner("Images/diablos.png") ?>">
  <span class="mediaSociaux"> 
  <a href="https://twitter.com/diablos_cegeptr" target="_blank"><img src="<?php footer_inner("Images/twitter.png") ?>"></a>
  <a href="https://www.facebook.com/les.diablos" target="_blank"><img src="<?php footer_inner("Images/facebook.png") ?>"></a>
  <a href="https://www.youtube.com/watch?v=ANJcY48Yaj0&feature=share&list=PLB004A251E9ED8DC2" target="_blank"><img src="<?php footer_inner("Images/youtube.png") ?>"></a>
  </span>

  </div>
</div>