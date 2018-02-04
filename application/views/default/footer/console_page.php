<button onclick="topFunction()" id="myBtn" title="Go to top"><img src="<?php echo base_url();?>public/top.png" /> </button>
<!--<a href="#" onclick="topFunction()" id="myBtn" title="Go To Top"><img src="<?php echo base_url();?>public/top.png" /></a>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<style>

</style>
<script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery-1.9.1.min.js'>\x3C/script>");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}    
</script>